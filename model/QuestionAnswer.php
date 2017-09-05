<?php

/**
 * Created by PhpStorm.
 * User: adripol94
 * Date: 2/11/17
 * Time: 2:40 AM
 */
class QuestionAnswer implements JsonSerializable
{
    private $idQuestion;
    private $idAnswer;

    public function __construct($idQuestion, $idAnswer)
    {
        $this->idQuestion = $idQuestion;
        $this->idAnswer = $idAnswer;
    }

    /**
     * @return mixed
     */
    public function getIdQuestion()
    {
        return $this->idQuestion;
    }

    /**
     * @param mixed $idQuestion
     */
    public function setIdQuestion($idQuestion)
    {
        $this->idQuestion = $idQuestion;
    }

    /**
     * @return mixed
     */
    public function getIdAnswer()
    {
        return $this->idAnswer;
    }

    /**
     * @param mixed $idAnswer
     */
    public function setIdAnswer($idAnswer)
    {
        $this->idAnswer = $idAnswer;
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
            "idQuestion" => $this->idQuestion,
            "idAnswer" => $this->idAnswer
        );
    }
}