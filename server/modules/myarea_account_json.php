<?php

    include_once('../include/config.php');
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

    // get connection
    $conn = $usermgr->getConnection();

    // refresh the first name
    updateValue($conn, $usermgr, 'name', false, $user_id);

    // refresh the last name
    updateValue($conn, $usermgr, 'surname', false, $user_id);

    // refresh the last name
    if (!updateValue($conn, $usermgr, 'nickname', false, $user_id))
    {
        echo("Nickname chosen already in use by another user!"); return 0;
    }

    // refresh the country
    updateValue($conn, $usermgr, 'country', false, $user_id);

    // refresh the birthday
    updateValue($conn, $usermgr, 'birthday', false, $user_id);

    // refresh the e-mail
    if (!updateValue($conn, $usermgr, 'email', true, $user_id))
    {
        echo("E-mail not valid or already in use!"); return 0;
    }

    // refresh the password
    if (!updateValue($conn, $usermgr, 'pass', true, $user_id))
    {
        echo("Password not valid. Rewrite it!"); return 0;
    }

    // close connection
    $conn->close();

    echo "202";


    function updateValue(&$conn, &$usermgr, $field, $required, $id_user)
    {

        // check for the pwd
        if ($field == 'pass')
        {
            $pw1 =  isset($_POST['pass1']) ? $_POST['pass1'] : '';
            $pw2 =  isset($_POST['pass2']) ? $_POST['pass2'] : '';

            if ($pw1 == '') return TRUE;

            if ($pw1 !== $pw2) return FALSE;

            $value = sha1($pw1);
        }
        else
            // get data
            $value = isset($_POST[$field]) ? $_POST[$field] : '';

        
        // if empty i exit
        if (strlen($value) == 0 && $required == TRUE)
            return !$required;

        // security check
        $value = $conn->real_escape_string($value);



        // special check
        if ($field == 'birthday' && strlen($value) > 0)
            if (!$usermgr->isValidDate($value))
                    return FALSE;

        if ($field == 'email')
            if (!$usermgr->isValidEmail($value))
                    return FALSE;

        if ($field == 'nickname' && strlen($value) > 0)
            if (!$usermgr->isValidUserName($value) ||
                    !$usermgr->isUniqueNickname($value, $id_user, $conn))
                    return FALSE;

        // check if i have to set null
        if (strlen($value) == 0)
            $value = 'NULL';
        else
            $value = "'$value'";

        // query to save value
        $querystr = <<<EOQUERY
            update askme_users a
            set a.$field = $value
            where a.id_user = '$id_user' LIMIT 1
EOQUERY;

        $results = @$conn->query($querystr);

        if ($results === FALSE)
            return FALSE;

        return true;

    }
?>
