<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pommoUsers
 *
 * @author dario
 */

//require_once 'errors.inc.php';

class pommoUsers {

    private $_conn;

    function  __construct() {
       $this->_conn = $this->getConnection();
    }

    function  __destruct() {
        $this->_conn->close();
    }

    private function getConnection()
    {
        $conn = new mysqli('localhost', 'w74408_pommo', 'AskPoSelff88', 'w74408_pommo');
        if (mysqli_connect_errno() !== 0)
            throw new DatabaseErrorException(mysqli_connect_error());
        return $conn;
    }

    public function existsEmail($email)
    {

        $qstr = <<<EOQ
            SELECT count(*) as tt FROM pommo_subscribers p 
            where p.email = '$email' LIMIT 1
EOQ;

        $results = @$this->_conn->query($qstr);
        if ($results === FALSE)
            throw new DatabaseErrorException($this->_conn->error);

        // check if it exists
        $row = @$results->fetch_assoc();

        return ($row['tt'] != 0);

    }

    public function addEmail($email)
    {

        $qstr = <<<EOQUERY
            INSERT INTO pommo_subscribers SET
            email='$email',
            time_registered = now(),
            time_touched = now(),
            status = '1',
            ip = '1328395570'
EOQUERY;

        // execute the query
        $results = @$this->_conn->query($qstr);
        return ($results !== FALSE);

    }

    public function addEmailIfNotExists($email)
    {

        if ($this->existsEmail($email) == FALSE)
                $this->addEmail($email);

    }

}
?>
