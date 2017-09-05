<?php

/**
 * Created by PhpStorm.
 * User: adripol94
 * Date: 2/11/17
 * Time: 5:21 PM
 */

require_once "Controller.php";

class GameController extends Controller
{
    public function managePostVerb(Request $request)
    {
        try {

            $game = GameHandlerModel::postGame($request);

            if ($game != null) {
                $code = '200';
                $body = $game;
            } else {
                $code = '400';
                $body = "Ha ocurrido un error inesperado";
            }

        } catch (Exception $e) {
            $code = '400';
            $body = $e->getMessage();
        }

        $res = new Response($code, null, $body, $request->getAccept());
        return $res;
    }

}