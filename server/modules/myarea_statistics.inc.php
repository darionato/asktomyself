<?php

require_once('include/iwrapbody.inc.php');

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
            return "Statistics myarea";
    }

    public function getHtml()
    {
        // check if i'm loggin in
        if ($this->id <= 0)
                return LOGIN_NOT_DONE;

        $ret = $this->getTitle();
        
        $querystr = <<<EOQUERY
            SELECT
            (SELECT count(q.result) as answers_ok
            FROM (`askme_categories` c
            INNER JOIN `askme_words` w ON c.id_category = w.id_category)
            INNER JOIN `askme_questions` q ON w.id_word = q.id_word
            WHERE (q.id_user = '$this->id') and ((q.result & 1) = 1) and
            (q.date BETWEEN DATE_ADD(NOW(), INTERVAL -30 DAY) AND NOW())) as ok,
            (SELECT count(q.result) as answers_ok
            FROM (`askme_categories` c
            INNER JOIN `askme_words` w ON c.id_category = w.id_category)
            INNER JOIN `askme_questions` q ON w.id_word = q.id_word
            WHERE (q.id_user = '$this->id') and ((q.result & 2) = 2) and
            (q.date BETWEEN DATE_ADD(NOW(), INTERVAL -30 DAY) AND NOW())) as wrong
EOQUERY;

        $results = $this->c->query($querystr);
        if ($results)
        {
            if (($row = $results->fetch_assoc()) !== NULL)
            {
                $ret .= "<br /><p><b>General chart of the current month</b></p>";
                $ret .= "<br />Total rights = {$row['ok']}";
                $ret .= "<br />Total wrongs = {$row['wrong']}";

                // create the chart
                $ret .= '<br /><img src="http://chart.apis.google.com/chart?'
                        .'cht=p3&'
                        .'chs=250x100&'
                        ."chd=t:{$row['ok']},{$row['wrong']}&"
                        .'chl=Right|Wrong" />';
                
            }
            $results->close();
        }

        return $ret;

    }

    private function getTitle()
    {
        return "<div class='title_body_wrap'>Welcome in the statistics area</div>";
    }

}

?>
