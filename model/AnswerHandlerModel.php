<?php

/**
 * Created by PhpStorm.
 * User: adripol94
 * Date: 1/27/17
 * Time: 5:56 PM
 */

require_once "Validate.php";
require_once "ConsAnswer.php";
require_once "ConsQuestionAnswer.php";
require_once "Answer.php";

class AnswerHandlerModel
{
    public static function getAnswer($id)
    {
        $listQuestions = null;

        if ($id == null || Validator::isValid($id)) {
            $db = DatabaseModel::getInstance();
            $db_connection = $db->getConnection();

            $query = "SELECT * FROM " . ConsDB\ConsAnswer::TABLE_NAME;

            if ($id != null)
                $query = $query . " WHERE " . ConsDB\ConsAnswer::ID
                    . " = ?";

            $prepare_query = $db_connection->prepare($query);

            if ($id != null)
                $prepare_query->bind_param('i', $id);

            $prepare_query->execute();
            $listQuestions = array();

            $prepare_query->bind_param($id, $name);

            while ($prepare_query->fetch()) {
                $quest = new Answer($id, $name);
                $listQuestions = $quest;
            }

            if (sizeof($listQuestions) <= 1)
                $res = $quest;
            else
                $res = $listQuestions;
        }

        $db_connection->close();
        return $res;
    }

    public static function getAnswerByQuestion($idQuestion)
    {
        $listQuestions = null;

        if (Validator::isValid($idQuestion)) {
            $db = DatabaseModel::getInstance();
            $db_connection = $db->getConnection();

            /* QUERY:
             * SELECT a.id, a.answer, a.correct FROM Answers AS a, QuestionsAnswers AS qa WHERE a.id = qa.idAnswer
             * AND qa.idQuestion = 1;
             */

            $query = "SELECT a." . ConsDB\ConsAnswer::ID . ", a." . ConsDB\ConsAnswer::ANSWER . ", a." . ConsDB\ConsAnswer::CORRECT
                . " FROM " . \ConsDB\ConsAnswer::TABLE_NAME . " AS a, " . \ConsDB\ConsQuestionAnswer::TABLE_NAME . " AS qa"
                . " WHERE a." . ConsDB\ConsAnswer::ID . "=qa." . \ConsDB\ConsQuestionAnswer::IDANSWER . " AND qa."
                . \ConsDB\ConsQuestionAnswer::IDQUESTION . "=?";

            $prepare_query = $db_connection->prepare($query);
            $prepare_query->bind_param('i', $idQuestion);

            $prepare_query->execute();
            $listQuestions = array();

            $prepare_query->bind_result($id, $answer, $correct);

            while ($prepare_query->fetch()) {
                $quest = new Answer($id, utf8_encode($answer), $correct);
                $listQuestions[] = $quest;
            }

            if (sizeof($listQuestions) <= 1)
                $res = $quest;
            else
                $res = $listQuestions;
        }
        return $res;
    }


    /*
     * For Create
     */
    public static function putAnswer(Answer $answer)
    {
        $code = '400';

        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();

        if (categoria != null) {
            $query = "INSER INTO " . \ConsDB\ConsAnswer::TABLE_CATEGORYS
                . " (" . ConsDB\ConsAnswer::CATEGORY_NAME . ") VALUES (?)";

            $prepare_query = $db_connection->prepare($query);
            $prepare_query->bind_param('s', $answer->getName());
            $ready = $prepare_query->execute();

            if ($ready) {
                $code = '200';
            }
        }

        $db_connection->close();
        return $code;
    }

    /*
     * For Post
     */
    public static function postAnswer(Request $request)
    {
        $code = '400';


        if (Validator::isValid($answer->getId())) {

            $db = DatabaseModel::getInstance();
            $db_connection = $db->getConnection();

            $query = "UPDATE " . \ConsDB\ConsAnswer::TABLE_CATEGORYS
                . " SET " . ConsDB\ConsAnswer::CATEGORY_NAME . " = ?"
                . ConsDB\ConsAnswer::ID . " = ?";

            $prepare_query = $db_connection->prepare($query);
            $prepare_query->bind_param('si', $answer->getName(), $answer->getId());
            $result = $prepare_query->execute();

            if ($result)
                $code = '200';
        }

        $db_connection->close();
        return $code;
    }

    /*
     * For Post
     */
    public static function postAnswerByObj(Answer $answer)
    {
        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();

        $query = "INSERT INTO " . \ConsDB\ConsAnswer::TABLE_NAME . " ("
            . \ConsDB\ConsAnswer::ANSWER . "," . \ConsDB\ConsAnswer::CORRECT . ") VALUES (?,?)";

        $prepare_query = $db_connection->prepare($query);
        $answerString = $answer->getAnswer();
        $correct = (int) $answer->getCorrect();
        $prepare_query->bind_param('si',$answerString , $correct);
        $result = $prepare_query->execute();

        if ($result)
            $answer->setId($prepare_query->insert_id);


        $prepare_query->close();

        return $answer;
    }

    public static function delAnswer(Answer $answer)
    {
        $code = '400';

        if (self::isValid($answer->getId()) && $answer->getId() != null) {
            $db = DatabaseModel::getInstance();
            $db_connection = $db->getConnection();

            $query = "DELETE FROM " . ConsDB\ConsAnswer::TABLE_CATEGORYS
                . " WHERE " . ConsDB\ConsAnswer::ID . " = ?";

            $prepare_query = $db_connection->prepare($query);
            $result = $prepare_query->bind_param('i', $answer->getId());

            if ($result)
                $result = '200';
        }

        $db_connection->close();
        return $code;
    }
}