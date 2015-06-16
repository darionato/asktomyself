<?php

/* Type LOG
1	Login
2	Word asked
3	Got answer
4	Add word
5	Word asked
6	Add word failed
*/

include('mysql_func.php');

function get_update_available($user, $pass, $version)
{
	
	// check user, pass
	$id_user = get_id_login($user,$pass);
	if ($id_user[0] == 0) return false;

	
	// write the version of the client
	$query = <<<EOQUERY
		UPDATE askme_users u 
		SET u.client_version = '$version' 
		WHERE u.id_user = '{$id_user[0]}' 
		LIMIT 1
EOQUERY;

        @runMysqlQuery($query);

	$last_version = "1.0.0.4";
	
	// check if the client is updated
	if (strcmp($last_version, $version) == 1)
		return $last_version;
	else
		return "";
	
}

function get_software_version($user, $pass, $what)
{
	
	$ret = 0;
	
	switch ($what)
	{
		case 1: // askme.exe
			$ret = "1.0.0.4";
			break;
	}
	
	return $ret;
	
}

function set_setting($user, $pass, $id_setting, $val_setting)
{
	
	// check user, pass and category
	$id_user = get_id_login($user,$pass);
	if ($id_user[0] == 0) return false;
	
	$query = "UPDATE askme_settings s "
		."SET s.value = '$val_setting' "
		."WHERE s.id_user = '{$id_user[0]}' "
		."AND s.id_setting = '$id_setting' LIMIT 1";
	
	if (runMysqlQuery($query))
	{
		return true;
	}
	else
	{
		return false;
	}
	
}

function get_settings($user, $pass)
{
	
    $ret = "";

    // check user, pass and category
    $id_user = get_id_login($user,$pass);
    if ($id_user[0] == 0) return $ret;

    $query = "SELECT "
            ."CONCAT('(', k.id_setting, ':', s.value,')') as val "
            ."FROM askme_settings s INNER JOIN askme_key_settings k "
            ."ON s.id_setting = k.id_setting WHERE s.id_user = '{$id_user[0]}'";

    $link = getMysqlLink();

    if (($result = mysql_query($query, $link)) !== false)
    {

        while ($row = mysql_fetch_array($result, MYSQL_NUM))
        {
            if ($row[0] == '(2:0)')
            {
                // this means the no one category is selected

                $query = "SELECT a.id_category FROM askme_categories a "
                    ."where a.id_user = '{$id_user[0]}' LIMIT 1";

                if (($result_cat = mysql_query($query, $link)) !== false)
                {

                    if (($category = mysql_fetch_array($result_cat, MYSQL_NUM)) !== false)
                    {
                        // now I update the value
                        $query = "update askme_settings a "
                            ."set a.value = '{$category[0]}' "
                            ."where a.id_user = '{$id_user[0]}' and "
                            ."id_setting = '2' LIMIT 1";

                        if (($set_cat = mysql_query($query, $link)) !== false)
                                $ret .= "(2:{$category[0]})";
                    }


                }

            }
            else
                $ret .= $row[0];
        }

    }

    mysql_free_result($result);

    mysql_close($link);

    return $ret;
	
}

function get_categories($user, $pass)
{
	
	$ret = "";
	
	// check user, pass and category
	$id_user = get_id_login($user,$pass);
	if ($id_user[0] == 0) return $ret;
	
	$query = "SELECT `id_category` ,`desc`, "
		."`wrap_label_question`, `wrap_label_answer` "
		."FROM `askme_categories` "
		."WHERE `id_user` = '{$id_user[0]}' "
		."ORDER BY `desc` LIMIT 0, 1000";
	
	$link = getMysqlLink();
	
	if (($result = mysql_query($query, $link)) !== false)
		while ($row = mysql_fetch_array($result, MYSQL_NUM))
			$ret .= "([{$row[0]}],[0],[{$row[1]}],[{$row[2]}],[{$row[3]}])";
	
	mysql_free_result($result);


	// get the shared categories
	$query = <<<EOQUERY
		SELECT c.`id_category`, c.`desc`,
		c.`wrap_label_question`, c.`wrap_label_answer`,
                CONCAT(' by ', IFNULL(u1.`nickname`, 'Anonymous')) as sharedby
                FROM ((askme_users u
		INNER JOIN askme_shared_categories s ON u.id_user = s.id_user)
		INNER JOIN askme_categories c ON s.id_category = c.id_category)
		INNER JOIN askme_users u1 ON c.id_user = u1.id_user
		WHERE u.id_user = '{$id_user[0]}' AND c.shared = '1'
		ORDER BY c.desc
		LIMIT 0, 1000
EOQUERY;

	if (($result = mysql_query($query, $link)) !== false)
            while ($row = mysql_fetch_array($result, MYSQL_NUM))
                $ret .= "([{$row[0]}],[1],[{$row[1]}{$row[4]}],[{$row[2]}],[{$row[3]}])";

	mysql_free_result($result);

	mysql_close($link);
	
	return $ret;
	
}

function get_question($user, $pass, $category)
{
	
    // check user, pass and category
    $id_user = get_id_login($user,$pass);
    if ($id_user[0] == 0) return "";
	
    // check if i exceed the max question
    if (get_count_log_today($id_user[0], 2) >= $id_user[2]) return "";
	
    // log
    add_log($id_user[0], 2);
	
    // return a string
    $ret = "";
    $last_q = 0;
	
    // CASE 1: check if the last question is wrong
    $result = getMysqlStoreProcedureRow(
            "call get_id_question_last('{$id_user[0]}','$category', @a, @b)",
            "select @a, @b");
	
    // if found, get out
    if ($result !== null)
    {
        if (strlen($result[0])>0) return $result[0];
        // get the last question id
        $last_q = $result[1];
    }

    // CASE 2: check if there are questions never asked, or less asked
    $result = getMysqlStoreProcedureRow(
            "call get_id_question('{$id_user[0]}','$category','$last_q',@a)",
            "select @a");

    // if found, get out
    if ($result !== null AND strlen($result[0])>0) return $result[0];
    
    // if not to reask, get a random word
    $result = getMysqlRow(
        "SELECT CONCAT('(', CONCAT_WS(':', w.`id_word`, TRIM(w.`from`), TRIM(w.`to`)), ')') AS `ret` "
        ."FROM `askme_categories` c "
        ."INNER JOIN `askme_words` w ON w.`id_category` = c.`id_category` "
        ."WHERE c.`id_category` = '$category' "
        ."ORDER BY RAND() LIMIT 1");


    // if found, get out
    if ($result !== null) $ret = $result[0];

    // return the string
    return $ret;
	
}

function set_question($user, $pass, $category, $id_word, $responce, $invert)
{
	
	/*
	 * anwer value:
	 * 1 = ok
	 * 2 = no
	 * 4 = invert
	 */ 
	
	// check user, pass and category
	$id_user = get_id_login($user,$pass);
	if ($id_user[0] == 0) return false;
	
	// log
	add_log($id_user[0], 3);
	
	// get connection
	$link = getMysqlLink();
	
	// check if correct
	$field = ($invert?'from':'to');
	$query = sprintf("SELECT count( * ) AS total FROM `askme_words` "
		."WHERE `id_word` = '$id_word' AND `$field` = '%s'",
		mysql_real_escape_string($responce, $link));
		
	
	if (($results = mysql_query($query, $link)) !== false)
	{
		
		if (($result = mysql_fetch_array($results, MYSQL_NUM)) !== false)
		{
		
			$res = (($result[0]==0?2:1) | ($invert?4:0));
			// insert the answer 2 = wrong, 1 = correct
			$query = "INSERT INTO `askme_questions` ("
				."`date`,`id_word`,`result`,`id_user`) VALUES ("
				."NOW(), '$id_word', '$res', '{$id_user[0]}')";
			
			// run query
			if ($result = mysql_query($query, $link))
			{
				return true;
			}
			else
			{
				return false;
			}
			
		}
		
		mysql_free_result($results);
		
	}

	mysql_close($link);
	
	return false;
	
}

function add_word($user, $pass, $from, $to, $category)
{
	
	/*
		RETURN
		1 = ok
		2 = query error
		4 = bad login
		8 = word already exists
	*/
	
	// check user, pass and category
	$id_user = get_id_login($user,$pass);
	if ($id_user[0] == 0) return 4;
	
	
	// check if i exceed the max question
    if (get_count_log_today($id_user[0], 4) >= $id_user[4]) return "";
    
	
	if (!exists_word($from, $category))
	{
		$ret = (runMysqlQuery("insert into askme_words "
					."(`from`, `to`, `id_category`)"
					." values "
					."('$from', '$to', $category);")?1:2);
					
		add_log($id_user[0], ($ret?4:6));
		return $ret;
	}
	else
	{
		return 8;
	}
	
}

function exists_word($word, $category)
{
	
	$result = getMysqlRow(
		"SELECT count(*) as tot FROM `askme_categories` c "
		."INNER JOIN `askme_words` w ON c.id_category = w.id_category "
		."WHERE c.id_category = $category AND w.`from` = '$word';");
	
	return ($result[0] > 0);
	
}

function get_id_login($user,$pass)
{
	
	$result = getMysqlStoreProcedureRow(
            "call get_id_login('$user','$pass',".
                "@id,@max_c,@max_q,@max_add_c,@max_add_w)",
            "select @id,@max_c,@max_q,@max_add_c,@max_add_w");
	
	if ($result === null)
            $result = array(0,0,0,0,0);
	
	return $result;
	
}

function try_login($user,$pass)
{
	
    $id_user = get_id_login($user,$pass);

    // check if i exceed the max connection
    if (get_count_log_today($id_user[0], 1) >= $id_user[1]) return 0;

    add_log($id_user[0], 1);
    return ($id_user[0] > 0);
	
}

function get_missing_count($user, $pass, $what)
{
	
	/*
	 *  1 = login
	 *  2 = questions done
	 *  3 = categories added
	 *  4 = words added
	 */
	
	$id_user = get_id_login($user,$pass);
	
	$max = $id_user[$what];
	
	return ($max - get_count_log_today($id_user[0], $what));
	
}

function get_count_log_today($id_user, $type_log)
{

    $result = getMysqlRow("SELECT count(*) as c FROM `askme_log` "
        ."WHERE `id_user` = '$id_user' "
        ." AND `id_log` = '$type_log' "
        ." AND DATE(`date`) = DATE(NOW()) LIMIT 1");

    if ($result === null) return 0;

    return $result[0];

}

function add_log($id_user, $type_log)
{
	
    /*
    1 	Login
    2 	Word asked
    3 	Got answer
    4 	Add word
    5 	Word asked
    6	Add word failed
    */

    $query = "INSERT INTO `askme_log` (`id_user` ,`date` ,`id_log`) "
                    ."VALUES ("
                    ."'$id_user', NOW(), '$type_log')";

    return runMysqlQuery($query);
	
}

?>
