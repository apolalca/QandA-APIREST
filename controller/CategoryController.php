<?php

/**
 * Created by PhpStorm.
 * User: adripol94
 * Date: 1/28/17
 * Time: 2:26 PM
 */

require_once "Controller.php";

class CategoryController extends Controller
{
    public function manageGetVerb(Request $r)
    {
        $listCategory = null;
        $id = null;
        $response = null;
        $code = null;

        if (isset($r->getUrlElements()[2]))
            $id = $r->getUrlElements()[2];

        $listCategory = CategoryHandlerModel::getCategory($id);

        if ($listCategory != null) {
            $code = '200';
        } else {
            if (Validator::isValid($id)) {
                $code = '404';
            } else {
                $code = '400';
            }
        }

        $response = new Response($code, null, $listCategory, $r->getAccept());
        return $response;
    }

    public function managePostVerb(Request $request)
    {
        $code = '400';
        $id = $request->getUrlElements()[2];
        $nameCategory = $request->getBodyParameters()->name;
        $response = null;

        if ($id != null && $nameCategory != null) {
            $code = CategoryHandlerModel::postCategory(new Category($id, $nameCategory));
        }

        $response = new Response($code, null, null, $request->getAccept());
        return $response;
    }

    public function manageDeleteVerb(Request $request)
    {
        $code = '400';
        $id = $request->getUrlElements()[2];
        $response = null;

        if ($id != null) {
            $code = CategoryHandlerModel::delCategory($id);
        }

        $response = new Response($code, null, null, $request->getAccept());
        return $response;
    }


}