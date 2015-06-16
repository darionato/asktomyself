<?php

    include_once('../include/config.php');
    require_once('../include/errors.inc.php');
    require_once '../include/download_info.inc.php';
    require_once '../login/user_manager.inc.php';

    // set a new userclass
    $usermgr = new UserManager();

    // get the os
    $os = isset ($_POST['os'])? $_POST['os']:'';

    if ($os == '') { echo("0"); return 0; }

    // get connection
    $conn = $usermgr->getConnection();

    // query to increment the counter
    $querystr = <<<EOQUERY
        update askme_values set numeric_value = (numeric_value +1)
        where id_value = 'download_$os' limit 1
EOQUERY;

    // execute the query
    $result = @$conn->query($querystr);

    // get the count
    $down = new download_info();
    $count = $down->getCount($conn, $os);
    
    // close connection
    $conn->close();


    // return the url
    $ret = 'app/';

    switch ($os)
    {
        case 'linux':
            $ret .= 'linux/asktomyself_1.0.0.4.tar.bz2';
            break;
        case 'win':
            $ret .= 'win/asktomyself_1.0.0.4.exe';
            break;
        case 'man':
            $ret .= 'mac/asktomyself_1.0.0.4.dcm';
            break;
    }

    echo $count . ':' . $ret;

?>
