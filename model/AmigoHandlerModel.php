<?php

/**
 * Created by PhpStorm.
 * User: adrianpolalcala
 * Date: 5/25/17
 * Time: 7:33 PM
 */

require_once "Friend.php";
require_once "ConsAmigo.php";

class AmigoHandlerModel
{
    public static function setAmigo($user, $amigo) {
        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();

        if ($user != null && $amigo != null) {
            $query = "INSERT INTO " . \ConsDB\ConsAmigo::TABLE_NAME . "(" . \ConsDB\ConsAmigo::AMIGO
                . "," . \ConsDB\ConsAmigo::USUARIO . ") VALUES (?,?)";

            $prepare_query = $db_connection->prepare($query);
            $prepare_query->bind_param("ii", $amigo, $user);
            $bool = $prepare_query->execute();
            $db_connection->close();

            return $bool;
        }

        return false;
    }

    public static function getAmigo($user) {
        $friend = null;
        if ($user != null) {
            $db = DatabaseModel::getInstance();
            $db_connection = $db->getConnection();

            $query = "SELECT " . \ConsDB\ConsAmigo::AMIGO . " FROM " . \ConsDB\ConsAmigo::TABLE_NAME
                . " WHERE " . \ConsDB\ConsAmigo::USUARIO . "=?";

            $prepare_query = $db_connection->prepare($query);
            $prepare_query->bind_param("i", $user);
            $prepare_query->execute();
            $prepare_query->bind_result($amigos);

            $friend = new Friend($user);
            $listAmigos = array();

            while ($prepare_query->fetch()) {
                $listAmigos[] = $amigos;
            }

            $friend->setAmigo($listAmigos);
        }

        return $friend;
    }
}