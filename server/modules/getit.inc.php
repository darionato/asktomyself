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
        return "Get it module";
    }
	
    public function getHtml()
    {

        $sect = "";
        if (isset($_GET['sct']) && !$_GET['sct'] == '')
                $sect = $_GET['sct'];

        if (strlen($sect) == 0)
        {

            $link = "index.php?ptg=getit&sct=";

            $ret = <<<EOGETIT
              <div class='title_body_wrap'>Select your operating system:</div>
              <div class='div_select_os'>
              <ul class='select_os'>
                <li><a href='{$link}linux' class='get_linux'><span>Linux</span></a></li>
                <li><a href='{$link}win' class='get_win'><span>Windows</span></a></li>
                <li><a href='{$link}mac' class='get_mac'><span>Mac</span></a></li>
              </ul>
              </div>
              <div class="banner_468x60">
                    <script type="text/javascript"><!--
                            google_ad_client = "pub-7039402606733573";
                            /* AskToMyself 468x60, creato 10/09/10 */
                            google_ad_slot = "2687779765";
                            google_ad_width = 468;
                            google_ad_height = 60;
                            //-->
                            </script>
                            <script type="text/javascript"
                            src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
                    </script>
            </div>
EOGETIT;
            
        }
        else
        {
            require_once("modules/getit_$sect.inc.php");

            $b = new myareaBody();
            $b->c = $this->c;
            $b->id = $this->id;

            $ret = $b->getHtml();
        }

        return $ret;
		
    }
	
}

?>
