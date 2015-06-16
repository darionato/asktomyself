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
            return "Admin myarea";
    }

    public function getHtml()
    {
        // check if i'm loggin in
        if ($this->id <= 0)
                return LOGIN_NOT_DONE;

        $ret = $this->getTitle();
        $ret .= $this->getTableAccounts();
        return $ret;

    }

    private function getTitle()
    {
        return "<div class='title_body_wrap'>Welcome in the admin area</div>";
    }

    private function getTableAccounts()
    {

        $querystr = <<<EOQUERY
            SELECT u.`registration_date` as Registration, u.`email` as `E-mail`, 
            CONCAT(u.`surname`, ' ', u.`name`) as `Full name`, 
            u.`nickname` as `Nick`, CONCAT(u.`country`, ' ', u.`birthday`) as `State - Born`, 
            count(DISTINCT c.id_category) as `Cat`, 
            count(w.id_word) as `Wor` FROM 
            (`askme_users` u LEFT JOIN askme_categories c ON u.id_user = c.id_user)
			LEFT JOIN askme_words w ON c.id_category = w.id_category
			GROUP BY u.`registration_date`, u.`email`, u.`surname`, 
			u.`name`, u.`nickname`, u.`country`, u.`birthday`
			ORDER BY u.`registration_date` DESC 
			LIMIT 0, 30
EOQUERY;

        $tb = new edittableinc($this->c, $querystr);
        $tb->allowDeleteRow(false);
        $tb->allowAddNew(false);
        $tb->addTitles(true);
        return $tb->getEditTable();
    }

}

?>
