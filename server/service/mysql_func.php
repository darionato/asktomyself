<?php

require_once('../include/config.php');

function getMysqlLink(){
	
	$link = mysql_connect(MYSQL_DB_SERVER, MYSQL_DB_USERNAME, MYSQL_DB_PW);
	if (!$link) {
	    return 0;
	}
	
	$db_selected = mysql_select_db(MYSQL_DB_DB, $link);
	if (!$db_selected) {
 	   return 0;
	}
	
	return $link;
}

function runMysqlQuery($query){
	
	$link = getMysqlLink();
	if (!$link) {
	    return 0;
	}
	
	$result = mysql_query($query, $link);
	
	mysql_close($link);
	
	return $result;
	
}

function getMysqlStoreProcedureRow($query_store, $query_select){

	$row = null;
	
	$link = getMysqlLink();
	if (!$link) {
	    return 0;
	}
	
	if (($result = mysql_query($query_store, $link)) !== FALSE) {
		
		if (($result = mysql_query($query_select,$link)) !== FALSE) {
			
			$row = mysql_fetch_array($result);
	
		}

		mysql_free_result($result);
	}

	mysql_close($link);
	
	return $row;
	
}

function getMysqlRow($query){
	
	$link = getMysqlLink();
	if (!$link) {
	    return 0;
	}
	
	$result = mysql_query($query, $link);
	
	$row = mysql_fetch_array($result, MYSQL_BOTH);
	
	mysql_free_result($result);
	
	mysql_close($link);
	
	return $row;
	
}

?>
