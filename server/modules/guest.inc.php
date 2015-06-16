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
        return "Guest module";
    }
	
    public function getHtml()
    {
        return <<<EOGUEST
            <div id='main_banner'>
            <a id='button_tour' href='index.php?ptg=tour'></a>
            <a id='button_signup' href='index.php?ptg=signup'></a>
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
EOGUEST;
    }
	
}

?>
