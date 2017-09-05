<?php

/**
 * Created by PhpStorm.
 * User: apol
 * Date: 27/01/17
 * Time: 12:41
 */
class Answer implements JsonSerializable
{
    private $id;
    private $answer;
    private $correct;

    /**
     * Answer constructor.
     * @param $id
     * @param $answer
     * @param $correct
     */
    public function __construct($id, $answer, $correct)
    {
        $this->id = $id;
        $this->answer = $answer;
        $this->correct = (bool) $correct;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param mixed $answer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
    }

    /**
     * @return mixed
     */
    public function getCorrect()
    {
        return $this->correct;
    }

    /**
     * @param mixed $correct
     */
    public function setCorrect($correct)
    {
        $this->correct = $correct;
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
            'id' => $this->id,
            'answer' => $this->answer,
            'correct' => $this->correct
        );
    }
}