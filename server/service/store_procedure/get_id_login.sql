DELIMITER //
DROP PROCEDURE IF EXISTS `get_id_login` //
CREATE PROCEDURE `get_id_login`(in the_email varchar(80), IN the_pass varchar(50), out id_return INT, out max_conn INT, out max_quest INT, out max_add_c INT, out max_add_w INT)
BEGIN

	DECLARE no_records INT DEFAULT 0;
	
	DECLARE login_ask CURSOR FOR SELECT `id_user`, `max_connection_per_day`, `max_questions_per_day`, `max_added_categories_per_day`, `max_added_words_per_day` FROM `askme_users` WHERE `email` = the_email AND `pass` = the_pass;
	
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET no_records = 1;
	
	OPEN login_ask;
	
	FETCH login_ask INTO id_return, max_conn, max_quest, max_add_c, max_add_w;
	
	IF no_records = 1 THEN 
	
		SELECT 0, 0, 0, 0, 0 INTO id_return, max_conn, max_quest, max_add_c, max_add_w;
		
	END IF;
	
	CLOSE login_ask;
	
END
//
DELIMITER ;
