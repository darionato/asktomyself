<?php

require_once 'edittable.inc.php';

class charts_score
{

    private $_month;
    private $_year;
    private $_id_user = 0;
    private $_limit = 10;
    private $_conn;

    function   __construct(&$conn) {
        $this->_conn = $conn;
    }

    public function setLimit($limit)
    {
        $this->_limit = $limit;
    }

    public function setIdUser($id)
    {
        $this->_id_user = $id;
    }

    public function setDate($year, $month)
    {
        $this->_year = $year;
        $this->_month = $month;
    }

    private function getQueryScore()
    {

        $date = "'{$this->_year}-{$this->_month}-01'";
        $user = $this->_id_user != 0?
            "(q.id_user = '{$this->_id_user}') AND ":
            "(u.nickname IS NOT NULL) AND ";

        $query = <<<EOQUERY
            SELECT u.nickname AS 'Nickname', u.country AS 'Country',
            sum(IF(q.result = 1,2,-2)) as 'Score'
            FROM askme_questions q INNER JOIN askme_users u
            ON q.id_user = u.id_user
            WHERE $user
            (q.date BETWEEN (DATE($date)) AND
            (LAST_DAY($date) + INTERVAL 86399 SECOND))
            GROUP BY (q.id_user)
            ORDER BY Score DESC LIMIT 0,{$this->_limit};
EOQUERY;

        return $query;
        
    }

    public function getTableTopUsers()
    {

        $tb = new edittableinc($this->_conn, $this->getQueryScore());
        $tb->addTitles(true);
        $tb->addButtons('medal', 'Medal');
        return $tb->getEditTable();

    }

    public function getScoreUser()
    {

        if ($this->_id_user == 0) return 0;

        $result = $this->_conn->query($this->getQueryScore());

        if ($result === FALSE) return 0;

        $row = @$result->fetch_assoc();

        if ($row === NULL) return 0;

        return $row['Score'];
        
    }

}
?>
