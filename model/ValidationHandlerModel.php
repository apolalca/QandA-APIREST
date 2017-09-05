<?php

/**
 * Created by PhpStorm.
 * User: apol
 * Date: 8/02/17
 * Time: 12:19
 */

require_once "ConsQuestionAnswer.php";
require_once "QuestionAnswer.php";
require_once "ConsGamesQuestion.php";
require_once "ConsAnswer.php";

class ValidationHandlerModel
{
    const PREGUNTA_BIEN = 10;
    const PREGUNTA_MAL = 1;

    public static function checkValidation(Validation $validation) {
        $answer = $validation->getQuestionAnswer();
        $listAnswer = array();
        if ($answer != null) {

            //GET the answer from table
            $db = DatabaseModel::getInstance();
            $db_connection = $db->getConnection();

            //SELECT QA.idQuestion, QA.idAnswer FROM QuestionsAnswers AS QA, GamesQuestions AS GQ, Answers AS A WHERE
            // GQ.idGame=1 AND GQ.idQuestion= QA.idQuestion AND QA.idAnswer=A.id AND A.correct=1;

            $query = "SELECT QA." . \ConsDB\ConsQuestionAnswer::IDQUESTION . ", QA." . \ConsDB\ConsQuestionAnswer::IDANSWER
            . " FROM " . \ConsDB\ConsQuestionAnswer::TABLE_NAME . " AS QA, " . \ConsDB\ConsGamesQuestion::TABLE_NAME . " AS GQ, "
            . \ConsDB\ConsAnswer::TABLE_NAME . " AS A WHERE GQ." . \ConsDB\ConsGamesQuestion::ID_GAME . "=?" . " AND GQ."
            . \ConsDB\ConsGamesQuestion::ID_QUESTION . "= QA." . \ConsDB\ConsGamesQuestion::ID_QUESTION  . " AND QA."
            . \ConsDB\ConsQuestionAnswer::IDANSWER . "=" . "A." . \ConsDB\ConsAnswer::ID . " AND A."
            . \ConsDB\ConsAnswer::CORRECT . "=1";

            $prepare_query = $db_connection->prepare($query);
            $idGame = $validation->getIdGame();
            $prepare_query->bind_param('i', $idGame);
            $prepare_query->execute();
            $prepare_query->bind_result($idQuestion, $idAnswer);

            while ($prepare_query->fetch()) {
                $listAnswer[] = new QuestionAnswer($idQuestion, $idAnswer);
            }

            //Check if the answer is well
            $validation->setPoints(self::validateAnswer($answer, $listAnswer));

            $prepare_query->close();

        }
        return $validation;
    }

    /**
     * Valida y puntua las preguntas enviadas por el request.
     *
     * @param $questionAnswerRequest lista de preguntas y respuestas obtenidas del request
     * @param $listAnswerDB Lista de preguntas y respuestas obtenidas por la base de datos
     * @return puntuacion total
     */
    private static function validateAnswer($questionAnswerRequest, $listAnswerDB) {
        $preguntasCorrectas = 0;
        $preguntasIncorrectas = 0;

        for($i = 0; $i < sizeof($questionAnswerRequest); $i++) {
            $posArray = self::finderQuestion($questionAnswerRequest[$i]->getIdQuestion(), $listAnswerDB);

            if ($questionAnswerRequest[$i]->getIdAnswer() == $listAnswerDB[$posArray]->getIdAnswer()) {
                $preguntasCorrectas++;
            } else {
                $preguntasIncorrectas++;
            }
        }

        return $preguntasCorrectas * 100 / sizeof($listAnswerDB);
    }

    private static function finderQuestion($idQuestion, $listAnswer) {
        $encontrado = false;
        $posEnArray = null;

        for ($i=0; $i<sizeof($listAnswer) && !$encontrado; $i++) {
            if ($listAnswer[$i]->getIdQuestion() == $idQuestion){
                $encontrado = true;
                $posEnArray = $i;
            }
        }
        return $posEnArray;
    }
}