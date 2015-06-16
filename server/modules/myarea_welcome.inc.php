<?php

require_once('include/iwrapbody.inc.php');
require_once('include/edittable.inc.php');
require_once('include/charts_score.inc.php');

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
        return "Welcome myarea";
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
        return "<div class='title_body_wrap'>Welcome in your area</div>"
            ."<div class='welcome_div'>{$this->getInfoWelcome()}</div>";
    }

    private function getInfoWelcome()
    {

        $ret = "";

        if ($this->isFirstTime())
        {
            $ret .= <<<EOSTEPS
                <p class="welcome_h3"><h3>To start learning new words follow this steps:</h3></p>
                <li>
                    <ul>1. <a href="getit">Download</a> and install the client software</ul>
                    <ul>2. Open it and wait to get questions to answer</ul>
                    <ul>3. Create your categories of words and share it with the community or search them on the menu on the left</ul>
                    <ul>4. Play, learn and win the <b>TOP 10</b> best Ask To Myself users in the world!</ul>
                </li>
                <p class="welcome_h3"><h3>Rember to complete your personal data on the <a href="index.php?ptg=myarea&sct=account">account page</a>.<h3></p>
                <p class="welcome_h3"><h3>If you want to play for the <a href="index.php?ptg=charts">TOP 10</a>, fill the Nickname field on the <a href="index.php?ptg=myarea&sct=account">account page</a>.<h3></p>
EOSTEPS;
        }
        else
        {
            // set class of charts
            $top = new charts_score(&$this->c);
            $top->setIdUser($this->id);

            $ret .= "<p><b>Your portfolio:</b></p>";
            $ret .= "<p>Categories: <b>{$this->getCountCategories()}</b></p>";
            $ret .= "<p>Shared categories: <b>{$this->getCountSharedCategories()}</b></p>";
            $ret .= "<p>Words: <b>{$this->getCountWords()}</b></p>";

            // score previous month
            $date_p = mktime(0, 0, 0, date('m')-1, 1, date('Y'));
            $top->setDate(date('Y',$date_p), date('m',$date_p));
            $ret .= "<p>Score in ".date('F',$date_p).": <b>{$top->getScoreUser()}</b></p>";

            // score current month
            $top->setDate(date('Y'), date('m'));
            $ret .= "<p>Score in ".date('F').": <b>{$top->getScoreUser()}</b></p>";

        }

        return $ret;

    }

    private function getCountSharedCategories()
    {

        $ret = 0;

        $querystr = <<<EOQUERY
            SELECT count(*) as x  FROM
            (askme_users u
            INNER JOIN askme_shared_categories s ON u.id_user = s.id_user)
            INNER JOIN askme_categories c ON s.id_category = c.id_category
            WHERE u.id_user = '$this->id' AND c.shared = '1'
            LIMIT 1
EOQUERY;

        $results = $this->c->query($querystr);
        if ($results)
        {
            if (($row = $results->fetch_assoc()) !== NULL)
                $ret = $row['x'];

            $results->close();
        }

        return $ret;

    }

    private function getCountCategories()
    {

        $ret = 0;

        $querystr = <<<EOQUERY
            select count(*) as x
            from askme_categories c
            where c.id_user = '$this->id'
            limit 1
EOQUERY;

        $results = $this->c->query($querystr);
        if ($results)
        {
            if (($row = $results->fetch_assoc()) !== NULL)
                $ret = $row['x'];

            $results->close();
        }

        return $ret;

    }

    private function isFirstTime()
    {

        $ret = false;
        
        $querystr = <<<EOQUERY
            SELECT *  FROM askme_questions a
            where a.id_user = '$this->id'
            limit 1
EOQUERY;

        $results = $this->c->query($querystr);
        if ($results)
        {
            $ret = ($results->num_rows == 0);

            $results->close();
        }

        return $ret;

    }

    private function getCountWords()
    {

        $ret = 0;

        $querystr = <<<EOQUERY
            SELECT COUNT(*) as x FROM askme_categories c
            INNER JOIN askme_words w ON c.id_category = w.id_category
            WHERE c.id_user = '$this->id'
            LIMIT 1
EOQUERY;

        $results = $this->c->query($querystr);
        if ($results)
        {
            if (($row = $results->fetch_assoc()) !== NULL)
                $ret = $row['x'];

            $results->close();
            
        }

        return $ret;

    }

}

?>
