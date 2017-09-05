<?php

/**
 * Created by PhpStorm.
 * User: adripol94
 * Date: 2/11/17
 * Time: 5:28 PM
 */

class Game implements JsonSerializable
{

    private $idCategoria;
    private $idUserCreator;
    private $numGammers;
    private $questions;
    private $id;
    private $date;

    /**
     * Game constructor.
     * @param $idCategoria
     * @param $idUserCreator
     * @param $numGammers
     * @param $id
     * @param $date
     */
    public function __construct($idCategoria, $idUserCreator, $numGammers, $id, $date, $questions)
    {
        $this->idCategoria = $idCategoria;
        $this->idUserCreator = $idUserCreator;
        $this->numGammers = $numGammers;
        $this->questions = $questions;

        if ($id != null)
            $this->id = $id;

        if ($date != null)
            $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * @param mixed $questions
     */
    public function setQuestions($questions)
    {
        $this->questions = $questions;
    }

    /**
     * @return mixed
     */
    public function getIdCategoria()
    {
        return $this->idCategoria;
    }

    /**
     * @param mixed $idCategoria
     */
    public function setIdCategoria($idCategoria)
    {
        $this->idCategoria = $idCategoria;
    }

    /**
     * @return mixed
     */
    public function getIdUserCreator()
    {
        return $this->idUserCreator;
    }

    /**
     * @param mixed $idUserCreator
     */
    public function setIdUserCreator($idUserCreator)
    {
        $this->idUserCreator = $idUserCreator;
    }

    /**
     * @return mixed
     */
    public function getNumGammers()
    {
        return $this->numGammers;
    }

    /**
     * @param mixed $numGammers
     */
    public function setNumGammers($numGammers)
    {
        $this->numGammers = $numGammers;
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
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
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
            "idCategory" => $this->idCategoria,
            "date" => $this->date,
            "id" => $this->id,
            "numGammers" => $this->numGammers,
            "questions" => $this->questions,
            "idUserCreator" => $this->idUserCreator
        );
    }

}
