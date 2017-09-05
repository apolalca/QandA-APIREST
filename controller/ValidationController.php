<?php

/**
 * Created by PhpStorm.
 * User: apol
 * Date: 8/02/17
 * Time: 11:58
 */

require_once "Controller.php";
require_once __DIR__.'/../model/Validation.php';

class ValidationController extends Controller
{
    public function managePostVerb(Request $request)
    {
        $body = null;

        if (!(isset($request->getBodyParameters()->answers)))
            $body = $body . " No hay preguntas";
        if (!(isset($request->getBodyParameters()->idUser)))
            $body = $body . " No hay idUser";
        if (!(isset($request->getBodyParameters()->idCategory)))
            $body = $body . " No hay idCategory";
        if (!(isset($request->getBodyParameters()->time)))
            $body = $body . " No hay time";

        $objValidation = Validation::createValidationObj($request);

        if ($objValidation != null)
            $answerValidation = ValidationHandlerModel::checkValidation($objValidation);

        if ($objValidation != null && $answerValidation->getPoint() > -1) {
            $code = '200';
            $body = $objValidation;
        } else {
            $code = '400';
            //$body = "No se ha podido validar";
        }

        return new Response($code, null, $body, $request->getAccept());
    }



}