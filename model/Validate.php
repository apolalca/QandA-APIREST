<?php

/**
 * Created by PhpStorm.
 * User: adripol94
 * Date: 1/27/17
 * Time: 6:04 PM
 */
class Validate
{
    public static function isValid($id) {
        $res = false;

        //FIXME Con el modulo de getAnswerByQuestion falla!

        if(is_numeric($id)) {
            $res = true;
        }
        return $res;
    }
}