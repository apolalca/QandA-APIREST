<?php

/**
 * Created by PhpStorm.
 * User: adrianpolalcala
 * Date: 5/25/17
 * Time: 10:23 AM
 */

require_once "Controller.php";

class ConnectController extends Controller
{
    public function managePostVerb(Request $request)
    {
        $userName = $request->getUser();
        $code = '400';

        $connection = ConnectHandlerModel::getConnection($userName);

        if ($connection != null) {
            $code = '200';
        }

        $response = new Response($code, null, $connection, $request->getAccept());
        return $response;
    }


}