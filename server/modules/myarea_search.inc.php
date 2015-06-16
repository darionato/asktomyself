<?php

require_once('include/iwrapbody.inc.php');
require_once('include/edittable.inc.php');
require_once('include/asktm_get_combo_kind_category.inc.php');
require_once('include/category_search.inc.php');

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
        return "Welcome myarea search categories";
    }
	
    public function getHtml()
    {

        // check if i'm loggin in
        if ($this->id <= 0)
                return LOGIN_NOT_DONE;

        $ret = $this->getTitle();

        return $ret;

    }

    private function getTitle()
    {
        return "<div class='title_body_wrap'>Welcome in search categories</div>"
            ."<div class='welcome_div'>{$this->getSearchBar()}</div>";
    }

    private function getSearchBar()
    {

        // get the combo with the kinds of categories
        $combo = new asktm_get_combo_kind_category();
        $combo->setConnection($this->c);
        $combo->setFirstElement("All categories...");

        // get few categories to show
        $search = new category_search(&$this->c, $this->id);
        $categories = $search->getTableSearch('', 0);

        $ret = <<<EOHTML
            <div class="search_bar_block">
                <input id="search_string" class="gradient_text" type="text" value="" maxlength="30" />
                {$combo->getComboKindCategory()}
                <input id='search_categories' class='btn' type='button' value='Search' />
                <div id="myarea_word_progress"></div>
                <div id="search_result">$categories</div>
            </div>
EOHTML;

        return $ret;

    }
    
}

?>
