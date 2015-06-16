<?php

require_once('include/iwrapbody.inc.php');

class myareaBody implements iWrapBody
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
        return "Get if for Mac OS";
    }

    public function getHtml()
    {

        $ret =  <<<EOMAC
        <div class="download_step">
        <p>For the time being it is not avalaible for MAC OS. Keep in touch!</p>
        <p>
            <a href="http://www.twitter.com/badlydone">
                <img src="http://twitter-badges.s3.amazonaws.com/follow_me-c.png" alt="Follow badlydone on Twitter"/>
            </a>
        </p>
        </div>
EOMAC;

        return $ret;

    }


}

?>
