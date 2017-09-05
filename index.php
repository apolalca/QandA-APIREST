<?php
/**
 * Created by PhpStorm.
 * User: apol
 * Date: 18/11/16
 * Time: 8:32
 */

require_once "Request.php";
require_once "Response.php";
require_once "model/Autentication.php";

require __DIR__ . '/vendor/autoload.php';
use \Firebase\JWT\SignatureInvalidException;

const KEY_TOKEN = '123';

//Autoload rules
spl_autoload_register('apiAutoload');
/**
 * CUIDADO!!: Aqui busca automaticamente las clases la carpeta Controller debe ser exacta!
 * @param $classname
 * @return bool
 */
function apiAutoload($classname)
{
    $res = false;

    //If the class name ends in "Controller", then try to locate the class in the controller directory to include it (require_once)
    if (preg_match('/[a-zA-Z]+Controller$/', $classname)) {
        if (file_exists(__DIR__ . '/controller/' . $classname . '.php')) {
//            echo "cargamos clase: " . __DIR__ . '/controller/' . $classname . '.php';
            require_once __DIR__ . '/controller/' . $classname . '.php';
            $res = true;
        }
    } elseif (preg_match('/[a-zA-Z]+Model$/', $classname)) {
        if (file_exists(__DIR__ . '/model/' . $classname . '.php')) {
//            echo "<br/>cargamos clase: " . __DIR__ . '/model/' . $classname . '.php';
            require_once __DIR__ . '/model/' . $classname . '.php';
//            echo "clase cargada.......................";
            $res = true;
        }
    } elseif (preg_match('/[a-zA-Z]+Policies$/', $classname)) {
        if (file_exists(__DIR__ . '/policies/' . $classname . '.php')) {
//            echo "<br/>cargamos clase: " . __DIR__ . '/model/' . $classname . '.php';

            require_once __DIR__ . '/policies/' . $classname . '.php';
//            echo "clase cargada.......................";
            $res = true;
        }
    }
    //Instead of having Views, like in a Model-View-Controller project,
    //we will have a Response class. So we don't need the following.
    //Although we could have different classes to generate the output,
    //for example: JsonView, XmlView, HtmlView... I think in our case
    //it will be better to have asingle class to generate the output (Response class)
    //elseif (preg_match('/[a-zA-Z]+View$/', $classname)) {
    //    require_once __DIR__ . '/views/' . $classname . '.php';
    //    $res = true;
    //}
    return $res;
}


function isPathRegister($verb, $path_info) {
    if ($verb === "POST" && strtolower($path_info) === "/connect") {
        return true;
    } else {
        return false;
    }
}


//Let's retrieve all the information from the request
$verb = $_SERVER['REQUEST_METHOD'];
//IMPORTANT: WITH CGI OR FASTCGI, PATH_INFO WILL NOT BE AVAILABLE!!!
//SO WE NEED FPM OR PHP AS APACHE MODULE (UNSECURE, DEPRECATED) INSTEAD OF CGI OR FASTCGI
$path_info = !empty($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : (!empty($_SERVER['ORIG_PATH_INFO']) ? $_SERVER['ORIG_PATH_INFO'] : '');
$url_elements = explode('/', $path_info);
//$url_elements = explode('/', $_SERVER['PATH_INFO']);
$query_string = null;
if (isset($_SERVER['QUERY_STRING'])) {
    parse_str($_SERVER['QUERY_STRING'], $query_string);
}
$body = file_get_contents("php://input");
if ($body === false) {
    $body = null;
}
$content_type = null;
if (isset($_SERVER['CONTENT_TYPE'])) {
    $content_type = $_SERVER['CONTENT_TYPE'];
}
$accept = null;
if (isset($_SERVER['HTTP_ACCEPT'])) {
    $accept = $_SERVER['HTTP_ACCEPT'];
}
$error = false;

$autorization = null;
if (isset($_SERVER['HTTP_WWW_AUTHENTICATE'])) {
    $autorization = $_SERVER['HTTP_WWW_AUTHENTICATE'];
    $autorization = explode(" ", $autorization);
} else {
    if (isset($_SERVER['Authorization'])) {
        $autorization = $_SERVER['Authorization'];
        $autorization = explode(" ", $autorization);
    } else {
        $error = true;
    }
}



if (!$error) {
    try {
        if ($autorization[0] === "Basic") {
            Autentication::setValueBasic($autorization[1]);
            $path = $path_info;
            if (strtolower($path) != "/connect") {
                Autentication::verify();
            } else {
                Autentication::setUserFromValue();
                Autentication::setRoll('GoogleUser');
            }
        } elseif ($autorization[0] == "Bearer") {
                Autentication::setValueBearer($autorization[1]);
            } else {
                $error = true;
            }
    } catch (SignatureInvalidException $e) {
        $error = true;
    } catch (ErrorException $e) {
        $error = true;
    }
}

$req = new Request($verb, $url_elements, $query_string, $body, $content_type, $accept, Autentication::getUser(), Autentication::getRoll());


if (!$error ) {
// route the request to the right place
    $controller_name = ucfirst($url_elements[1]) . 'Controller';
    $policies_name = ucfirst($url_elements[1]) . 'Policies';

    if (class_exists($controller_name)) {
        $controller = new $controller_name();
        $action_name = 'manage' . ucfirst(strtolower($verb)) . 'Verb';

        if (class_exists($policies_name)) {
            //Si la politica existe comprobamos si el usuario tiene permiso para acceder a ellas
            $polices = new $policies_name();

            if ($polices->hasUserPermission()) {
                $controller->$action_name($req);

                $response->setHeader(header('WWW-Authenticate: Bearer ' . Autentication::encodeToken()));
                $response->generate();

            } else {
                $controller = new NotAutorizationController();
                $controller->manage($req);
            }

        } else {
            //Sino existe una pilotica se entrara directamente a la accion
            $response = $controller->$action_name($req);

            // Si es nulo es que no se ha encontrado el metodo HTTP
            if ($response != null) {
                $response->setHeader(header('WWW-Authenticate: Bearer ' . Autentication::encodeToken()));
                $response->generate();
            }
        }
        //$result = $controller->$action_name($req);
        //print_r($result);
    } //If class does not exist, we will send the request to NotFoundController
    else {
        $controller = new NotFoundController();
        $controller->manage($req); //We don't care about the HTTP verb
    }
} else {
    $controller = new NotAutorizationController();
    $controller->manage($req);
}

//DEBUG / TESTING:
//echo "<br/>URL_ELEMENTS:" ;
//print_r ($req->getUrlElements());
//echo "<br/>VERB:" ;
//print_r ($req->getVerb());
//echo "<br/>QUERY_STRING:" ;
//print_r ($req->getQueryString());
//echo "<br/>BODY_PARAMS:" ;
//print_r ($req->getBodyParameters());

