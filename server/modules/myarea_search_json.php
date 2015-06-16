<?php

    include_once('../include/config.php');
    require_once('../include/edittable.inc.php');
    require_once('../include/errors.inc.php');
    require_once('../include/category_search.inc.php');
    require_once('../login/user_manager.inc.php');

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
    $search_string = isset ($_POST['searchstring'])? $_POST['searchstring']:'';
    $kind_category = isset ($_POST['kindcategoy'])? $_POST['kindcategoy']:'';

    // get connection
    $conn = $usermgr->getConnection();

    // security check
    $search_string = $usermgr->super_escape_string($search_string, $conn);
    $kind_category = (int)$kind_category;
    $kind_category = $usermgr->super_escape_string($kind_category, $conn);
    
    if ($kind_category == '') { echo(""); return 0; }

    // search the categories
    $search = new category_search(&$conn, $user_id);
    $ret = $search->getTableSearch($search_string, $kind_category);

    // close connection
    $conn->close();

    echo $ret;

?>
