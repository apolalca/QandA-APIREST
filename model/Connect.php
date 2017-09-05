<?php

/**
 * Created by PhpStorm.
 * User: adrianpolalcala
 * Date: 5/25/17
 * Time: 11:56 AM
 */
class Connect implements JsonSerializable
{
    private $id;
    private $name;
    private $fecha;

    public function __construct($id, $name, $fecha, $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->fecha = $fecha;
        $this->email = $email;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        $this->name = name;
    }

    public function setName($name) {
        $this->name = name;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
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
            'nameUser' => $this->name,
            'fecha' => $this->fecha
        );
    }
}