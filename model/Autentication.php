<?php

/**
 * Created by PhpStorm.
 * User: apol
 * Date: 20/01/17
 * Time: 8:31
 */
//JWT Library
require __DIR__ . '/../vendor/autoload.php';
use \Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\JWT;


class Autentication
{
    private static $value;
    private static $user;
    private static $roll;
    const KEY = "17As#.?98asd.";
    const ALG = 'HS256';

    /**
     * Constructor para Basic
     * @param $value valor Basic
     */
    public static function setValueBasic($value) {
        Autentication::$value = explode(":", JWT::urlsafeB64Decode($value));
    }

    public static function verify() {
        if (!Autentication::vefiry())
            throw new ignatureInvalidException("Pasword verification failed");
    }

    /**
     * Constructor para Bearer Token
     * @param $value valor Bearer
     */
    public static function setValueBearer($value) {
        try {
            Autentication::$value = JWT::decode($value,
                Autentication::KEY, array(Autentication::ALG));

            Autentication::$user = Autentication::$value->claims->user;
            Autentication::$roll = Autentication::$value->claims->roll;

        } catch (SignatureInvalidException $e) {
            throw new SignatureInvalidException("Signature verification failed");
        }
    }

    /**
     * obtendra la informaion en base64 del valor value.
     */
    private static function vefiry() {
        $validate = false;

        $user = UserHandlerModel::getUserByEmail(Autentication::$value->claims->user);

        if (password_verify(Autentication::$value[1], $user->getPassword())) {
            $validate = true;

            //Metemos en value los datos que necesitara Request para toda la api que serán solo usuario y roll
            Autentication::$user = $user->getEmail();
            Autentication::$roll = $user->getRoll()->getName();
        }

        return $validate;
    }

    /**
     * Array de valores necesarios para moverse sobre la api.
     * Deberia devolver un array con valores, en la posicion 0 se encontrará el nombre de usuario o email
     * y en la posicion 1 se encontrara su roll.
     * @return mixed
     */
    public static function getValue() {
        return Autentication::$value;
    }

    public static function getClaims() {
        Autentication::$value->claims;
    }

    public static function getUser() {
        return Autentication::$user;
    }

    public static function getRoll() {
        return Autentication::$roll;
    }

    public static function setUser($user) {
        Autentication::$user = $user;
    }

    public static function setRoll($roll) {
        Autentication::$roll = $roll;
    }

    public static function setUserFromValue() {
        Autentication::$user = Autentication::$value[0];
    }

    //TODO esto deberia de ir en Response pero aqui ya aprobecho los datos...
    public static function encodeToken() {
        $now_seconds = time();

            $payload = array(
                "iat" => $now_seconds,
                "jti" => base64_encode(password_hash($now_seconds, PASSWORD_BCRYPT)),
                "claims" => array(
                    "user" => Autentication::$user,
                    "roll" => Autentication::$roll
                )
            );
            $token = JWT::encode($payload, Autentication::KEY, Autentication::ALG);
        return $token;
    }

}