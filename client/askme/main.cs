using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Configuration;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Timers;
using System.Text;
using System.Windows.Forms;
using System.Reflection;
using System.IO;
using asktomyself.core;
using asktomyself.wsdl;
using asktomyself.conf;
using asktomyself.crypt;
using asktomyself.path;
using asktomyself.category;
using asktomyself.check;

namespace asktomyself
{

    public enum enumIcon
    {
        gray,
        asking,
        stop,
        invert,
        timer_stop,
        timer_play,
        gray_left,
        gray_middle,
        stop_invert
    }

    public partial class main : Form
    {

        private Int16 _MAX_COUNTDOWN = 30;

        NotifyIcon _tray_icon;
        askmecore _ask_me;
        System.Timers.Timer _timer_in_connecting;
        Int16 _num_in_connecting = 0;
        bool _force_close = false;
        bool _in_asking = false;
        System.Timers.Timer _count_down;
        Int16 _num_count_down = 0;

        public main()
        {
            InitializeComponent();
            this.FormClosing += new FormClosingEventHandler(main_FormClosing);
        }

        void main_FormClosing(object sender, FormClosingEventArgs e)
        {
            if (e.CloseReason == CloseReason.WindowsShutDown) _force_close = true;

            e.Cancel = (_force_close == false);
            this.Hide();

            // start the timer if i close the window with the X
            if (e.Cancel == true && _in_asking == true)
            {
                // if the time is over
                if (_count_down.Enabled == false)
                {
                    // unbox the question info
                    structQuestion q = (structQuestion)txtTo.Tag;
                    _ask_me.setQuestion(q.Id, txtTo.Text.Trim());
                }
                _ask_me.Start();
            }
        }

        private void main_Load(object sender, EventArgs e)
        {
            // start main window and i put it on the tray
            _tray_icon = new NotifyIcon();
            _tray_icon.Icon = getIconByIndex(enumIcon.gray);
            _tray_icon.Text = Application.ProductName;
            _tray_icon.Visible = true;

            // gasp the comune events
            aboutAskToMyselfToolStripMenuItem.Click +=new EventHandler(aboutAskToMyselfToolStripMenuItem_Click);
            aboutAskToMyselfToolStripMenuItem1.Click += new EventHandler(aboutAskToMyselfToolStripMenuItem_Click);
            exitToolStripMenuItem.Click += new EventHandler(exitToolStripMenuItem_Click);
            exitToolStripMenuItem1.Click += new EventHandler(exitToolStripMenuItem_Click);

            // initialize the timer
            _count_down = new System.Timers.Timer(1000);
            _count_down.Elapsed += new ElapsedEventHandler(_CountDown_Elapsed);
            _num_count_down = this._MAX_COUNTDOWN;

        }

        private void ShowBallonPause()
        {
            
            _tray_icon.ShowBalloonTip(30,
                Application.ProductName + " is in pause",
                "Double click in the icon to start asking again",
                ToolTipIcon.Info);

        }

        private void ShowBallonIntervalTime()
        {

            _tray_icon.ShowBalloonTip(30, 
                string.Format(
                "Wait {0} minute{1} for the first question", 
                _ask_me.TimeToAskMe, _ask_me.TimeToAskMe == 1?"":"s"),
                "You can change the minutes on your web account",
                ToolTipIcon.Info);

        }

        void _CountDown_Elapsed(object sender, ElapsedEventArgs e)
        {
            this.Invoke((Action)(() =>
            {
                if (_num_count_down == 0)
                {
                    this.ShowSolution();
                }
                else
                {
                    _num_count_down -= 1;
                    this.lblCountdown.Text = _num_count_down.ToString();
                    if (_num_count_down == 5)
                        this.lblCountdown.ForeColor = Color.DarkRed;
                }
            }));

        }
        
        /// <summary>
        /// get an icon from executing assembly
        /// </summary>
        /// <param name="i">what icon?</param>
        /// <returns>Icon</returns>
        private Icon getIconByIndex(enumIcon i)
        {
            Assembly a = Assembly.GetExecutingAssembly();
            
            Bitmap the_bitmap = new Bitmap(
                a.GetManifestResourceStream(
                    i.ParseToName()
                    ));

            IntPtr iii = the_bitmap.GetHicon();
            Icon ic = Icon.FromHandle(iii);
            return ic;
        }

        private void exitToolStripMenuItem_Click(object sender, EventArgs e)
        {
            _force_close = true;
            _tray_icon.Visible = false;
            this.Close();
        }

        private void addToolStripMenuItem_Click(object sender, EventArgs e)
        {
            bool was_in_asking = _ask_me.InAsking;
            if (was_in_asking) _ask_me.Stop();
            try
            {
                form_add_word add = new form_add_word(_ask_me);
                add.ShowDialog();
            }
            catch (Exception ex)
            {
                Console.WriteLine(ex.Message);
            }
            if (was_in_asking) _ask_me.Start();
        }

        private LoginSettings getSettings()
        {

            LoginSettings ret = new LoginSettings();
            string fileConf = askmepath.PathConfiguration;

            ret.UserName = askmeconf.getAskSetting(fileConf, "username");
            ret.Password = askmecrypt.Decrypt(askmeconf.getAskSetting(fileConf, "password"), "atm983",true);

            return ret;
        }

        private void main_Shown(object sender, EventArgs e)
        {
            
            // hide this window
            this.Visible = false;
            this.ShowInTaskbar = false;
            this.Hide();
            this.stopAskToMyselfToolStripMenuItem.Image = 
                this.getIconByIndex(enumIcon.timer_stop).ToBitmap();

            // istance the main class and try the login
            _ask_me = new askmecore();
            _ask_me.StartAsyncMethod += new AskMeStartAsyncMethod(_ask_me_StartAsyncMethod);
            _ask_me.AskMeReadyToGo += new AskMeMethodResultBool(_ask_me_AskMeReadyToGo);
            _ask_me.QuestionReadyToAsk += new AskMeCoreQuestionReady(_ask_me_QuestionReadyToAsk);
            _ask_me.LoginFailed += new AskMeMethodResultString(_ask_me_LoginFailed);
            _ask_me.getUpdateAvailableComplete += new AskMeMethodResultString(_ask_me_getUpdateAvailableComplete);
            _ask_me.OverLoginLimits += new AskMeMethodResultInt(_ask_me_OverLoginLimits);

            // read the configuration
            LoginSettings set = getSettings();

            // check user - password
            if (set.UserName.Length == 0 || set.Password.Length == 0)
            {
                form_login do_login = new form_login();
                if (do_login.ShowDialog() != System.Windows.Forms.DialogResult.OK)
                {
                    // change menu
                    _tray_icon.ContextMenuStrip = contextMenuStripLogin;
                    return;
                }
                else
                {
                    // re-read the configuration
                    set = do_login.getLoginSettings();
                }
            }

            // try the login
            _ask_me.DoLogin(set.UserName, set.Password);

        }

        void _ask_me_OverLoginLimits(object sender, int result)
        {
            MessageBox.Show("You have reached your daily connection limit, see you tomorrow...",
                Application.ProductName, MessageBoxButtons.OK, MessageBoxIcon.Information);
            // change menu
            _tray_icon.ContextMenuStrip = contextMenuStripLogin;
        }

        void _ask_me_StartAsyncMethod(object sender, methodsAsync method)
        {
            switch (method)
            {
                case methodsAsync.try_login:
                    if (_timer_in_connecting == null)
                    {
                        _timer_in_connecting = new System.Timers.Timer();
                        _timer_in_connecting.Interval = 400;
                        _timer_in_connecting.Elapsed += new ElapsedEventHandler(_timer_in_connecting_Elapsed);
                    }
                    _timer_in_connecting.Enabled = true;
                    break;
            }
        }

        void _timer_in_connecting_Elapsed(object sender, ElapsedEventArgs e)
        {
            Icon i;
            switch (_num_in_connecting)
            {
                case 1:
                    i = getIconByIndex(enumIcon.gray_middle);
                    break;
                case 2:
                    i = getIconByIndex(enumIcon.gray_left);
                    break;
                case 3:
                    i = getIconByIndex(enumIcon.gray_middle);
                    break;
                default:
                    i = getIconByIndex(enumIcon.gray);
                    break;
            }

            _tray_icon.Icon = i;

            _num_in_connecting++;
            if (_num_in_connecting > 3) _num_in_connecting = 0;
        }

        void _ask_me_getUpdateAvailableComplete(object sender, string result)
        {
            // ask if they whants to update the software
            if (result.Length > 0)
            {
                if (MessageBox.Show(
                    string.Format(
                    "New version of {0} ({1}) is available for download.\r\n\r\n" +
                    "Would you like to visit the website to download it?",
                    Application.ProductName, result),
                    "New version available",
                    MessageBoxButtons.YesNo,
                    MessageBoxIcon.Question, MessageBoxDefaultButton.Button1) == DialogResult.Yes)
                {

                    // if yes, i open the url to download the update
                    System.Diagnostics.Process.Start("http://www.asktomyself.com/getit");

                }

            }
        }

        void _ask_me_LoginFailed(object sender, string result)
        {

            // stop the animation
            if (_timer_in_connecting != null)
                _timer_in_connecting.Enabled = false;

            // show the form for a new login
            form_login do_login = new form_login();
            do_login.Title = result;
            if (do_login.ShowDialog() != System.Windows.Forms.DialogResult.OK)
            {
                // change menu
                _tray_icon.ContextMenuStrip = contextMenuStripLogin;
            }
            else
            {
                // read the configuration from the login window
                LoginSettings set = do_login.getLoginSettings();
                _ask_me.DoLogin(set.UserName, set.Password);
            }
        }

        void _ask_me_AskMeReadyToGo(object sender, bool result)
        {

            // stop the animation
            if (_timer_in_connecting != null)
                _timer_in_connecting.Enabled = false;

            // clear the menu
            categoriesToolStripMenuItem.DropDownItems.Clear();

            if (result)
            {
                
                // check if there isn't checked categories
                var check_category = (from x in _ask_me.Categories
                                     where x.Id == _ask_me.Category
                                     select x).FirstOrDefault();

                // if no checked category, set the firt one
                if (check_category == null && _ask_me.Categories.Count > 0)
                {
                    _ask_me.Category = _ask_me.Categories[0].Id;
                    // set the value on the web
                    _ask_me.setSetting(settingsUserEnum.last_category, _ask_me.Category.ToString());
                }


                // populate the categories to switch section
                foreach (atm_category c in _ask_me.Categories)
                {
                    ToolStripMenuItem i = 
                        (ToolStripMenuItem) categoriesToolStripMenuItem.DropDownItems.Add(
                        c.Description,
                        (c.Shared?Properties.Resources.category:Properties.Resources.tag_orange));
                    i.Tag = c;
                    i.Checked = (_ask_me.Category == c.Id);
                    if (i.Checked) this.setLabelsWrap(c);
                    i.Click += new EventHandler(i_Click);
                    if (i.Checked)
                        this.labelCategory.Text = i.Text;
                }

                // set up setting
                invertToolStripMenuItem.Checked = _ask_me.Invert;

                // active the software to use
                _tray_icon.Icon = getIconByIndex(_ask_me.Invert?enumIcon.invert:enumIcon.asking);
                _tray_icon.DoubleClick += new EventHandler(_tray_icon_DoubleClick);
                _tray_icon.ContextMenuStrip = this.contextMenuStripIcon;
                _ask_me.Start();

                // show info
                this.ShowBallonIntervalTime();
            }
            else
                // change menu
                _tray_icon.ContextMenuStrip = contextMenuStripLogin;

            // check the version of the software
            _ask_me.isThereUpdateAvailable(Application.ProductVersion);

        }

        void _tray_icon_DoubleClick(object sender, EventArgs e)
        {
            this.StartStopAsking();
        }

        void i_Click(object sender, EventArgs e)
        {
            // get the menu
            ToolStripMenuItem i = (ToolStripMenuItem)sender;
            
            // uncheck all menu
            foreach (ToolStripMenuItem x in i.Owner.Items)
                x.Checked = false;

            // set the category name
            this.labelCategory.Text = i.Text;

            // unbox the category
            atm_category c = (atm_category)i.Tag;

            // set the category selected
            _ask_me.Category = c.Id;

            // wrap labels
            this.setLabelsWrap(c);

            // set the value on the web
            _ask_me.setSetting(settingsUserEnum.last_category, _ask_me.Category.ToString());

            // check che new category
            i.Checked = true;
        }

        private void setLabelsWrap(atm_category c)
        {

			
			string q = "";
			string a = "";
			
            // wrap question label
            if (string.IsNullOrEmpty(c.WrapQuestion))
                q = "Question:";
            else
                q = c.WrapQuestion + 
					(c.WrapQuestion.EndsWith(":")?"":":");

            // wrap anser label
            if (string.IsNullOrEmpty(c.WrapAnswer))
                a = "Answer:";
            else
                a = c.WrapAnswer + 
					(c.WrapAnswer.EndsWith(":")?"":":");
			
			// set the values to the labels
			this.lblQuestion.Text = (this._ask_me.Invert?a:q);
			this.lblAnswer.Text = (this._ask_me.Invert?q:a);

        }

        void _ask_me_QuestionReadyToAsk(object sender, structQuestion question)
        {
            if (question.Id == 0)
            {
                // if for some reason i don't get the question
                return;
            }
            else
            {
                this.Invoke((Action)(() =>
                {
                    txtFrom.Text = (this.invertToolStripMenuItem.Checked ? question.To : question.From);
                    txtTo.Tag = question;

                    if (question.Thunbnail == null)
                        Thunbnail.Image = this.getDefaultImage();
                    else
                        Thunbnail.Image = question.Thunbnail;

                    // start the countdown
                    _num_count_down = this._MAX_COUNTDOWN;
                    this.lblCountdown.Text = _num_count_down.ToString();
                    this.lblCountdown.ForeColor = Color.Black;

                    _count_down.Start();

                    // show the form
                    this.TopMost = true;
                    this.Visible = true;
                    this.WindowState = FormWindowState.Normal;
                    txtTo.Text = "";
                    txtTo.Focus();
                    _in_asking = true;

                }));
            }
        }

        private Image getDefaultImage()
        {

            Assembly a = Assembly.GetExecutingAssembly();
            Stream s = a.GetManifestResourceStream("asktomyself.Resources.color_black_white.png");
            return Image.FromStream(s);
            
        }

        private void CheckAnswer()
        {

            string answer = "";

            // unbox the question info
            structQuestion q = (structQuestion)txtTo.Tag;

            // check if i'm in time
            if (_count_down.Enabled)
            {
                // I'm in time

                _count_down.Stop();

                answer = txtTo.Text.Trim();

                
                // question
                string question = (this.invertToolStripMenuItem.Checked ? q.From : q.To);
                // check if wrong
                if (String.Compare(question, answer, true) != 0)
                {
                    // check if i wrong just 1 char for probabli input error
                    if (askmecheck.DifferentChars(question, answer) == 1)
                    {
                        if (MessageBox.Show("Do you want to check your answer out before confirm? ;-)",
                            Application.ProductName, MessageBoxButtons.YesNo, MessageBoxIcon.Question) 
                            == DialogResult.Yes)
                        {
                            _count_down.Start();
                            return;
                        }
                    }

                    MessageBox.Show("Wrong! Was: " + (this.invertToolStripMenuItem.Checked ? q.From : q.To),
                            Application.ProductName, MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
                _in_asking = false;

            }
            this.Hide();
			this.Thunbnail.Image.Dispose();
            _ask_me.Invert = this.invertToolStripMenuItem.Checked;
            _ask_me.setQuestion(q.Id, answer);
            _ask_me.Start();
        }

        private void StartStopAsking()
        {
            ToolStripDropDownItem i = this.stopAskToMyselfToolStripMenuItem;
            if (_ask_me.InAsking)
            {
                _tray_icon.Icon = getIconByIndex(_ask_me.Invert?enumIcon.stop_invert:enumIcon.stop);
                _tray_icon.Text += ". In pause.";
                _ask_me.Stop();
                i.Text = i.Text.Replace("Stop", "Start");
                i.Image = getIconByIndex(enumIcon.timer_play).ToBitmap();
                this.ShowBallonPause();
            }
            else
            {
                _tray_icon.Icon = getIconByIndex(_ask_me.Invert ? enumIcon.invert : enumIcon.asking);
                _tray_icon.Text = Application.ProductName;
                _ask_me.Start();
                i.Text = i.Text.Replace("Start", "Stop");
                i.Image = getIconByIndex(enumIcon.timer_stop).ToBitmap();
                this.ShowBallonIntervalTime();
            }
        }

        private void buttonOK_Click(object sender, EventArgs e)
        {
            this.CheckAnswer();
        }

        private void stopAskToMyselfToolStripMenuItem_Click(object sender, EventArgs e)
        {
            this.StartStopAsking();
        }

        private void invertToolStripMenuItem_Click(object sender, EventArgs e)
        {
            ToolStripMenuItem i = (ToolStripMenuItem)sender;

            if (_ask_me.InAsking)
                _tray_icon.Icon = getIconByIndex(i.Checked ? enumIcon.invert : enumIcon.asking);
            else
                _tray_icon.Icon = getIconByIndex(i.Checked ? enumIcon.stop_invert : enumIcon.stop);
                    
            _ask_me.Invert = i.Checked;
            _ask_me.setSetting(settingsUserEnum.invert, 
                (i.Checked ? "1" : "0"));
        }

        private void txtTo_KeyDown(object sender, KeyEventArgs e)
        {
            if (e.KeyCode == Keys.Return && this.txtTo.Text.Length > 0)
            {
                this.CheckAnswer();
            }
        }

        private void aboutAskToMyselfToolStripMenuItem_Click(object sender, EventArgs e)
        {
            form_about ab = new form_about();
            ab.Show();
        }

        private void logOutToolStripMenuItem_Click(object sender, EventArgs e)
        {
            _ask_me.Stop();
            _ask_me.User = "";
            _ask_me.Password = "";

            // reset the config file
            string fileConf = askmepath.PathConfiguration;

            askmeconf.setAskSetting(fileConf, "username", "");
            askmeconf.setAskSetting(fileConf, "password", "");

            // change icon
            _tray_icon.Icon = getIconByIndex(enumIcon.gray);

            // change menu
            _tray_icon.ContextMenuStrip = contextMenuStripLogin;
        }

        private void signInToolStripMenuItem_Click(object sender, EventArgs e)
        {
            form_login do_login = new form_login();
            if (do_login.ShowDialog() == System.Windows.Forms.DialogResult.OK)
            {
                // re-read the configuration
                LoginSettings set = do_login.getLoginSettings();
                _ask_me.DoLogin(set.UserName, set.Password);
            }

        }

        private void openWebAccountToolStripMenuItem_Click(object sender, EventArgs e)
        {
            try
            {
                System.Diagnostics.Process.Start("http://www.asktomyself.com/signin");
            }
            catch (Exception ex)
            {
                Console.WriteLine(ex.Message);
            }
        }

        private void btnSolution_Click(object sender, EventArgs e)
        {
            this.ShowSolution();
        }

        private void ShowSolution()
        {
            _count_down.Stop();
            structQuestion q = (structQuestion)txtTo.Tag;
            string answer = (this.invertToolStripMenuItem.Checked ? q.From : q.To);
            txtTo.Text = answer;
        }

        private void buyMeABeerToolStripMenuItem_Click(object sender, EventArgs e)
        {
            try
            {
                System.Diagnostics.Process.Start("http://www.asktomyself.com/buyabeer");
            }
            catch (Exception ex)
            {
                Console.WriteLine(ex.Message);
            }
        }

    }

    /// <summary>
    /// class to extend enumIconUtils
    /// </summary>
    public static class enumIconUtils
    {

        public static string ParseToName(this enumIcon i)
        {
            string ret = "asktomyself.Resources.emoticon_{0}.png";

            switch (i)
            {
                case enumIcon.asking:
                    ret = string.Format(ret,"tongue{0}");
                    break;
                case enumIcon.gray:
                    ret = string.Format(ret, "tongue_gray{0}");
                    break;
                case enumIcon.stop:
                    ret = string.Format(ret, "unhappy{0}");
                    break;
                case enumIcon.invert:
                    ret = string.Format(ret, "tongue_invert{0}");
                    break;
                case enumIcon.timer_stop:
                    ret = string.Format(ret, "stop");
                    break;
                case enumIcon.timer_play:
                    ret = string.Format(ret, "play");
                    break;
                case enumIcon.gray_left:
                    ret = string.Format(ret, "tongue_gray_left{0}");
                    break;
                case enumIcon.gray_middle:
                    ret = string.Format(ret, "tongue_gray_middle{0}");
                    break;
                case enumIcon.stop_invert:
                    ret = string.Format(ret, "unhappy_invert{0}");
                    break;
                default:
                    ret = "";
                    break;
            }

            if (System.Environment.OSVersion.Platform == PlatformID.Unix)
                ret = string.Format(ret, "32");
            else
                ret = string.Format(ret, "");

            return ret;

        }
    }

    /// <summary>
    /// class to handle user settings
    /// </summary>
    public class LoginSettings
    {
        public string UserName {get; set;}

        public string Password { get; set; }

    }
}
