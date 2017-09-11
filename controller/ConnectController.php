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
    
    /**
     * Para que una conexion se de necesitamos tener el usuario en la base de datos
     * de Users y de LogginGoogle.
     * {@inheritDoc}
     * @see Controller::managePostVerb()
     */
    public function managePostVerb(Request $request)
    {
        $userName = $request->getUser();
        $code = '400';
        
        try {
            $connection = UserHandlerModel::getUserByUser($userName);
        } catch(ErrorException $e) {
            $userId = self::setConnection($userName);
            $connection = UserHandlerModel::getUserByUser($userName);
        }
        
        if ($connection != null) {
            $code = '200';
        }

        $response = new Response($code, null, $connection, $request->getAccept());
        return $response;
    }
    
    private function setConnection($userName) {
        
        $user = new User($userName, "deconocido", $userName,
            ConnectHandlerModel::UNKNOWN, $userName.'@gmail.com', 0);
        $roll = new Roll("GoogleUser", "A user from Google");
        
        //Indentificador de un usuario de Google
        $roll->setId(2);
        $user->setRoll($roll);
            
        return UserHandlerModel::setUser($user);
        
    }

}