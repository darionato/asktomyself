DELIMITER //
DROP FUNCTION IF EXISTS `func_count_questions` //
CREATE FUNCTION `func_count_questions`(the_user INT, the_word INT) RETURNS INT NOT DETERMINISTIC
BEGIN

        DECLARE ret_count INT DEFAULT 0;

	-- check for no ask question
	DECLARE question_count CURSOR FOR
                SELECT Count(*) AS ret FROM `askme_questions` q
                WHERE (q.id_user = the_user) AND (q.id_word = the_word) AND
                (q.date BETWEEN DATE_ADD(NOW(), INTERVAL -30 DAY) AND NOW())
                ORDER BY q.date
                LIMIT 0,1;


	OPEN question_count;

	FETCH question_count INTO ret_count;

	CLOSE question_count;

        RETURN ret_count;

END
//
DELIMITER ;
