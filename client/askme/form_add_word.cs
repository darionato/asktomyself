using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using asktomyself.core;
using asktomyself.wsdl;

namespace asktomyself
{
    public partial class form_add_word : Form
    {

        askmecore _w;
        bool _adding = false;

        public form_add_word(askmecore a)
        {
            InitializeComponent();

            _w = a;
            _w.StartAsyncMethod += new AskMeStartAsyncMethod(_w_StartAsyncMethod);
            _w.AddWordComplete += new AskMeMethodResult(_w_AddWordComplete);

            this.comboCategories.DataSource = _w.Categories;
            this.comboCategories.ValueMember = "Id";
            this.comboCategories.DisplayMember = "Description";

            // set the combo on the used category
            var r = (from c in _w.Categories
                     where c.Id == _w.Category
                     select c.Id).FirstOrDefault();

            if (r > 0)
                this.comboCategories.SelectedValue = r;

        }

        void _w_StartAsyncMethod(object sender, methodsAsync method)
        {
            switch (method)
            {
                case methodsAsync.add_new_word:
                    btnAdd.Enabled = false;
                    Cursor = Cursors.WaitCursor;
                    break;
            }
        }

        void _w_AddWordComplete(object sender, resultAddWord result)
        {
            btnAdd.Enabled = true;
            Cursor = Cursors.Default;
            
            HandleResult(result);

            _adding = false;

            askmeWsdlService.askmewsdl tmp = (sender as askmeWsdlService.askmewsdl);
            if (tmp != null) this.Close();
            
        }

        private void HandleResult(resultAddWord result)
        {

            string error = "";

            switch (result)
            {
                case resultAddWord.bad_login:
                    error = "Bad login";
                    break;
                case resultAddWord.query_error:
                    error = "Query error";
                    break;
                case resultAddWord.word_already_exists:
                    error = "Word already exists";
                    break;
            }

            if (error.Length > 0) MessageBox.Show(error,"Error", MessageBoxButtons.OK, MessageBoxIcon.Error);

        }

        private void btnAdd_Click(object sender, EventArgs e)
        {
            this.add_new_word_async();
        }

        private void add_new_word_async()
        {

            if (_adding) return;

            if ((textFrom.Text.Length == 0) || (textTo.Text.Length == 0)) return;

            _adding = true;

            _w.AddWord(textFrom.Text, textTo.Text, (int)this.comboCategories.SelectedValue);

        }

        private void add_word_Shown(object sender, EventArgs e)
        {
            textFrom.Focus();
        }

        private void form_add_word_FormClosing(object sender, FormClosingEventArgs e)
        {
            e.Cancel = _adding;
        }

        private void textTo_KeyDown(object sender, KeyEventArgs e)
        {
            if (e.KeyCode == Keys.Return) add_new_word_async();
        }

    }
}
