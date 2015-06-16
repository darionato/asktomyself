<?php

require_once('include/iwrapbody.inc.php');
require_once('modules/myarea_template.inc.php');

class bodyWrap implements iWrapBody
{
    
    private $c;
    private $id;

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
        // check if i'm loggin in
        if ($this->id <= 0)
                return LOGIN_NOT_DONE;
	        
        // get template of my area
        $templ = new myareaTemplate();
        $ret = $templ->getHtml();

        // get menu
        $ret = str_replace('--menu--', $this->getMenuMyArea(),$ret);

        // get body my area
        $ret = str_replace('--body--', $this->getBodyHTML(),$ret);

        return $ret;
		
    }
	
    private function getBodyHTML()
    {

        $sect = "welcome";
        if (isset($_GET['sct']) && !$_GET['sct'] == '')
                $sect = $_GET['sct'];

        require_once("modules/myarea_$sect.inc.php");

        $b = new myareaBody();
        $b->c = $this->c;
        $b->id = $this->id;

        return $b->getHtml();

    }
	
    private function getMenuMyArea()
    {

        $link = "index.php?ptg=myarea&sct=";

        $ret = '<img class="myarea_head" src="images/myarea_menu_head.png">';
        $ret .= '<ul class="myarea_menu">';
        $ret .= '<li><a href="'.$link.'">Welcome</a></li>';
        $ret .= '<li><a href="'.$link.'search">Search</a></li>';
        $ret .= '<li><a href="'.$link.'categories">Categories</a></li>';
        $ret .= '<li><a href="'.$link.'words">Words</a></li>';
        $ret .= '<li><a href="'.$link.'settings">Settings</a></li>';
        $ret .= '<li><a href="'.$link.'statistics">Statistics</a></li>';
        $ret .= '<li><a href="'.$link.'account">Account</a></li>';
        if ($this->id == 1)
            $ret .= '<li><a href="'.$link.'admin">Admin</a></li>';
        $ret .= '</ul>';

        return $ret;

    }
	
}

?>
