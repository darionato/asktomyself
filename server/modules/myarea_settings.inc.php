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
        return "Settings myarea";
    }

    public function getHtml()
    {
        // check if i'm loggin in
        if ($this->id <= 0)
                return LOGIN_NOT_DONE;

        $ret =  $this->getTitle();

        // get settings without the 2 the is LASTCATEGORY that is managed by client
        $querystr = <<<EOQUERY
            SELECT k.id_setting, s.id_user, k.desc, s.value, k.regexp as regexp_value
            FROM askme_settings s INNER JOIN askme_key_settings k
            ON s.id_setting = k.id_setting WHERE s.id_user = $this->id
            AND --where--
            ORDER BY k.id_setting
EOQUERY;

        // get table with the normal value
        $tb = new edittableinc($this->c, 
                str_replace('--where--','k.id_setting = 1', $querystr));
        $tb->addEditColumn('value');

        $ret .= $tb->getEditTable();

        $tb = null;

        // get table with check value
        $tb = new edittableinc($this->c,
                str_replace('--where--',
                'k.id_setting > 2', $querystr));
        $tb->addEditColumn('value');
        $tb->addCheckColumn('value');

        $ret .= $tb->getEditTable();

        $tb = null;


		$ret .= '<br /><br />'
            .'<p><b>You must</b> restart the client application 
            for the changes to take effect.</p>';

        return $ret;

    }

    private function getTitle()
    {
        return "<div class='title_body_wrap'>Welcome in the settings area</div>";
    }

}

?>
