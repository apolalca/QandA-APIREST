<?php

/**
 * Created by PhpStorm.
 * User: adripol94
 * Date: 2/11/17
 * Time: 5:21 PM
 */

require_once "Game.php";
require_once "GameHandlerModel.php";
require_once "ConsGamesQuestion.php";
require_once "ConsGame.php";

class GameHandlerModel
{
    public static function postGame(Request $request) {


        $game = new Game(
            $request->getBodyParameters()->idCategory,
            $request->getBodyParameters()->idUserCreator,
            $request->getBodyParameters()->numGammers,
            null,
            null,
            $request->getBodyParameters()->questions
        );

        $id = null;

        if ($game != null) {
            $db = DatabaseModel::getInstance();
            $db_connection = $db->getConnection();

            $query = "INSERT INTO " . \ConsDB\ConsGame::TABLE_NAME . " (" . \ConsDB\ConsGame::ID_CATEGORY . ", "
                . \ConsDB\ConsGame::DATE . ", " . \ConsDB\ConsGame::ID_USER_CREATOR . ", " . \ConsDB\ConsGame::NUM_GAMERS
                . ") VALUES (?,?,?,?)";

            $prepare_query = $db_connection->prepare($query);

            $idCategory = $game->getIdCategoria();
            $date = $game->getDate();
            $idUserCreator = $game->getIdUserCreator();
            $numGamers = $game->getNumGammers();

            $prepare_query->bind_param('iiii', $idCategory, $date, $idUserCreator, $numGamers);
            $isOk = $prepare_query->execute();

            if ($isOk) {
                $id = $prepare_query->insert_id;
            }

            if ($isOk)
                self::createGameQuestion($id, $game->getQuestions());
        }

        $prepare_query->close();

        $game->setId($id);
        return $game;
    }

    private static function createGameQuestion($idGame, $questions) {
        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();

        $query = "INSERT INTO " . \ConsDB\ConsGamesQuestion::TABLE_NAME . "(" . \ConsDB\ConsGamesQuestion::ID_GAME
            . "," . \ConsDB\ConsGamesQuestion::ID_QUESTION . ") VALUES (?,?)";

        $prepare_query = $db_connection->prepare($query);

        foreach ($questions as $value) {
            $idQuestion = $value->idQuestion;

            $prepare_query->bind_param('ii', $idGame, $idQuestion);
            $isOk = $prepare_query->execute();
        }
    }

}