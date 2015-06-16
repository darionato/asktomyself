using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Text.RegularExpressions;
using System.Configuration;
using System.Timers;
using System.Data;
using System.Security.Cryptography;
using asktomyself.core;
using asktomyself.wsdl;
using asktomyself.google.API.image;
using asktomyself.category;

namespace asktomyself.core
{

    public delegate void AskMeCoreQuestionReady(object sender, structQuestion question);

    public class askmecore : askmewsdl
    {

        private string REGEXP_FIND_WORD = @"\d\wÚ‡È·ÌÛ‰Îiˆ˙‡ËÏ˘ ?.,;&'\Ä\/\*\+\-\$\£\%\(\)";
        public event AskMeCoreQuestionReady QuestionReadyToAsk;
        public event AskMeMethodResultBool AskMeReadyToGo;
        public event AskMeMethodResultString LoginFailed;
        public event AskMeMethodResultInt OverLoginLimits;

        Regex _match;
        Timer _timer;

        public askmecore()
            :base()
        {
            // set up property
            ReadyToGo = false;

            // prepare expression to get the question to ask
            _match = new Regex(string.Format(
                @"\(([0-9]+):([{0}]+):([{0}]+)\)", REGEXP_FIND_WORD), 
                RegexOptions.IgnoreCase);

            // add events
            base.tryLoginComplete += new AskMeMethodResultLogin(askmecore_tryLoginComplete);
            base.getQuestionComplete += new AskMeMethodResultString(askmecore_getQuestionComplete);
            base.getCategoriesComplete += new AskMeMethodResultString(askmecore_getCategoriesComplete);
            base.getSettingsComplete += new AskMeMethodResultString(askmecore_getSettingsComplete);
            base.getMissingLoginComplete += new AskMeMethodResultInt(askmecore_getMissingLoginComplete);
        }

        /// <summary>
        /// Get all categories of logged user
        /// </summary>
        public List<atm_category> Categories { get; private set; }

        /// <summary>
        /// Check if the login is done and the public methods are available
        /// </summary>
        public bool ReadyToGo { get; private set; }

        /// <summary>
        /// Get all settings from the website and set up the class
        /// </summary>
        void askmecore_getSettingsComplete(object sender, string result)
        {

            Regex r = new Regex(@"\(([\w]+):([\d|\w ]+)\)", RegexOptions.IgnoreCase);

            MatchCollection c = r.Matches(result);

            foreach (Match m in c)
            {
                switch (m.Groups[1].Value)
                {
                    case "1": // time_out_ask
                        base.TimeToAskMe = int.Parse(m.Groups[2].Value);
                        break;
                    case "2": // last_category
                        base.Category = int.Parse(m.Groups[2].Value);
                        break;
                    case "3": // invert
                        base.Invert = (m.Groups[2].Value == "1" ? true : false);
                        break;
                    case "4": // dowload_image
                        base.DownloadImage = (m.Groups[2].Value == "1" ? true : false);
                        break;
                }
            }

            // raise the event that whole class is ready to work
            if (AskMeReadyToGo != null)
                AskMeReadyToGo(sender, ReadyToGo);
        }

        /// <summary>
        /// When i get the categories, i sort them onto an array of structures
        /// </summary>
        void askmecore_getCategoriesComplete(object sender, string result)
        {

			// check for right reserch string. from 1.0.0.2 the second one will be useless
			string f;
			bool with_shared = true;
			
			if (result.Contains(",[0],") || result.Contains(",[1],"))
			    f = string.Format(
                    @"\(\[([\d]+)\],\[([0-1])\],\[([{0}]*)\],\[([{0}]*)\],\[([{0}]*)\]\)",
                    REGEXP_FIND_WORD);
			else
			{
			    f = @"\(([\d]+),([\w\s_-]+)\)";
				with_shared = false;
			}
			    
			// this reg-ex find (code, shared [0-1], description, wrap question, wrap label)
            Regex r = new Regex(f, RegexOptions.IgnoreCase);

            MatchCollection ms = r.Matches(result);

            ReadyToGo = (ms.Count > 0);

            Categories = new List<atm_category>();

            foreach (Match m in ms)
            {
                atm_category c = new atm_category();
                c.Id = int.Parse(m.Groups[1].Value);
				
				if (with_shared)
				{
	                c.Description = m.Groups[3].Value.ToString();
					c.Shared = (string.Compare(
								m.Groups[2].Value.ToString(), "1") == 0);
                    c.WrapQuestion = m.Groups[4].Value.ToString();
                    c.WrapAnswer = m.Groups[5].Value.ToString();
				}
				else
				{
					c.Description = m.Groups[2].Value.ToString();
					c.Shared = false;
				}
				
                Categories.Add(c);
            }

            // throw the call to get the settings
            base.getSettings();

        }

        /// <summary>
        /// Is throw when the web service return the question do ask
        /// </summary>
        void askmecore_getQuestionComplete(object sender, string result)
        {
            if (result == null || result.Length == 0)
            {
                this.restart_timer();
                return;
            }

            // search the pieces. The first one is the right answer.
            MatchCollection q = _match.Matches(result);
            structQuestion ret = new structQuestion();

            try
            {

                // set the value on the structure
                ret.Id = int.Parse(q[0].Groups[1].Value);
                ret.From = q[0].Groups[2].Value;
                ret.To = q[0].Groups[3].Value;

                // download the image
                if (base.DownloadImage)
                {
                    SearchService img = new SearchService();
                    ret.Thunbnail = img.getImage(ret.From);
					img = null;
                }

                // raise the event
                if (QuestionReadyToAsk != null)
                {
                    QuestionReadyToAsk(sender, ret);
                    _timer.Enabled = false;
                }

            }
            catch (Exception ex)
            {
                Console.WriteLine("getQuestionComplete: " + ex.Message);
                this.restart_timer();
            }

        }

        private void restart_timer()
        {
            // restart the timer
            _timer.Enabled = false;
            _timer.Enabled = true;
        }

        /// <summary>
        /// Set if the login is correct, if yes, start the timer
        /// </summary>
        void askmecore_tryLoginComplete(object sender, loginConnectionStatus result)
        {
            switch (result)
            {
                case loginConnectionStatus.login_right:
                    base.getCategories();
                    break;
                case loginConnectionStatus.login_wrong:
                    if (LoginFailed != null)
                        LoginFailed(sender,
                            "Your e-mail or password were not recognized! Check and try again.");
                    break;
                case loginConnectionStatus.network_error:
                    if (LoginFailed != null)
                        LoginFailed(sender,
                            "Network error. Try again later.");
                    break;
            }

        }

        /// <summary>
        /// 
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="result"></param>
        void askmecore_getMissingLoginComplete(object sender, int result)
        {
            if (result > 0)
                // try the login
                base.TryLogin();
            else
                // over limit
                if (OverLoginLimits != null)
                    OverLoginLimits(sender, result);
        }

        /// <summary>
        /// throw the question
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        void _timer_Elapsed(object sender, ElapsedEventArgs e)
        {
            this.Stop();
            base.getNewQuestion();
        }

        /// <summary>
        /// Start ask questions
        /// </summary>
        public void Start()
        {
            // Start the timer to ask questions
            if (ReadyToGo)
            {
                _timer = new Timer((TimeToAskMe * 60) * 1000);
                _timer.Elapsed += new ElapsedEventHandler(_timer_Elapsed);
                _timer.Enabled = true;
            }
        }

        /// <summary>
        /// Stop ask questions
        /// </summary>
        public void Stop()
        {
            if (_timer != null) _timer.Enabled = false;
        }

        /// <summary>
        /// Return if class keep ask you
        /// </summary>
        public bool InAsking
        {
            get 
            {
                if (_timer == null) return false;
                return _timer.Enabled; 
            }
        }

        /// <summary>
        /// Try Login to the webserver
        /// </summary>
        /// <param name="u">Username</param>
        /// <param name="p">Password</param>
        public void DoLogin(string u, string p)
        {
            // make the login
            base.User = u;
            base.Password = this.CalculateSHA1(p).ToLower();

            // check limits
            base.CheckMissingLogin();
        }

        /// <summary>
        /// get the sha1 of a string
        /// </summary>
        /// <param name="text"></param>
        /// <param name="enc"></param>
        /// <returns></returns>
        private string CalculateSHA1(string text)
        {
            byte[] buffer = Encoding.Default.GetBytes(text);
            SHA1CryptoServiceProvider cryptoTransformSHA1 =
            new SHA1CryptoServiceProvider();
            string hash = BitConverter.ToString(
                cryptoTransformSHA1.ComputeHash(buffer)).Replace("-", "");

            return hash;
        }

    }
}
