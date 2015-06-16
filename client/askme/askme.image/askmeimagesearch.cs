using System;
using System.Collections;
using System.Configuration;
using System.Diagnostics;
using System.IO;
using System.Net;
using System.Text.RegularExpressions;
using System.Drawing;

namespace asktomyself.google.API.image
{
	/// <summary>
	/// A search utility used to retrieve images using Google Image Search.
	/// Since Google does not provide a proper API for their image search, this utility parses the html
	/// returned from running an image search query. Therefore, if Google will change the format of the
	/// returned html file, the parsing may fail and need to be adapted to succeed.
	/// This utility conforms to the html format used on October 5th 2005.
	/// </summary>
	public class SearchService
	{
		/// <summary>Google limits the results it returns to the first 1000 results for each query</summary>
		public const int MAX_RESULTS = 1000;
		/// <summary>Google returns up to 20 images each time a search is performed</summary>
		private const int RESULTS_PER_QUERY = 1;


        public Image getImage(string query)
        {

            if (string.IsNullOrEmpty(query)) return null;

            int startPosition = 0;
            int resultsRequested = 1;
            SafeSearchFiltering safeSearch = SafeSearchFiltering.Off;

            query = Regex.Replace(query, @"\s{1,}", "+");

            SearchResponse response =
                SearchImages( query, startPosition, resultsRequested, false, safeSearch);

            if (response.Results.Length == 0) return null;
            
            return getImageFromUrl(response.Results[0].ThumbnailUrl);

        }

        private Image getImageFromUrl(string url)
        {
            Image im = null;
            try
            {
                HttpWebRequest request = (HttpWebRequest)WebRequest.Create(url);
                request.Method = "GET";
                request.Timeout = 15000;
                request.ProtocolVersion = HttpVersion.Version11;

                using (HttpWebResponse response = (HttpWebResponse)request.GetResponse())
                {
                    using (Stream responseStream = response.GetResponseStream())
                    {
                        im = Image.FromStream(responseStream);
                    }
                }
            }
            catch (Exception ex)
            {
                Debug.WriteLine("Exception in getThumbnail. Url: " + url + ". Info: " + ex.Message + Environment.NewLine + "Stack: " + ex.StackTrace);
            }
            return im;
        }

		/// <summary>
		/// Runs the given query against Google Image Search and returns a SearchResponse object with details
		/// for each returned image.
		/// </summary>
		/// <param name="query">The query to be sent.</param>
		/// <param name="startPosition">The index of the first item to be retrieved (must be positive).</param>
		/// <param name="resultsRequested">The number of results to be retrieved (must be between 1 and (MAX_RESULTS - startPosition)</param>
		/// <param name="filterSimilarResults">Set to 'true' if you want Google to automatically omit similar entries. Set to 'false' if you want to retrieve every matching image.</param>
		/// <param name="safeSearch">Indicates what level of SafeSearch to use.</param>
		/// <returns>A SearchResponse object with details for each returned image.</returns>
		private SearchResponse SearchImages(string query, int startPosition, int resultsRequested, bool filterSimilarResults, SafeSearchFiltering safeSearch)
		{
			// Check preconditions
			if (resultsRequested < 1)
			{
				throw new ArgumentOutOfRangeException("resultsRequested", "Value must be positive");
			}
			else if (startPosition < 0)
			{
				throw new ArgumentOutOfRangeException("startPosition", "Value must be positive");
			}
			else if (resultsRequested + startPosition > MAX_RESULTS)
			{
				throw new ArgumentOutOfRangeException("resultsRequested", "Sorry, Google does not serve more than 1000 results for any query");
			}
			
			string safeSearchStr = safeSearch.ToString().ToLower();
			SearchResponse response = new SearchResponse();
			ArrayList results = new ArrayList();
			
			for (int i = 0; i < resultsRequested; i+=RESULTS_PER_QUERY)
			{
				string requestUri = string.Format("http://images.google.com/images?q={0}&ndsp={1}&start={2}&filter={3}&safe={4}",
                    query, RESULTS_PER_QUERY.ToString(),(startPosition + i).ToString(), (filterSimilarResults) ? "1" : "0", safeSearchStr);

				HttpWebRequest request = (HttpWebRequest)WebRequest.Create(requestUri);
				string resultPage = string.Empty;
				using (HttpWebResponse httpWebResponse = (HttpWebResponse)request.GetResponse())
				{
					using (Stream responseStream = httpWebResponse.GetResponseStream())
					{
						using (StreamReader reader = new StreamReader(responseStream))
						{
							resultPage = reader.ReadToEnd();
						}
					}
				}


                var imagesRegex = new Regex(
                    @"""(http://[a-z0-9.\/_-]+\.jpg)"",""([0-9]+)"",""([0-9]+)"",", 
                    RegexOptions.IgnoreCase);

                MatchCollection imagesMatches = imagesRegex.Matches(resultPage);


                foreach (Match m in imagesMatches)
                {
                    SearchResult result = new SearchResult();
                    result.ThumbnailUrl = m.Groups[1].Value;
                    result.ThumbnailWidth = int.Parse(m.Groups[2].Value);
                    result.ThumbnailHeight = int.Parse(m.Groups[3].Value);
                    results.Add(result);
                    break;
                }

			}

			response.Results = (SearchResult[]) results.ToArray(typeof(SearchResult));

			return response;
		}
	}

	/// <summary>
	/// Used to specify Google's SafeSearch setting. Google's SafeSearch blocks web pages containing 
	/// explicit sexual content from appearing in search results.
	/// </summary>
	public enum SafeSearchFiltering
	{
		/// <summary>
		/// Filter both explicit text and explicit images (a.k.a. Strict Filtering).
		/// </summary>
		Active,	
		/// <summary>
		/// Filter explicit images only - default behavior.
		/// </summary>
		Moderate,
		/// <summary>
		/// Do not filter the search results.
		/// </summary>
		Off
	}
}
