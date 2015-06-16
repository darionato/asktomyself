<?php

require_once('include/iwrapbody.inc.php');
require_once('include/edittable.inc.php');

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
            return "Words myarea";
    }

    public function getHtml()
    {
        // check if i'm loggin in
        if ($this->id <= 0)
                return LOGIN_NOT_DONE;

        // create the combo with categories
        $ret = $this->getTitle();
        $ret .= '<div id="myarea_word_combo">';
        $ret .= $this->getComboCategories();

        // progess image
        $ret .= '<div id="myarea_word_progress">';
        $ret .= "</div>";
        
        $ret .= "</div>";


        // create the words area
        $ret .= '<div id="myarea_words">';
        $ret .= "</div>";
        return $ret;

    }
    
    private function getComboCategories()
    {

        // get the record with categories
        $querystr = <<<EOQUERY
                SELECT * FROM askme_categories c
                where c.id_user = '{$this->id}' ORDER BY c.desc
EOQUERY;

        $results = $this->c->query($querystr);
        if ($results === FALSE)
                return "No categories";

        $ret = '<select class="gradient_combo" id="myarea_categories">';
        $ret .= "<option value='0'>";
        $ret .= 'Select your category...';
        $ret .= "</option>";

        while (($row = $results->fetch_assoc()) !== NULL)
        {
            $ret .= "<option value='{$row['id_category']}'>";
            $ret .= $row['desc'];
            $ret .= "</option>";
        }

        $ret .= "</select>";

        $results->close();

        return $ret;

    }

    private function getTitle()
    {
        return "<div class='title_body_wrap'>Welcome in the words area</div>";
    }


}

?>
