DELIMITER //
DROP PROCEDURE IF EXISTS `get_id_question` //
CREATE PROCEDURE `get_id_question`(IN the_user INT, IN the_category INT,
                        IN the_last INT, OUT id_question VARCHAR(130))
BEGIN

	DECLARE no_records INT DEFAULT 0;
	
	-- check for no ask question in the past month (filtered on the function)
	DECLARE question_no_ask CURSOR FOR
		SELECT CONCAT("(", CONCAT_WS(":", w.id_word, TRIM(w.from), TRIM(w.to)), ")") AS ret
		FROM `askme_categories` c
		INNER JOIN `askme_words` w ON c.id_category = w.id_category
		WHERE (c.id_category = the_category) AND
                (w.id_word <> the_last)
		ORDER BY func_count_questions(the_user, w.id_word), RAND()
		LIMIT 0,1;
	
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET no_records = 1;
	
	OPEN question_no_ask;
	
	FETCH question_no_ask INTO id_question;
	
	IF no_records = 1 THEN 
	
		SELECT "" INTO id_question;
		
	END IF;
	
	CLOSE question_no_ask;
	
END
//
DELIMITER ;
