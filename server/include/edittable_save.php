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
    $id_user = isset ($_POST['iduser'])? $_POST['iduser']:0;

    if ($table == '' or $col == '' or $id == 0) { echo("0"); return 0; }

    $conn = $usermgr->getConnection();

	// security check
    $table = $usermgr->super_escape_string($table, $conn);
    $col = $usermgr->super_escape_string($col, $conn);
    $id = (int)$id;
    $id = $usermgr->super_escape_string($id, $conn);

    // get datas
    $data_save = "";
    foreach($_POST as $key => $value)
    {
        if (substr($key, 0, 4) == 'col_')
            $data_save .= "c." . substr($key, 4) . "='" 
            .$conn->real_escape_string($value). "',";
        else if (substr($key, 0, 7) == 'regexp_')
        {
            // check with regular expression if the value is right
            $colreg = str_replace(regexp_, 'col_', $key);
            if (isset ($_POST[$colreg]))
            {
                if (!preg_match($value, $_POST[$colreg]))
                {
                    echo("0");
                    return 0;
                }
            }
        }

    }
    // get rid of last comma
    if (strlen($data_save))
        $data_save = substr($data_save, 0, strlen($data_save) - 1);

    // check if i have to filter the user too
    $filter_user = ($id_user != 0?
            "c.id_user = '$id_user' and ":"");

    // delete data
    $querystr = <<<EOQ
        update $table c
    set $data_save
    where $filter_user c.$col = '$id'
    limit 1
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

    $conn->close();

    echo("1");

?>
