using System;
using System.Text;

namespace asktomyself.check
{


	public class askmecheck
	{

		public static int DifferentChars(string text1, string text2)
		{
			
			if (text1.Length != text2.Length) return -1;
			
			if (text1.Length < 3) return -1;
			
			int ret = 0;
			
			for (int x = 0; x < text1.Length; x++)
			{
				if (string.Compare(text1.Substring(x,1), text2.Substring(x,1), true) != 0)
					ret++;
			}
			
			return ret;
			
		}
		
	}
}
