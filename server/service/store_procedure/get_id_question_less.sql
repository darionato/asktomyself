DELIMITER //
DROP PROCEDURE IF EXISTS `get_id_question_less` //
CREATE PROCEDURE `get_id_question_less`(IN the_user INT, IN the_category INT, OUT id_question VARCHAR(130))
BEGIN

	DECLARE no_records INT DEFAULT 0;
	
	-- if no words never asked, ask the more less asked words
	DECLARE question_less CURSOR FOR
		SELECT CONCAT("(", CONCAT_WS(":", w.id_word, TRIM(w.from), TRIM(w.to)), ")") AS ret
                FROM `askme_questions` q
                INNER JOIN `askme_words` w ON q.id_word = w.id_word
                INNER JOIN `askme_categories` c ON w.id_category = c.id_category
                WHERE (q.id_user = the_user) AND (w.id_category = the_category)
                GROUP BY w.id_word, w.from, w.to
                ORDER BY ((100 / count(w.id_word)) * sum(if((q.result & 2)=2,1,0)))
                LIMIT 0,1;
	
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET no_records = 1;
	
	OPEN question_less;
	
	FETCH question_less INTO id_question;
	
	IF no_records = 1 THEN

		SELECT "" INTO id_question;
		
	END IF;
	
	CLOSE question_less;
	
END
//
DELIMITER ;
