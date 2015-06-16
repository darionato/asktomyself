using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Text.RegularExpressions;
using asktomyself.askmeWsdlService;

namespace asktomyself.wsdl
{

    public enum resultAddWord
    {
        ok = 1, query_error = 2, bad_login = 4, word_already_exists = 8
    };

    public enum settingsUserEnum
    {
        minute_to_ask = 1, last_category = 2, invert = 3, download_images = 4
    };

    public enum methodsAsync
    {
        try_login = 1, get_new_question = 2, add_new_word = 3, set_question = 4,
        get_categories = 5, get_settings = 6, set_setting = 7, is_there_update_available = 8,
        get_missing_count = 9
    };

    public enum loginConnectionStatus
    {
        login_right = 1, login_wrong = 2, network_error = 3
    };

    public delegate void AskMeMethodResult(object sender, resultAddWord result);
    public delegate void AskMeMethodResultString(object sender, string result);
    public delegate void AskMeMethodResultBool(object sender, bool result);
    public delegate void AskMeMethodResultInt(object sender, int result);
    public delegate void AskMeMethodResultLogin(object sender, loginConnectionStatus result);
    public delegate void AskMeStartAsyncMethod(object sender, methodsAsync method);

    public class askmewsdl
    {

        asktomyself.askmeWsdlService.askmewsdl _web_reference;
        public event AskMeMethodResult AddWordComplete;
        protected event AskMeMethodResultString getQuestionComplete;
        protected event AskMeMethodResultLogin tryLoginComplete;
        public event AskMeStartAsyncMethod StartAsyncMethod;
        public event AskMeMethodResultBool setQuestionComplete;
        public event AskMeMethodResultBool setSettingComplete;
        public event AskMeMethodResultString getCategoriesComplete;
        public event AskMeMethodResultString getSettingsComplete;
        public event AskMeMethodResultString getUpdateAvailableComplete;
        public event AskMeMethodResultInt getMissingLoginComplete;

        public askmewsdl()
        {
            // set the web reference
            _web_reference = new askmeWsdlService.askmewsdl();
            _web_reference.add_wordCompleted += new add_wordCompletedEventHandler(_web_reference_add_wordCompleted);
            _web_reference.get_questionCompleted += new get_questionCompletedEventHandler(_web_reference_get_questionCompleted);
            _web_reference.try_loginCompleted += new try_loginCompletedEventHandler(_web_reference_try_loginCompleted);
            _web_reference.set_questionCompleted += new set_questionCompletedEventHandler(_web_reference_set_questionCompleted);
            _web_reference.get_categoriesCompleted += new get_categoriesCompletedEventHandler(_web_reference_get_categoriesCompleted);
            _web_reference.get_settingsCompleted += new get_settingsCompletedEventHandler(_web_reference_get_settingsCompleted);
            _web_reference.set_settingCompleted += new set_settingCompletedEventHandler(_web_reference_set_settingCompleted);
            _web_reference.get_update_availableCompleted += new get_update_availableCompletedEventHandler(_web_reference_get_update_availableCompleted);
            _web_reference.get_missing_countCompleted += new get_missing_countCompletedEventHandler(_web_reference_get_missing_countCompleted);

            User = "";
            Password = "";
            TimeToAskMe = 5; // 5 minutes
        }

        public string User { get; set; }

        public string Password { get; set; }

        public int Category { get; set; }

        /// <summary>
        /// Return how many times to ask a question
        /// </summary>
        public int TimeToAskMe { get; protected set; }

        /// <summary>
        /// Return if the question are asked in evert mode
        /// </summary>
        public bool Invert { get; set; }

        /// <summary>
        /// Return if the programm have to download the image from internet
        /// </summary>
        public bool DownloadImage { get; protected set; }

        protected virtual void OnStartAsyncMethod(methodsAsync method)
        {
            if (StartAsyncMethod != null)
                StartAsyncMethod(this, method);
        }
        
        public void getNewQuestion()
        {
            OnStartAsyncMethod(methodsAsync.get_new_question);
            _web_reference.get_questionAsync(User, Password, Category);
        }

        void _web_reference_get_questionCompleted(object sender, get_questionCompletedEventArgs e)
        {

            try
            {

                if (getQuestionComplete != null)
                    getQuestionComplete(sender, e.Result);

            }
            catch (Exception ex)
            {
                Console.WriteLine("_web_reference_get_questionCompleted: " +
                    ex.Message);
                if (getQuestionComplete != null)
                    getQuestionComplete(sender, null);
            }
        }

        public void AddWord(string from, string to, int cate)
        {
            OnStartAsyncMethod(methodsAsync.add_new_word);
            _web_reference.add_wordAsync(User, Password, from, to, cate);
        }

        void _web_reference_add_wordCompleted(object sender, add_wordCompletedEventArgs e)
        {
            if (AddWordComplete != null)
                AddWordComplete(sender, (resultAddWord)Enum.Parse(typeof(resultAddWord), e.Result.ToString()));
        }

        protected void CheckMissingLogin()
        {
            OnStartAsyncMethod(methodsAsync.get_missing_count);
            _web_reference.get_missing_countAsync(User, Password, 1);
        }

        void _web_reference_get_missing_countCompleted(object sender, get_missing_countCompletedEventArgs e)
        {
            if (getMissingLoginComplete != null)
                getMissingLoginComplete(sender, e.Result);
        }

        void _web_reference_try_loginCompleted(object sender, try_loginCompletedEventArgs e)
        {

            if (tryLoginComplete != null)
            {

                try
                {
                    tryLoginComplete(sender,
                        (e.Result ? loginConnectionStatus.login_right : loginConnectionStatus.login_wrong));
                }
                catch (Exception ex)
                {
                    Console.WriteLine(ex.Message);
                    tryLoginComplete(sender, loginConnectionStatus.network_error);
                }

            }

        }

        protected void TryLogin()
        {
            OnStartAsyncMethod(methodsAsync.try_login);
            _web_reference.try_loginAsync(User, Password);
        }

        public void setQuestion(int id_word, string responce)
        {
            OnStartAsyncMethod(methodsAsync.set_question);
            _web_reference.set_questionAsync(User, Password, Category, id_word, responce, Invert);
        }

        void _web_reference_set_questionCompleted(object sender, set_questionCompletedEventArgs e)
        {
            if (setQuestionComplete != null)
                setQuestionComplete(sender, e.Result);
        }

        public void getCategories()
        {
            OnStartAsyncMethod(methodsAsync.get_categories);
            _web_reference.get_categoriesAsync(User, Password);
        }
        
        void _web_reference_get_categoriesCompleted(object sender, get_categoriesCompletedEventArgs e)
        {
            if (getCategoriesComplete != null)
                getCategoriesComplete(sender, e.Result);
        }

        public void getSettings()
        {
            OnStartAsyncMethod(methodsAsync.get_settings);
            _web_reference.get_settingsAsync(User, Password);
        }

        void _web_reference_get_settingsCompleted(object sender, get_settingsCompletedEventArgs e)
        {
            if (getSettingsComplete != null)
                getSettingsComplete(sender, e.Result);
        }

        public void setSetting(settingsUserEnum id_setting, string value_setting)
        {
            OnStartAsyncMethod(methodsAsync.set_setting);
            _web_reference.set_settingAsync(User, Password, (int)id_setting, value_setting);
        }

        void _web_reference_set_settingCompleted(object sender, set_settingCompletedEventArgs e)
        {
            if (setSettingComplete != null)
                setSettingComplete(sender, e.Result);
        }

        public void isThereUpdateAvailable(string actal_version)
        {
            OnStartAsyncMethod(methodsAsync.is_there_update_available);
            _web_reference.get_update_availableAsync(User, Password, actal_version);
        }

        void _web_reference_get_update_availableCompleted(object sender, get_update_availableCompletedEventArgs e)
        {
            if (getUpdateAvailableComplete != null)
                getUpdateAvailableComplete(sender, e.Result);
        }

    }

}
