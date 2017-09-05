<?php

/**
 * Created by PhpStorm.
 * User: adripol94
 * Date: 1/19/17
 * Time: 6:23 PM
 */

class Security
{
    private static $cost = 8;

    public static function encode_Hash($var) {
        $result = null;

        /**
         * Este código evaluará el servidor para determinar el coste permitido.
         * Se establecerá el mayor coste posible sin disminuir demasiando la velocidad
         * del servidor. 8-10 es una buena referencia, y más es bueno si los servidores
         * son suficientemente rápidos. El código que sigue tiene como objetivo un tramo de
         * ≤ 50 milisegundos, que es una buena referencia para sistemas con registros interactivos.
         */
        $timeTarget = 0.07; // 50 milisegundos

        do {
            Security::$cost++;
            $inicio = microtime(true);
            $result = password_hash($var, PASSWORD_BCRYPT, ["cost" => 12]);
            $fin = microtime(true);
        } while (($fin - $inicio) < $timeTarget);
        if ($result === null)
            throw new Exception("Can't do hash", 0);

        return $result;
    }

}