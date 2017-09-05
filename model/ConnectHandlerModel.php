<?php

/**
 * Created by PhpStorm.
 * User: adrianpolalcala
 * Date: 5/25/17
 * Time: 11:33 AM
 */
require_once "Connect.php";
require_once "ConsConnection.php";
require_once "UserHandlerModel.php";
require_once "User.php";
require_once "Roll.php";

class ConnectHandlerModel
{
    const UNKNOWN = "unknown";

    public static function getConnection($user) {
        $connect = null;

        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();

        if ($user != null) {
            $query = "SELECT * FROM " . \ConsDB\ConsConnection::TABLA_NAME . " WHERE "
                . \ConsDB\ConsConnection::NAME_USER . "=?";

            $prepare_query = $db_connection->prepare($query);

            $prepare_query->bind_param("s", $user);
            $bool = $prepare_query->execute();

            $prepare_query->bind_result($id, $name, $fecha, $email);

            while($prepare_query->fetch()) {
                $connect = new Connect($id, $name, $fecha, $email);
            }

            if ($connect == null) {
                $prepare_query->close();
                self::setConnection($user);
                $connect = self::getConnection($user);
            }

            return $connect;
        }
    }

    public static function setConnection($user) {
        $bool = false;
        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();

        if ($user != null) {
            $query = "INSERT INTO " . \ConsDB\ConsConnection::TABLA_NAME . "(" . \ConsDB\ConsConnection::NAME_USER
                . "," . \ConsDB\ConsConnection::EMAIL . ") VALUES (?,?)";
            $prepare_query = $db_connection->prepare($query);
            $prepare_query->bind_param("ss", $user);
            $bool = $prepare_query->execute();

            $user = new User($user, "deconocido", $user,
                ConnectHandlerModel::UNKNOWN, $user.'@gmail.com', 0);
            $roll = new Roll("GoogleUser", "A user from Google");
            $roll->setId(2);
            $user->setRoll($roll);
            //Se introduce el usuario en la base de datos
            UserHandlerModel::setUser($user);

            $prepare_query->close();
        }

        return $bool;
    }
}