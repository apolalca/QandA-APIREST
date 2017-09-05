<?php

/**
 * Created by PhpStorm.
 * User: adripol94
 * Date: 1/31/17
 * Time: 5:49 PM
 */

require_once "Validator.php";
require_once "ConsRoll.php";
require_once "Roll.php";

class RollHandlerModel
{
    public static function getRoll($id) {
        $listRoll = null;

        if ($id == null || Validator::isValid($id)) {
            $db = DatabaseModel::getInstance();
            $db_connection = $db->getConnection();


            $query = "SELECT * FROM " . ConsDB\ConsRoll::NAME_TABLE;

            if ($id != null)
                $query = $query . " WHERE " . ConsDB\ConsRoll::ID . "=?";

            $prepare_query = $db_connection->prepare($query);

            if ($id != null)
                $prepare_query->bind_param('i', $id);

            $prepare_query->execute();

            $prepare_query->bind_result($id, $name, $desc);



            $listRoll = array();

            while ($prepare_query->fetch()) {
                $roll = new Roll($name, $desc);
                $roll->setId($id);
                $listRoll[] = $roll;
            }

            if (sizeof($listRoll)<= 1) {
                $res = $roll;
            } else {
                $res = $listRoll;
            }

            $prepare_query->close();
        }

        return $res;
    }



}