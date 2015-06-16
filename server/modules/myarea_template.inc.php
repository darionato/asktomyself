<?php

require_once('include/iwrapbody.inc.php');

class myareaTemplate implements iWrapBody
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
            return "Template myarea";
    }
	
    public function getHtml()
    {
        $ret = '<div class="myarea_template_menu">--menu--</div>';
        $ret .= '<div class="myarea_template_body">--body--</div>';

        return $ret;
    }
	
}

?>
