<?php

/**
 * Created by PhpStorm.
 * User: apol
 * Date: 30/11/16
 * Time: 9:48
 */

require_once "Controller.php";

class NotFoundController extends Controller
{
    public function manage(Request $request) {
        $response = new Response('404', null, null, $request->getAccept());
        $response->generate();
    }
}