<?php

/**
 * Created by PhpStorm.
 * User: apol
 * Date: 27/01/17
 * Time: 12:48
 */

require_once "Validate.php";
require_once "Category.php";
require_once "ConsCategory.php";

class CategoryHandlerModel
{
    public static function getCategory($id) {
        $listCategory = null;

        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();

        if ($id == null || Validator::isValid($id)) {
            $query = "SELECT * FROM " . \ConsDB\ConsCategory::TABLE_CATEGORYS;


            if ($id != null)
                $query = $query . " WHERE " . \ConsDB\ConsCategory::ID
                    . "=?";

            $prepare_query = $db_connection->prepare($query);

            if ($id != null)
                $prepare_query->bind_param('i', $id);

            $prepare_query->execute();
            $listCategory = array();

            $prepare_query->bind_result($id, $category, $img);

            while ($prepare_query->fetch()) {
                //Ya que la base de datos no devuelve un caracter UTF-8 o en algun lado el caracter no viene bien
                // decodificamos lo volvemos a UTF-8 aqui.
                $categ = new Category($id, utf8_encode($category), $img);
                $listCategory[] = $categ;
            }

            if (sizeof($listCategory) <= 1)
                $res = $categ;
            else
                $res = $listCategory;

            $db_connection->close();
        }
        return $res;
    }

    /*
     * For Create
     *
     */
    public static function putCategory(Category $category) {
        $code = '400';

        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();

        if (categoria != null) {
            $query = "INSER INTO " . \ConsDB\ConsCategory::TABLE_CATEGORYS
                . " (" . ConsDB\ConsCategory::CATEGORY_NAME . ") VALUES (?)";

            $prepare_query = $db_connection->prepare($query);
            $prepare_query->bind_param('s', $category->getName());
            $ready = $prepare_query->execute();

            if ($ready) {
                $code = '200';
            }
            $db_connection->close();
        }
        return $code;
    }

    /*
     * For Update
     */
    public static function postCategory(Category $category) {
        $code = '400';

        if (Validator::isValid($category->getId())) {

            $db = DatabaseModel::getInstance();
            $db_connection = $db->getConnection();

            $query = "UPDATE " . \ConsDB\ConsCategory::TABLE_CATEGORYS
                . " SET " . ConsDB\ConsCategory::CATEGORY_NAME . " = ? WHERE " . ConsDB\ConsCategory::ID
                . "=?";

            $prepare_query = $db_connection->prepare($query);

            //Passing by reference not
            $nameCategory = $category->getName();
            $id = $category->getId();

            $prepare_query->bind_param('si', $nameCategory, $id);
            $result = $prepare_query->execute();

            if ($result)
                $code = '200';
            $db_connection->close();
        }

        return $code;
    }

    public static function delCategory($id) {
        $code = '400';

        if (self::isValid($id)) {
            $db = DatabaseModel::getInstance();
            $db_connection = $db->getConnection();

            $query = "DELETE FROM " . ConsDB\ConsCategory::TABLE_CATEGORYS
                . " WHERE " . ConsDB\ConsCategory::ID . " = ?";

            $prepare_query = $db_connection->prepare($query);
            $result = $prepare_query->bind_param('i', $id);

            if ($result)
                $code = '200';
            $db_connection->close();
        }
        return $code;
    }
}