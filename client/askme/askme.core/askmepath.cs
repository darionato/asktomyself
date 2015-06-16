using System;

namespace asktomyself.path
{
    class askmepath
    {

        public static string PathConfiguration
        {
            get 
            {
                return System.IO.Path.Combine(
                    System.Environment.GetFolderPath(Environment.SpecialFolder.ApplicationData),
                    "askme.conf"); 
            }
        }

    }
}
