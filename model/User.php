<?php

/**
 * Clase para Usuarios
 */
class User implements JsonSerializable
{
    private $id;
    private $user;
    private $password;
    private $surname;
    private $name;
    private $email;
    private $age;
    private $roll;

    /**
     * User constructor.
     * @param $user
     * @param $password
     * @param $surname
     * @param $name
     * @param $email
     */
    public function __construct($user, $password, $surname, $name, $email, $age)
    {
        $this->setUser($user);
        $this->setPassword($password);
        $this->setSurname($surname);
        $this->setName($name);
        $this->setEmail($email);
        $this->setAge($age);
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
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age)
    {
        if ($age === null)
            throw new ErrorException("Age is null");

        $this->age = $age;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        if($user === null)
            throw new ErrorException("User is null");

        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        if ($password === null)
            throw new ErrorException("Password is null");

        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
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
        if ($name === null)
            throw new ErrorException("Name is null");

        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        if ($email === null)
            throw new ErrorException("$email is null");

        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getRoll()
    {
        return $this->roll;
    }

    /**
     * @param mixed $roll
     */
    public function setRoll(Roll $roll)
    {
        $this->roll = $roll;
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
            "id" => $this->id,
            "email" => $this->email,
            "name" => $this->name,
            "surname" => $this->surname,
            "age" => $this->age,
            "user" => $this->user,
            "password" => $this->password
        );
    }
}
