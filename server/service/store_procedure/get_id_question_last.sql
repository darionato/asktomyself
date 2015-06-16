DELIMITER //
DROP PROCEDURE IF EXISTS `get_id_question_last` //
CREATE PROCEDURE `get_id_question_last`(IN the_user INT, IN the_category INT, 
                    OUT id_question VARCHAR(130), OUT id_last_question INT)
BEGIN

	DECLARE no_records INT DEFAULT 0;
	DECLARE is_wrong INT DEFAULT 0;
	
	-- if the last one is wrong, i re-ask it
	DECLARE question_last CURSOR FOR
                SELECT CONCAT("(", CONCAT_WS(":", w.id_word, TRIM(w.from), TRIM(w.to)), ")") AS ret,
                (q.result & 2) AS wrong, w.id_word
                FROM (`askme_categories` c
                INNER JOIN `askme_words` w ON c.id_category = w.id_category)
                INNER JOIN `askme_questions` q ON w.id_word = q.id_word
                WHERE (c.id_category = the_category) AND (q.id_user = the_user) AND
                (q.date BETWEEN DATE_ADD(NOW(), INTERVAL -30 DAY) AND NOW())
                ORDER BY q.date DESC
                LIMIT 0,1;
	
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET no_records = 1;
	
	OPEN question_last;
	
	FETCH question_last INTO id_question, is_wrong, id_last_question;
	
	IF (no_records = 1) THEN

            SELECT "" INTO id_question;
            SELECT 0 INTO id_last_question;
		
	END IF;

        IF (is_wrong = 0) THEN

            SELECT "" INTO id_question;

        END IF;
	
	CLOSE question_last;
	
END
//
DELIMITER ;
