using System;
using System.Text.RegularExpressions;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using asktomyself.conf;
using asktomyself.crypt;
using asktomyself.path;

namespace asktomyself
{
    public partial class form_login : Form
    {
        public form_login()
        {
            InitializeComponent();
        }

        public string Title
        {
            get { return lblDescription.Text; }
            set { lblDescription.Text = value; }
        }

        public LoginSettings getLoginSettings()
        {
            LoginSettings set = new LoginSettings();
            set.UserName = txtEmail.Text;
            set.Password = txtPassword.Text;
            return set;
        }

        private bool IsValidEMail(string email)
        {

            Regex reg = new Regex(@"\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*", RegexOptions.IgnoreCase);
            return reg.IsMatch(email);

        }

        private void btnLogin_Click(object sender, EventArgs e)
        {
            this.DoTheLogin();
        }

        private void DoTheLogin()
        {
            if (IsValidEMail(txtEmail.Text) == false)
            {
                MessageBox.Show(
                    "E-mail address not in the correct format! Check it and try again.",
                    "E-mail wrong",
                    MessageBoxButtons.OK,
                    MessageBoxIcon.Information);
                txtEmail.Focus();
                return;
            }

            // save login
            if (chkAutoSignMeIn.Checked)
            {
                askmeconf.setAskSetting(askmepath.PathConfiguration,
                    "username", txtEmail.Text);

                askmeconf.setAskSetting(askmepath.PathConfiguration,
                    "password", askmecrypt.Encrypt(txtPassword.Text, "atm983", true));
            }

            DialogResult = System.Windows.Forms.DialogResult.OK;
            this.Close();
        }

        private void txtPassword_KeyDown(object sender, KeyEventArgs e)
        {
            if (e.KeyCode == Keys.Return && 
                this.txtEmail.Text.Length > 0 &&
                this.txtPassword.Text.Length > 0)
            {
                this.DoTheLogin();
            }
        }


    }
}
