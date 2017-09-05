<?php

/**
 * Created by PhpStorm.
 * User: adripol94
 * Date: 1/19/17
 * Time: 8:35 PM
 */



class NotAutorizationController
{
    public function manage(Request $request) {

        if (isset($request->getUrlElements()[1]))
            $realm = $request->getUrlElements()[1];
        else
            $realm = "Not founded realm";

        // finded here http://docstore.mik.ua/orelly/webprog/pcook/ch08_10.htm
        $header = header('WWW-Authenticate: Basic realm="' . $realm . '"');
        $response = new Response('401', $header, null, $request->getAccept());
        $response->generate();
    }
}