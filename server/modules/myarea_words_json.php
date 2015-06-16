<?php

    include_once('../include/config.php');
    require_once('../include/edittable.inc.php');
    require_once('../include/errors.inc.php');
    require_once '../login/user_manager.inc.php';

    session_start();

    // check if i'm logged in

    // set a new userclass
    $usermgr = new UserManager();

    // get session id
    $sessionid = session_id();

    // check if i'm logged in
    $user_id = $usermgr->sessionLoggedIn($sessionid);

    if ($user_id == 0) { echo(""); return 0; }

    // get category
    $id_category = isset ($_POST['categoryid'])? $_POST['categoryid']:'';

    if ($id_category == '' or $id_category == 0) { echo(""); return 0; }

    // get connection
    $conn = $usermgr->getConnection();

    // security check
    $id_category = (int)$id_category;
    $id_category = $usermgr->super_escape_string($id_category, $conn);
	
    // query to gets words
    $querystr = <<<EOQUERY
            SELECT w.`id_word`, w.`from`, w.`to` FROM askme_categories c
            INNER JOIN askme_words w ON c.id_category = w.id_category
            WHERE c.id_category = '$id_category' AND c.id_user = '$user_id'
            ORDER BY w.`from`
EOQUERY;

    // get table
    $tb = new edittableinc($conn, $querystr);
    $tb->addEditColumn('from');
    $tb->addEditColumn('to');
    $tb->addDescTitles('from',
            getDescLabel(&$conn, &$id_category, 'question', 'Question'));
    $tb->addDescTitles('to',
            getDescLabel(&$conn, &$id_category, 'answer', 'Answer'));
    $tb->allowDeleteRow(true);
    $tb->allowAddNew(true);
    $tb->addTitles(true);

    // set return table
    $ret = $tb->getEditTable();

    // close connection
    $conn->close();

    echo $ret;

    function getDescLabel(&$conn, &$id_category, $q_a, $default)
    {

        $querystr = <<<EOQUERY
            SELECT a.`wrap_label_$q_a` as x FROM askme_categories a
            WHERE a.`id_category`='$id_category' LIMIT 0,1
EOQUERY;

        $results = $conn->query($querystr);
        if ($results)
        {
            if (($row = $results->fetch_assoc()) !== NULL)
            {
                if ($row['x'] !== NULL)
                    $default = $row['x'];
            }

            $results->close();
        }

        return $default;

    }

?>
