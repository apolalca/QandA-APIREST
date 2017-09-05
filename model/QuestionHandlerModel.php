<?php

/**
 * Created by PhpStorm.
 * User: adripol94
 * Date: 1/27/17
 * Time: 5:56 PM
 */

require_once "ConsQuestion.php";
require_once "Question.php";
require_once "Validate.php";
require_once "Validator.php";
require_once "Answer.php";
require_once "AnswerHandlerModel.php";
require_once "QuestionAnswer.php";
require_once "QuestionAnswerHandlerModel.php";

class QuestionHandlerModel
 {
    public static function getQuestion($id) {
        $listQuestions = null;

        if ($id == null || Validator::isValid($id)) {
            $db = DatabaseModel::getInstance();
            $db_connection = $db->getConnection();

            $query = "SELECT * FROM " . ConsDB\ConsQuestion::TABLE_NAME;

            if ($id != null)
                $query = $query . " WHERE " . ConsDB\ConsQuestion::ID
                    . " = ?";

            $prepare_query = $db_connection->prepare($query);

            if ($id != null) {
                $prepare_query->bind_param('i', $id);
            }

            $prepare_query->execute();
            $listQuestions = array();

            $prepare_query->bind_result($id, $name, $correct, $idCategory);

            while ($prepare_query->fetch()) {
                $quest = new Question($id, $name, $correct, $idCategory);
                $listQuestions[] = $quest;
            }

            //TODO DEPURAR ESTO
            //$prepare_query->close(); Si descomento esto salen miles de errores...

            $listQuestions = self::setAnswerToQuestions($listQuestions);

            if (sizeof($listQuestions)<=1)
                $res = $listQuestions[0];
            else {
                $res = $listQuestions;
            }

            //$db_connection->close();
            // ya que usamor AnswerTo Question ella misma cierra la conexion entonces cuando pasa por aqui si to_do sale
            // bien la conexion estara nula y or tanto no hara falta cerrarla
        }
        //if ($db_connection->get_connection_stats())
        //    $db_connection->close();
        return $res;
    }

    public function getQuestionByCategory($idCategory) {
        if (Validator::isValid($idCategory)) {
            $listQuestions = null;
            $db = DatabaseModel::getInstance();
            $db_connection = $db->getConnection();

            $query = "SELECT * FROM " . ConsDB\ConsQuestion::TABLE_NAME . " WHERE "
                . \ConsDB\ConsQuestion::IDCATEGORIES . "=?";

            $prepare_query = $db_connection->prepare($query);

            $prepare_query->bind_param('i', $idCategory);

            $prepare_query->execute();
            $listQuestions = array();

            $prepare_query->bind_result($id, $name, $correct, $idCategory);

            while ($prepare_query->fetch()) {
                $quest = new Question($id, utf8_encode($name), $correct, $idCategory);
                $listQuestions[] = $quest;
            }

            //TODO DEPURAR ESTO
            //$prepare_query->close(); Si descomento esto salen miles de errores...

            $listQuestions = self::setAnswerToQuestions($listQuestions);

            if (sizeof($listQuestions)<=1)
                $res = $listQuestions[0];
            else {
                $res = $listQuestions;
            }
        }
        return $res;
    }

    /**
     * Encargado de buscar y recoger todas las respuestas de cada pregunta.
     * @param $listQuestions array de preguntas
     * @return mixed devuelve el mismo array peo con los atributos de Answer rellenos.
     */
    private function setAnswerToQuestions($listQuestions) {

        for ($i = 0; $i < sizeof($listQuestions); $i++) {
            $listQuestions[$i]->setAnswer(AnswerHandlerModel::getAnswerByQuestion($listQuestions[$i]->getId()));
        }

        return $listQuestions;
    }

    private static function getQuestionFromCategory($idCategory) {
        $listQuestions = null;

        if (Validator::isValid($idCategory)) {
            $db = DatabaseModel::getInstance();
            $db_connection = $db->getConnection();

            $query = "SELECT * FROM " . ConsDB\ConsQuestion::TABLE_NAME
            . " WHERE " . ConsDB\ConsQuestion::IDCATEGORIES . "=?";

            $prepare_query = $db_connection->prepare($query);
            $prepare_query->bind_param('i', $idCategory);

            $prepare_query->execute();
            $listQuestions = array();

            $prepare_query->bind_param($idCategory, $name);

            while ($prepare_query->fetch()) {
                $quest = new Question($idCategory, $name);
                $listQuestions = $quest;
            }

            if (sizeof($listQuestions)<=1)
                $res = $quest;
            else
                $res = $listQuestions;

            //if ($db_connection->)
            $db_connection->close();
        }

        return $res;
    }


    /*
     * For Create
     */
    public static function putQuestion(Question $question) {
        $code = '400';

        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();

        if (categoria != null) {
            $query = "INSER INTO " . \ConsDB\ConsQuestion::TABLE_CATEGORYS
                . " (" . ConsDB\ConsQuestion::CATEGORY_NAME . ") VALUES (?)";

            $prepare_query = $db_connection->prepare($query);
            $prepare_query->bind_param('s', $question->getName());
            $ready = $prepare_query->execute();

            if ($ready) {
                $code = '200';
            }
        }

        $db_connection->close();
        return $code;
    }

    /*
     * For Update
     */
    public static function postQuestion(Request $request) {
        $question = null;
        $answer = null;

        if (isset($request->getBodyParameters()->question) &&
            isset($request->getBodyParameters()->difficulty)&&
            isset($request->getBodyParameters()->idCategory)) {

            $question = new Question(null,
                $request->getBodyParameters()->question,
                $request->getBodyParameters()->difficulty,
                $request->getBodyParameters()->idCategory);

            if (isset($request->getBodyParameters()->answers)) {
                $answer = array();

                $db = DatabaseModel::getInstance();
                $db_connection = $db->getConnection();

                $query = "INSERT INTO " . \ConsDB\ConsQuestion::TABLE_NAME . "("
                    . \ConsDB\ConsQuestion::QUESTION_STRING . ","
                    . \ConsDB\ConsQuestion::DIFFICULTY . ","
                    . \ConsDB\ConsQuestion::IDCATEGORIES . ") VALUE (?,?,?)";

                $prepare_query = $db_connection->prepare($query);
                $questionStirng = $question->getQuestion();
                $difficulty = $question->getDifficulty();
                $category = $question->getCategory();
                $prepare_query->bind_param('ssi',$questionStirng , $difficulty,$category);
                $result = $prepare_query->execute();

                $question->setId($prepare_query->insert_id);

                $prepare_query->close();

                //Si se ha introducido bien introducimos las respuestas
                if ($result) {
                    foreach ($request->getBodyParameters()->answers as $value) {
                        $answerObj = new Answer(null,$value->answer, $value->correct);
                        $answer[] = AnswerHandlerModel::postAnswerByObj($answerObj);
                    }
                }
                $question->setAnswer($answer);

                foreach ($question->getAnswer() as $value) {
                    $questionAnswer = new QuestionAnswer($question->getId(), $value->getId());
                    QuestionAnswerHandlerModel::postQuestionAnswerByIds($questionAnswer);
                }

            }
        }

        return $question;
    }

    public static function delQuestion(Question $question) {
        $code = '400';

        if (self::isValid($question->getId()) && $question->getId() != null) {
            $db = DatabaseModel::getInstance();
            $db_connection = $db->getConnection();

            $query = "DELETE FROM " . ConsDB\ConsQuestion::TABLE_CATEGORYS
                . " WHERE " . ConsDB\ConsQuestion::ID . " = ?";

            $prepare_query = $db_connection->prepare($query);
            $result = $prepare_query->bind_param('i', $question->getId());

            if ($result)
                $result = '200';
        }

        $db_connection->close();
        return $code;
    }
}