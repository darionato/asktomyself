using System;
using System.Collections.Generic;
using System.Linq;
using System.Windows.Forms;
using System.Runtime.InteropServices;
using System.Threading;

namespace asktomyself
{
    static class Program
    {

        private static Mutex mutex;
				
        /// <summary>
        /// The main entry point for the application.
        /// </summary>
        [STAThread]
        static void Main()
        {

            bool firstInstance;
            mutex = new Mutex(false, "Local\\atmEF45Fvd", out firstInstance);

            if (!firstInstance)
            {
                mutex.Close();
                return;
            }

            Application.EnableVisualStyles();
            Application.SetCompatibleTextRenderingDefault(false);
            Application.Run(new main());

            mutex.Close();

        }
    }
}
