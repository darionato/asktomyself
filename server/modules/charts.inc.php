<?php

require_once('include/iwrapbody.inc.php');
require_once('include/charts_score.inc.php');

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
            return "Charts area";
    }

    public function getHtml()
    {

        $ret = $this->getTitle();

		// top ten
        $top = new charts_score(&$this->c);
        $top->setDate(date('Y'), date('m'));
        $ret .= "<div class='charts_table'>".$top->getTableTopUsers()."</div>";
        
        $ret .= "<div class='title_body_wrap'><h3>The winners of the previous month were:</h3></div>";
        
        // winner past month
        $date_p = mktime(0, 0, 0, date('m')-1, 1, date('Y'));
        $top->setDate(date('Y',$date_p), date('m',$date_p));
        $top->setLimit(3);
        $ret .= "<div class='charts_table'>".$top->getTableTopUsers()."</div>";

        return $ret;

    }

    private function getTitle()
    {
        return "<div class='title_body_wrap'>TOP 10 IN THE WORLD IN ".
            strtoupper(date('F'))."</div>";
    }

}

?>



