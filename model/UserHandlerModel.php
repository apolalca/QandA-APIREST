<?php

use ConsDB\ConsUser;

/**
 * Created by PhpStorm.
 * User: adripol94
 * Date: 1/12/17
 * Time: 9:26 PM
 */

require_once "ConsUser.php";
require_once "Security.php";
require_once "User.php";
require_once "Validate.php";

class UserHandlerModel
{

    public static function setUser(User $user)
    {
        $userId = null;

        if ($user != null) {

            //Implementaciones de seguridad
            try {
                $user->setPassword(Security::encode_Hash($user->getPassword()));
            } catch (Exception $e) {
                //Todo mejorar esto;
                return $userId;
            }

            $db = DatabaseModel::getInstance();
            $db_connection = $db->getConnection();

            $query = "INSERT INTO " . ConsDB\ConsUser::NAME_TABLE
                . " (" . Consdb\ConsUser::EMAIL . ", "
                . ConsDB\ConsUser::NAME . ", " . \ConsDB\ConsUser::SURNAME . ", "
                . \ConsDB\ConsUser::AGE . ", " . \ConsDB\ConsUser::USER . ", "
                . \ConsDB\ConsUser::PASSWORD . "," . \ConsDB\ConsUser::ROLL . ") VALUES (?,?,?,?,?,?,?)";

            $prepare_query = $db_connection->prepare($query);

            $prepare_query->bind_param('ssssssi', $user->getEmail(),
                $user->getName(), $user->getSurname(), $user->getAge(),
                $user->getUser(), $user->getPassword(), $user->getRoll()->getId());

            $ready = $prepare_query->execute();

            if (!$ready) {
                throw new ErrorException($prepare_query->error);
            }
            
            $userId = mysql_insert_id();
            
        }
        return $userId;
    }

    public static function getUserById($id) {
        $listUser = null;

        if ($id == null || Validate::isValid($id)) {
            $db = DatabaseModel::getInstance();
            $db_connection = $db->getConnection();

            $query = "SELECT * FROM "
                . ConsDB\ConsUser::NAME_TABLE;
            if ($id != null)
                $query = $query . " WHERE " . \ConsDB\ConsUser::ID . "= ? ";

            $prepare_query = $db_connection->prepare($query);

            if ($id != null) {
                $prepare_query->bind_param('i', $id);
            }

            $prepare_query->execute();
            $prepare_query->bind_result($id, $email, $name, $surname, $age, $user, $password, $roll);

            while ($prepare_query->fetch()) {
                $user = new User($user, $password, $surname, $name, $email, $age);
                $user->setId($id);
                $listUser[] = $user;
            }

            $listUser = self::getRollsById($roll, $listUser);

            if (sizeof($listUser) <= 1) {
                $res = $user;
            } else {
                $res = $listUser;
            }

            $prepare_query->close();
        }

        return $res;
    }

    public static function getUserByEmail($user) {
        if ($user != null) {
            $listUser = null;
            $db = DatabaseModel::getInstance();
            $db_connection = $db->getConnection();

            $query = "SELECT * FROM "
                . ConsDB\ConsUser::NAME_TABLE . " WHERE "
                . \ConsDB\ConsUser::EMAIL . "= ? ";

            $prepare_query = $db_connection->prepare($query);

            $prepare_query->bind_param('s', $user);

            $prepare_query->execute();
            $prepare_query->bind_result($id, $email, $name, $surname, $age, $user, $password, $roll);
            $prepare_query->fetch();

            try {
                $user = new User($user, $password, $surname, $name, $email, $age);
                $user->setId($id);

                $listUser = array();

                $listUser[] = $user;

                $prepare_query->close();

                $user = self::getRollsById($roll, $listUser);

            } catch (ErrorException $e) {
                throw new ErrorException("No se encontro el usuario");
            }
        }
        return $user[0];
    }
    
    public function getUserByUser($user) {
        $userObj = null;
        
        if ($user != null) {
            $db = DatabaseModel::getInstance();
            $db_connection = $db->getConnection();
            
            $query = "SELECT * FROM " . \ConsDB\ConsUser::NAME_TABLE . " WHERE "
                . \ConsDB\ConsUser::USER . "=?";
            $prepare_query = $db_connection->prepare($query);
            $prepare_query->bind_param("s", $user);
            $prepare_query->execute();
            $prepare_query->bind_result($id, $email, $name, $surname, $age, $user, $password, $roll);
            $prepare_query->fetch();
            
            try {
                $userObj = new User($user, $password, $surname, $name, $email, $age);
                $userObj->setId((int)$id);
                
                //$prepare_query->close();
            } catch (ErrorException $e) {
                throw new ErrorException("No se encontro el usuario");
            }
        }
        return $userObj;
    }

    public static function getUserByPass($pass) {
        if ($pass != null) {
            $listUser = null;
            $db = DatabaseModel::getInstance();
            $db_connection = $db->getConnection();

            $query = "SELECT * FROM "
                . ConsDB\ConsUser::NAME_TABLE . " WHERE "
                . \ConsDB\ConsUser::PASSWORD . "= ? ";

            $prepare_query = $db_connection->prepare($query);

            $prepare_query->bind_param('s', $pass);

            $prepare_query->execute();
            $prepare_query->bind_result($id, $email, $name, $surname, $age, $user, $password, $roll);
            $prepare_query->fetch();

            $listUser = array();

            //Para que sea compatible con el metodo getRollsById lo haremos array aunque sepamos que solo tiene 1 objeto
            $user = new User($user, $password, $surname, $name, $email, $age);
            $user->setId($id);
            $listUser[] = $user;

            $user = self::getRollsById($roll, $listUser);

            //$prepare_query->close();
        }

        return $user;
    }

    private static function getRollsById($rollId, $listUser) {
        for ($i = 0; $i < sizeof($listUser); $i++) {
            $listUser[$i]->setRoll(RollHandlerModel::getRoll($rollId));
        }
        return $listUser;
    }
}