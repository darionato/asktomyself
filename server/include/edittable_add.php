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

    // set the return value
    $newid = 0;

    // check data
    $table = isset ($_POST['table'])? $_POST['table']:'';

    if ($table == '') { echo("0"); return 0; }

    // check if add id_user
    $add_id_user = isset ($_POST['addiduser'])? $_POST['addiduser']:'1';

    $conn = $usermgr->getConnection();

    // security check
    $table = $usermgr->super_escape_string($table, $conn);

    // get datas, see if add the id user before
    $data_save = $add_id_user == '1'? '`id_user`,':'';
    $values_save = $add_id_user == '1'? "'$user_id',":'';
    // create string to return to js
    $return_values = $add_id_user == '1'? "[$user_id],":'';
    
    foreach($_POST as $key => $value)
    {
        if (substr($key, 0, 4) == 'col_')
        {
            $data_save .= '`' . substr($key, 4) . "`,";
            $return_values .= "[" . htmlspecialchars($value) . "],";
            // special chars
            $value_checked = $conn->real_escape_string($value);
            $values_save .= "'$value_checked',";
        }
    }
    
    // get rid of last comma
    if (strlen($data_save))
        $data_save = substr($data_save, 0, strlen($data_save) - 1);
    if (strlen($values_save))
        $values_save = substr($values_save, 0, strlen($values_save) - 1);
    if (strlen($return_values))
        $return_values = substr($return_values, 0, strlen($return_values) - 1);

    // complete query
    $querystr = <<<EOQ
        INSERT INTO $table ($data_save)
    VALUES ($values_save)
EOQ;

    

    // execute the query
    try
    {
        $result = @$conn->query($querystr);
        $newid = @$conn->insert_id;
    }
    catch (Exception $ex)
    {
        $return_values = '';
        throw $ex;
    }

    // special cases
    if ($table == "askme_categories")
    {
        // write the creation date
        $querystr = <<<EOQ
            UPDATE $table SET `creation_date` = NOW()
            WHERE `id_category`= '$newid' LIMIT 1
EOQ;
        // execute the query
        $result = @$conn->query($querystr);

    }

    $conn->close();

    echo("[$newid],$return_values");

?>
