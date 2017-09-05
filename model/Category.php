<?php

/**
 * Created by PhpStorm.
 * User: apol
 * Date: 24/11/16
 * Time: 9:37
 */
class Category implements JsonSerializable {
    private $id;
    private $name;
    private $img;

    /**
     * Categoria constructor.
     * @param $id
     * @param $name
     * @param $id
     */
    public function __construct($id, $name, $img)
    {
        $this->id = $id;
        $this->name = $name;
        $this->img = $img;
    }

    /**
     * @return mixed
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param mixed $img
     */
    public function setImg($img)
    {
        $this->img = $img;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
            'name' => $this->name,
            'image' => $this->img
        );
    }
}