<?php

require_once('include/iwrapbody.inc.php');

class bodyWrap implements iWrapBody
{

    var $c;
    var $id;

    public function setIdUser($id_user)
    {
        $this->id = $id_user;
    }

    public function setConnection(&$conn)
    {
        $this->c = $conn;
    }
	
    public function getModuleName()
    {
        return "Tour module";
    }
	
    public function getHtml()
    {
        $ret =  "<div class='title_body_wrap'>
          Support
          </div>";

        $ret .= <<<EOTEXT
            <div class="support_main">
                <h2>How to use Ask To Myself</h2>
                <object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/OHhWmMkZkQg?fs=1&amp;hl=en_US&amp;rel=0&amp;color1=0x3a3a3a&amp;color2=0x999999"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/OHhWmMkZkQg?fs=1&amp;hl=en_US&amp;rel=0&amp;color1=0x3a3a3a&amp;color2=0x999999" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385"></embed></object>
            </div>
EOTEXT;

        return $ret;
		
    }
	
}

?>
