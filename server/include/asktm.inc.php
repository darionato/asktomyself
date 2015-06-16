<?php

require_once('include/config.php');
require_once('include/errors.inc.php');
require_once('include/pommoUsers.inc.php');
require_once('login/user_manager.inc.php');
require_once('include/asktm_get_user_name.inc.php');

class asktm
{

    private $usermgr;
    private $user_id = -1;
    private $login_failed = false;
    private $conn;

    function  __construct() 
    {
        
        // set a new userclass
        $this->usermgr = new UserManager();

        // get session id
        $sessionid = session_id();

        // check if there is data for login
        if (isset($_POST['email'])
            && isset($_POST['userpass']))
        {

            $email = $_POST['email'];
            $user_pass = $_POST['userpass'];

            if ($this->usermgr->processLogin($email, $user_pass) == 0)
            {
                // login failed
                $this->login_failed = true;
            }

        }

        // check if i'm logged in
        if ($this->getPageToGo() !== 'logout')
            $this->user_id = $this->usermgr->sessionLoggedIn($sessionid);

        // open connection
        $this->conn = $this->usermgr->getConnection();
        
    }

    function  __destruct() {
        // close connection
        $this->conn->close();
    }

    function IdLoggedUser()
    {
        return $this->user_id;
    }

    function isLogginIn()
    {
        return ($this->user_id > 0);
    }

    function getPageToGo()
    {
        //if login failed, i show the login page
        if ($this->login_failed)
                return "login";

        //if a select page
        if (isset($_GET['ptg']))
            return $_GET['ptg'];

        //otherwise i return the default page
        return "guest";
    }

    function getSectionToGo()
    {
        $sect = "welcome";
        if (isset($_GET['sct']) && !$_GET['sct'] == '')
                $sect = $_GET['sct'];

        return $sect;
    }

    function getWrapBody()
    {

        // set the page to go
        $mod = $this->getPageToGo();
        
        // require the class
        require_once("modules/$mod.inc.php");
        
        // set new class
        $interface = new bodyWrap();

        // set the values
        $interface->setConnection($this->conn);
        $interface->setIdUser($this->user_id);

        // get html
        $ret = $interface->getHtml();

        // return the body
        return $ret;

    }

    public function getNameLoggedUser()
    {
        $n = new asktm_get_user_name();
        $n->setConnection($this->conn);
        return $n->getCompleteName($this->user_id);
    }
	
}


?>
