<?php

/**
 * Created by PhpStorm.
 * User: apol
 * Date: 8/02/17
 * Time: 11:59
 */

require_once "QuestionAnswer.php";

class Validation implements JsonSerializable
{
    private $questionAnswer;
    private $idUser;
    private $idCategory;
    private $idGame;
    private $points;
    private $time;

    private function __construct($idUser, $idCategory, $time, $questionAnswer, $idGame)
    {
        $this->idUser = $idUser;
        $this->idCategory = $idCategory;
        $this->time = $time;
        $this->questionAnswer = $questionAnswer;
        $this->idGame = $idGame;
        $this->points = -1;
    }

    /**
     * @return int
     */
    public function getIdGame()
    {
        return $this->idGame;
    }

    /**
     * @param int $idGame
     */
    public function setIdGame($idGame)
    {
        $this->idGame = $idGame;
    }


    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    public function setQuestionAnswer($key, $value)
    {
        $this->questionAnswer[$key] = $value;
    }

    public function getQuestionAnswer()
    {

        return $this->questionAnswer;
    }

    public function getIdUser()
    {
        return $this->idUser;
    }

    public function getIdCategory()
    {
        return $this->idCategory;
    }

    public function setPoints($point)
    {
        $this->points = (int) $point;
    }

    public function getPoint()
    {
        return $this->points;
    }

    public static function createValidationObj(Request $request)
    {
        $validation = null;

        $lisQuestionAnswer = array();


        $user = $request->getBodyParameters()->idUser;
        $category = $request->getBodyParameters()->idCategory;
        $time = $request->getBodyParameters()->time;
        $idGame = $request->getBodyParameters()->idGame;

        //http://stackoverflow.com/questions/19495068/convert-stdclass-object-to-array-in-php
        foreach ($request->getBodyParameters()->answers as $value) {
            $lisQuestionAnswer[] = new QuestionAnswer($value->idQuestion, $value->idAnswer);
        }
        $validation = new Validation($user, $category, $time, $lisQuestionAnswer, $idGame);


        return $validation;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return array(
            "idUser" => $this->idUser,
            "idCategory" => $this->idCategory,
            "time" => $this->time,
            "points" => $this->points,
            "questionAnswer" => $this->questionAnswer
        );
    }
}