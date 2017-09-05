<?php

/**
 * Created by PhpStorm.
 * User: apol
 * Date: 18/11/16
 * Time: 8:40
 */

class DatabaseModel
{
    private $_connection;
    private static $_instance;

    public static function getInstance() {
        // Si no es instancia de si misma (osea de base de datos) entonces crea una
        if (!(self::$_instance instanceof  self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct()
    {
        // Cargamos el archivo de configuracion
        $config = parse_ini_file('config/config.ini');

        // Recoger los archivos y y sacando las cosas del array
        $this->_connection = new mysqli($config['host'], $config['username'],
            $config['password'], $config['dbname']);

        // Si hay error
        if ($this->_connection->connect_error) {
            trigger_error("Filed to connect to database: " . $this->_connection->connect_error, E_USER_ERROR);
        }
    }

    public function getConnection() {
        return $this->_connection;
    }

    // Magic method clone to prevent duplication of connection
    public function __clone()
    {
        trigger_error("Cloning of " . get_class($this) . " not allowed: ", E_USER_ERROR);
    }

    // Magic method wakeup to prevent duplication through serialization - deserialization
    public function __wakeup()
    {
        trigger_error("Deserialization of " . get_class($this) . " not allowed: ", E_USER_ERROR);
    }

}