using System;
using System.Linq;
using System.Text;
using System.IO;

namespace asktomyself.conf
{
    public class askmeconf
    {

        public static void setAskSetting(string filePath, string key_setting, string val_setting)
        {

            FileStream f = new FileStream(filePath, FileMode.OpenOrCreate);
            f.Close();

            string[] all = File.ReadAllLines(filePath);
            
            File.Delete(filePath);

            bool found = false;

            for(int r = 0; r < all.Length; r++)
            {
                if (all[r].TrimStart().StartsWith(key_setting + " "))
                {
                    all[r] = key_setting + " " + val_setting;
                    found = true;
                    break;
                }
            }

            string[] write;

            if (found==false)
            {
                write = new string[all.Length + 1];
                all.CopyTo(write,0);
                write[write.Length-1] = key_setting + " " + val_setting;
            }
            else
            {
                write = all;
            }

            File.WriteAllLines(filePath,write);

        }

        public static string getAskSetting(string filePath, string key_setting)
        {

            if (File.Exists(filePath) == false) return "";

            try
            {

                var query =
                    from line in File.ReadAllLines(filePath)
                         let settingRecord = line.Trim().Split(' ')
                         where line.TrimStart().StartsWith(key_setting + ' ')
                         select settingRecord[1];
            
                foreach (var v in query)
                {
                    return v.ToString();
                }

            }
            catch(Exception ex)
            {
                Console.WriteLine(ex.Message);
            }

            return "";
        }

    }
}
