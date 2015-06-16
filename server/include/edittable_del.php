<?php

    require_once('config.php');
    require_once('errors.inc.php');
    require_once '../login/user_manager.inc.php';

    session_start();

    // check if i'm logged in

    // set a new userclass
    $usermgr = new UserManager();

    // get session id
    $sessionid = session_id();

    // check if i'm logged in
    $user_id = $usermgr->sessionLoggedIn($sessionid);

    if ($user_id == 0) { echo("0"); return 0; }



    // check data
    $table = isset ($_POST['table'])? $_POST['table']:'';
    $col = isset ($_POST['col'])? $_POST['col']:'';
    $id = isset ($_POST['id'])? $_POST['id']:0;

    if ($table == '' or $col == '' or $id == 0) { echo("0"); return 0; }

    $conn = $usermgr->getConnection();

    // security check
    $table = $usermgr->super_escape_string($table, $conn);
    $col = $usermgr->super_escape_string($col, $conn);
    $id = (int)$id;
    $id = $usermgr->super_escape_string($id, $conn);

    // check if add id_user
    $add_id_user = isset ($_POST['addiduser'])? $_POST['addiduser']:'0';

    $filter = '';
    if ($add_id_user == '1')
        $filter = "(id_user = '$user_id') AND ";

    // delete data
    $querystr = <<<EOQ
        delete from $table where $filter ($col = '$id')
        LIMIT 1
EOQ;


    // execute the query
    try
    {
        $result = @$conn->query($querystr);
    }
    catch (Exception $ex)
    {
        throw $ex;
        $conn->close();
        echo("0");
        return 0;
    }
    
    // special cases
    if ($table == "askme_categories")
    {
		// delete * shared categories
        $querystr = <<<EOQ
            DELETE FROM askme_shared_categories
            WHERE `id_category`= '$id'
EOQ;
        // execute the query
        $result = @$conn->query($querystr);
	}

    $conn->close();

    echo("1");

?>
