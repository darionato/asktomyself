using System;
using System.Diagnostics;
using System.Text.RegularExpressions;

namespace asktomyself.google.API.image
{
	/// <summary>
	/// The response object that stores an image search response from Google Image Search.
	/// For each image returned we get the original image url and the thumbnail url.
	/// Also, for each search response we get the total number of available results for the query.
	/// </summary>
	public class SearchResponse
	{

		public SearchResponse()
		{
			this.Results = new SearchResult[0];
		}

		public SearchResult[] Results  { get; set;}
		
	}

	/// <summary>
	/// Information returned from Google Image Search for each image.
	/// </summary>
	public class SearchResult
	{

		public int ThumbnailWidth { get; set; }

		public int ThumbnailHeight { get; set; }

        public string ThumbnailUrl { get; set; }

	}
}
