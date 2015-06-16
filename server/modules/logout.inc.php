<?php

require_once('include/iwrapbody.inc.php');
require_once('login/user_manager.inc.php');

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
        return "Log out module";
    }
	
    public function getHtml()
    {

        // get a new user manager class
        $usermgr = new UserManager();

        // the the id user
        $userid = $usermgr->sessionLoggedIn(session_id(), $this->c);

        if ($userid == 0)
        {
            return "Sorry, you cannot be logged out if you are
                    not logged in!";
        }

        // log out
        $usermgr->processLogout($this->c);

        $ret =  <<<EOLOGOUT
            You have been successfully logged out of your area.<br />
            Now, you can <a href='index.php?ptg=login'>log back</a> or
            visit the <a href='index.php'>home page</a>.
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
EOLOGOUT;

        return $ret;
		
    }
    
}

?>
