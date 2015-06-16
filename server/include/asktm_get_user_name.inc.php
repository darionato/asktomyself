<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of asktm_get_user_name
 *
 * @author dario
 */
class asktm_get_user_name {

    var $c;
    
    public function setConnection(&$conn)
    {
        $this->c = $conn;
    }

    public function getCompleteName($id)
    {

        $ret = "";

        $querystr = <<<EOQUERY
            SELECT a.`name` as m, a.`surname` as s,
            a.`nickname` as n, a.`email` as e
            FROM askme_users a
            WHERE a.`id_user` = '$id'
            LIMIT 1
EOQUERY;

        $results = $this->c->query($querystr);
        if ($results)
        {
            if (($row = $results->fetch_assoc()) !== NULL)
            {

                // check the name
                if ($row['m'] !== NULL && strlen(trim($row['m'])) > 0)
                    $ret = $row['m'];

                // check the surname
                if ($row['s'] !== NULL && strlen(trim($row['s'])) > 0)
                    $ret .= (strlen($ret) > 0?' ':'') . $row['s'];

                if (strlen($ret) == 0)
                {
                    if ($row['n'] !== NULL && strlen(trim($row['n'])) > 0)
                        $ret = $row['n'];
                    else
                        $ret = $row['e'];
                }

            }


            $results->close();

        }

        return $ret;

    }

}
?>
