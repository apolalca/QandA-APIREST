<?php

/**
 * Created by PhpStorm.
 * User: apol
 * Date: 27/01/17
 * Time: 12:35
 */
class Question implements JsonSerializable
{
    const DIFFICULT_HIGH = "High";
    const DIFFICULT_MEDIUM = "Medium";
    const DIFICULT_DOWN = "Down";
    private $id;
    private $question;
    private $difficulty;
    private $category;
    private $answer;

    /**
     * Question constructor.
     * @param $id
     * @param $question
     * @param $difficulty
     * @param $category
     */
    public function __construct($id, $question, $difficulty, $category)
    {
        $this->id = $id;
        $this->question = $question;
        $this->difficulty = $difficulty;
        $this->category = $category;
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
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param mixed $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * @return mixed
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * @param mixed $difficulty
     */
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param mixed $category
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
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
        //FIXME Cuando pasa por id, devuelve false y no continua
        return array(
            'id' => $this->id,
            'question' => $this->question,
            'difficulty' => $this->difficulty,
            'category' => $this->category,
            'answer' => $this->answer
        );
    }
}