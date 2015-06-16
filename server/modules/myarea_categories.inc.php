<?php

require_once('include/iwrapbody.inc.php');
require_once('include/edittable.inc.php');
require_once('include/asktm_get_combo_kind_category.inc.php');

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
            return "Categories myarea";
    }

    public function getHtml()
    {
        // check if i'm loggin in
        if ($this->id <= 0)
                return LOGIN_NOT_DONE;

        $ret = $this->getTitle();
        $ret .= "<div class=\"div_categories\" >";
        $ret .= "<h3>Create a new category and share it!</h3>";
        $ret .= $this->getTableCategories();
        $ret .= "<h3 class=\"space_top\">Shared categories by the community</h3>";
        $ret .= $this->getTableSharedCategories();
        $ret .= "</div>";
        $ret .= $this->getCategoryDetails();
        return $ret;

    }

    private function getTitle()
    {
        return "<div class='title_body_wrap'>Welcome in the categories area</div>";
    }

    private function getTableCategories()
    {

        $querystr = <<<EOQUERY
            SELECT `id_category`, `desc`, `shared` FROM askme_categories
            WHERE `id_user`= '$this->id' AND `hidden`='0'
            ORDER BY `desc`
EOQUERY;

        $tb = new edittableinc($this->c, $querystr);
        $tb->allowDeleteRow(true);
        $tb->allowAddNew(true);
        $tb->addTitles(true);
        $tb->addButtons('et_details_row', "Details");
        $tb->addDescTitles('desc', 'Name');
        $tb->addDescTitles('shared', 'Shared');
        $tb->addEditColumn('desc');
        $tb->addEditColumn('shared');
        $tb->addCheckColumn('shared');
        return $tb->getEditTable();
    }

    private function getTableSharedCategories()
    {

        $querystr = <<<EOQUERY
            SELECT c.id_category, c.desc, IFNULL(u1.nickname, 'Anonymous') as nick FROM
            ((askme_users u
            INNER JOIN askme_shared_categories s ON u.id_user = s.id_user)
            INNER JOIN askme_categories c ON s.id_category = c.id_category)
            INNER JOIN askme_users u1 ON c.id_user = u1.id_user
            WHERE u.id_user = '$this->id' AND c.shared = '1'
            ORDER BY c.desc
            LIMIT 0, 1000
EOQUERY;

        $tb = new edittableinc($this->c, $querystr);
        $tb->addTitles(true);
        $tb->allowDeleteRow(true);
        $tb->addDescTitles('desc', 'Description');
        $tb->addDescTitles('nick', 'Shared by');
        return $tb->getEditTable();
        
    }

    private function getModalDialog($body)
    {

        return <<<EOMODAL
            <div id="boxes_dialog">
                <div id="dialog" class="window">
                    $body
                </div>  
                <div id="mask_modal_dialog"></div>
            </div>
EOMODAL;

    }

    private function getCategoryDetails()
    {

        $combo = new asktm_get_combo_kind_category();
        $combo->setWidth(236);
        $combo->setConnection($this->c);

        $detail = <<<EODETAIL
            <input id="id_category" type="hidden" value="" />
            <div class="dialog_title">
            <b>Category:</b> <span id="name_category"></span></div>
            <p>Type of category:<br />
            {$combo->getComboKindCategory()}</p>
            <p>Full description:<br />
            <input id="long_desc" class="gradient_text" type="text" value="" maxlength="200" /></p>
            <p>Wrap "Question" label:<br />
            <input id="wrap_label_question" class="gradient_text" type="text" value="" maxlength="40" /></p>
            <p>Wrap "Answer" label:<br />
            <input id="wrap_label_answer" class="gradient_text" type="text" value="" maxlength="40" /></p>
            <p class="btn_save_close">
            <input id='save_dialog' class='btn' type='button' value='Save' />
            <input id='close_dialog' class='btn' type='button' value='Close' />
            <div class="show_hide_loader"></div>
            </p>
EODETAIL;

        return $this->getModalDialog($detail);

    }

}

?>
