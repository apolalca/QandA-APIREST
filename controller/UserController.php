<?php

/**
 * Created by PhpStorm.
 * User: adripol94
 * Date: 1/12/17
 * Time: 9:20 PM
 */

require_once "Controller.php";

class UserController extends Controller
{
    public function managePostVerb(Request $request)
    {
        $code = null;
        $id = null;

        try {
        $user = new User($request->getBodyParameters()->user,
            $request->getBodyParameters()->password,
            $request->getBodyParameters()->username,
            $request->getBodyParameters()->name,
            $request->getBodyParameters()->email,
            $request->getBodyParameters()->age);

        $code = UserHandlerModel::setUser($user);
        } catch (ErrorException $e) {}

        if ($code === null) {
            $code = '400';
        }

        $res = new Response($code, null, null, $request->getAccept());
        return $res;
    }

    public function manageGetVerb(Request $r)
    {
        $res = null;
        $code = null;
        $id = null;

        try {

            if ($r->getQueryString() != null) {
                $res = UserHandlerModel::getUserByEmail($r->getQueryString()['email']);

            } else {

                if (isset($r->getUrlElements()[2]))
                    $id = $r->getUrlElements()[2];

                $res = UserHandlerModel::getUserById($id);
            }

            if ($res != null) {
                $code = '200';
            } else {
                if (Validator::isValid($id)) {
                    $code = '404';
                } else {
                    $code = '400';
                }
            }
        } catch (Exception $e){
            $res = $e->getMessage();
            $code = '400';
        }

        $response = new Response($code, null, $res, $r->getAccept());
        return $response;
    }
}