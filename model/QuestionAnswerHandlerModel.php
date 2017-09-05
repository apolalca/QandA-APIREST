<?php

/**
 * Created by PhpStorm.
 * User: adripol94
 * Date: 3/9/17
 * Time: 2:37 PM
 */
class QuestionAnswerHandlerModel
{
    public static function postQuestionAnswerByIds(QuestionAnswer $questionAnswer) {
        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();

        $query = "INSERT INTO " . \ConsDB\ConsQuestionAnswer::TABLE_NAME . " (" . \ConsDB\ConsQuestionAnswer::IDQUESTION
            . "," . \ConsDB\ConsQuestionAnswer::IDANSWER . ") VALUES (?,?)";

        $prepare_query = $db_connection->prepare($query);
        $idQ = $questionAnswer->getIdQuestion();
        $idA = $questionAnswer->getIdAnswer();
        $prepare_query->bind_param('ii', $idQ, $idA);
        $bool = $prepare_query->execute();

        $prepare_query->close();

        return $bool;
    }
}