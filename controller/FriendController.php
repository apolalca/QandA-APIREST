<?php

/**
 * Created by PhpStorm.
 * User: adrianpolalcala
 * Date: 5/25/17
 * Time: 7:29 PM
 */

require_once "Controller.php";

class FriendController extends Controller
{
    public function manageGetVerb(Request $r)
    {
        $code = '400';
        $user = $r->getUrlElements()[2];

        $friend = AmigoHandlerModel::getAmigo($user);

        if ($friend != null && count($friend->getAmigo()) > 0) {
            $code = '200';
            foreach ($friend->getAmigo() as $amigoId) {
                $amg[] = UserHandlerModel::getUserById($amigoId);
            }

            if (count($amg) < 2) {
                $amigos = $amg[0];
            } else {
                $amigos = $amg;
            }

            return new Response($code, null, $amigos, $r->getAccept());
        }

        return new Response($code, null, "No friends", $r->getAccept());

    }

    public function managePostVerb(Request $request)
    {
        $amigo = $request->getBodyParameters()->amigo;
        $user = $request->getBodyParameters()->usuario;

        $bool = AmigoHandlerModel::setAmigo($user, $amigo);

        if ($bool) {
            $code = '200';
        } else {
            $code = '400';
        }

        return new Response($code, null, null, $request->getAccept());
    }


}