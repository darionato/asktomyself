<?php

require_once('include/iwrapbody.inc.php');
require_once('include/download_info.inc.php');

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
        return "Get if for Windows";
    }

    public function getHtml()
    {
        // get download count
        $down = new download_info();
        $count = $down->getCount($this->c, "win");

        $ret =  <<<EOSTEP
            <div class="download_body">
            <div class="download_step">
                <p><h2>How to install it on Windows</h2></p>
                <p>Follow the bellow steps:</p>
                <li>
                    <ul>1. Download the latest version of Ask To Myself</ul>
                    <ul>2. Double click on the downloaded file</ul>
                    <ul>3. Follow the wizard setup</ul>
                    <ul>4. If you're updating it, close it before</ul>
                </li>
            </div>
            <div id="win" class="download_btn">
                <span>Download: $count</span>
            </div>
            </div>
EOSTEP;

        return $ret;

    }


}

?>
