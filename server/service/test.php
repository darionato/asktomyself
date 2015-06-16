<?php

include("code_askme1.php");
/*
echo(set_setting("info@asktomyself.com", "malfatti","2","2"));
*/

/*$link = getMysqlLink();

$id = "1'; select * from askme_log; '";

$id = mysql_real_escape_string($id);
echo("select * from askme_users where id_user = '$id' ");

mysql_close($link);
*/

echo(get_missing_count(
        'info@asktomyself.com',
        '3db51264ead2011dc8e66b49c5d7054ca5049b37',
        1));



?>
