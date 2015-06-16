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
    $id_category = isset ($_POST['id_category'])? $_POST['id_category']:'';
    $ope = isset ($_POST['ope'])? $_POST['ope']:'';

    if ($id_category == '' or $id_category == '0') { echo("0"); return 0; }
    if ($ope == '' or $ope == '0') { echo("0"); return 0; }

    $conn = $usermgr->getConnection();

    // security check
    $id_category = $usermgr->super_escape_string($id_category, $conn);
    $ope = $usermgr->super_escape_string($ope, $conn);

    //return value
    $ret = "";

    // operation to do
    if ($ope == '2')
    {
        // get datas
        $data_save = "";
        foreach($_POST as $key => $value)
            if (substr($key, 0, 4) == 'col_')
                $data_save .= "c." . substr($key, 4) . "=" 
                . $usermgr->super_escape_string($value, $conn) . ",";

        // get rid of last comma
        if (strlen($data_save))
            $data_save = substr($data_save, 0, strlen($data_save) - 1);

        // save data
        $querystr = <<<EOQ
            update askme_categories c
            set $data_save
            where c.`id_category` = '$id_category'
            limit 1
EOQ;

        $result = @$conn->query($querystr);
        
    }
    else if ($ope == '1')
    {
        
        // select data
        $querystr = <<<EOQ
            SELECT a.`id_category`, a.`desc`, a.`long_desc`,
            a.`id_kind_category`, a.`wrap_label_question`,
            a.`wrap_label_answer` FROM askme_categories a
            WHERE a.`id_category` = '$id_category' LIMIT 0,1
EOQ;

        // execute the query
        try
        {
            $result = @$conn->query($querystr);

            if (($row = $result->fetch_assoc()) !== NULL)
            {
                foreach ($row as $key => $value)
                {
                    $ret .= "($key=[$value])";
                }
            }

        }
        catch (Exception $ex)
        {
            throw $ex;
            $conn->close();
            echo("0");
            return 0;
        }

    }
    else if ($ope == '3')
    {

        // add the category to share
        $querystr = <<<EOQ
            INSERT INTO askme_shared_categories
            (id_category, id_user) VALUES
            ('$id_category','$user_id');
EOQ;

        $result = @$conn->query($querystr);

        if ($result) $ret = "1";

    }

    $conn->close();

    echo($ret);

?>
