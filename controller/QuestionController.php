<?php

/**
 * Created by PhpStorm.
 * User: adripol94
 * Date: 1/28/17
 * Time: 5:45 PM
 */

require_once "Controller.php";

class QuestionController extends Controller
{

    public function manageGetVerb(Request $r)
    {
        $listQuestion = null;
        $code = null;
        $id = null;
        $response = null;

        if ($r->getQueryString() != null) {
            $listQuestion = QuestionHandlerModel::getQuestionByCategory($r->getQueryString()['category']);
        } else {
            if (isset($r->getUrlElements()[2])) {
                $id = $r->getUrlElements()[2];
            }

            $listQuestion = QuestionHandlerModel::getQuestion($id);
        }

        if ($listQuestion != null) {
            $code = '200';
        } else {
            if (Validator::isValid($id)) {
                $code = '404';
            } else {
                $code = '400';
            }
        }


         return new Response($code, null, $listQuestion, $r->getAccept());

    }

    public function managePostVerb(Request $request)
    {
       $question = null;
       $code = null;
       $body = null;

       $question = QuestionHandlerModel::postQuestion($request);

       if ($question != null) {
           $body = $question;
           $code = 200;
       }  else {
           $body = "Error..";
           $code = 400;
       }

       $response = new Response($code, null, $body, $request->getAccept());
       return $response;
    }


}