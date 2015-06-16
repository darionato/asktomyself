<?php

require_once('edittable.inc.php');

class category_search {

    private $_conn;
    private $_user_id = 0;

    function  __construct(&$conn, $user_id) {
        $this->_conn = $conn;
        $this->_user_id = $user_id;
    }

    public function getTableSearch($search_string, $kind_category)
    {

        // create the filter
        $filter = $kind_category > 0?
            " AND (c.`id_kind_category` = '$kind_category') ":'';

        // query to gets words
        $querystr = <<<EOQUERY
            SELECT c.`id_category`, c.`desc` AS `Name`, c.`long_desc` as `Description`,
            IFNULL(u.`nickname`, 'Anonymous') as `Shared by`,
            (SELECT count(`id_category`) FROM askme_shared_categories a
            WHERE `id_category`=c.`id_category` LIMIT 1) as `Rating`
            FROM askme_users u
            INNER JOIN askme_categories c ON u.`id_user` = c.`id_user`
            WHERE (u.`id_user` <> '{$this->_user_id}') $filter AND (c.`shared` = '1') AND
            (INSTR(c.`desc`, '$search_string') > 0) AND
            (c.`id_category` NOT IN
            (SELECT a.`id_category` FROM askme_shared_categories a
            WHERE a.`id_user`='{$this->_user_id}'))
            ORDER BY `Rating` DESC
            LIMIT 0,100
EOQUERY;

        // get table
        $tb = new edittableinc($this->_conn, $querystr);
        $tb->addTitles(true);
        $tb->addButtons('et_add_share', 'Add shared category');

        // set return table
        return $tb->getEditTable();

    }

}
?>
