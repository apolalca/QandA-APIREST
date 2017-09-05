<?php
/**
 * Created by PhpStorm.
 * User: adripol94
 * Date: 1/31/17
 * Time: 7:49 PM
 */


$user = password_hash('123', PASSWORD_BCRYPT, ["cost" => 12]);
//echo $user;

echo time();