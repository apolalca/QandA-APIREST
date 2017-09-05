<?php

/**
 * Created by PhpStorm.
 * User: adrianpolalcala
 * Date: 5/25/17
 * Time: 7:30 PM
 */
class Friend implements JsonSerializable
{

    //Un usuario tiene tantos amigos
    private $id;
    private $amigo;
    private $usuario;

    public function __construct($usuario)
    {
        $this->usuario = $usuario;
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
    public function getAmigo()
    {
        return $this->amigo;
    }

    /**
     * @param mixed $amigo
     */
    public function setAmigo($amigo)
    {
        $this->amigo = $amigo;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
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

    }
}