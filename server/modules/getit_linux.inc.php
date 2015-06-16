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
        return "Get if for Linux";
    }

    public function getHtml()
    {

        // get download count
        $down = new download_info();
        $count = $down->getCount($this->c, "linux");

        $ret =  <<<EOSTEP
            <div class="download_body">
            <div class="download_step">
                <p><h2>How to install it on Linux</h2></p>
                <p>Follow the bellow steps:</p>
                <li>
                    <ul>1. Install <a target="_blank" href="http://www.go-mono.com/mono-downloads/download.html">Mono</a></ul>
                    <ul>2. Download the latest version of Ask To Myself</ul>
                    <ul>3. Save it and extract it in a folder</ul>
                    <ul>4. To run the application, right click and run with mono</ul>
                    <ul>5. If you're updating it, close it before</ul>
                </li>
            </div>
            <div id="linux" class="download_btn">
                <span>Download: $count</span>
            </div>
            </div>
EOSTEP;

        return $ret;

    }


}

?>
