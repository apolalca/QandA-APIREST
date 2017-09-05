<?php

/**
 * Created by PhpStorm.
 * User: apol
 * Date: 24/11/16
 * Time: 10:59
 */


class Request
{
    private $url_elements;
    private $query_string;
    private $verb;
    private $body_parameters;
    private $format;
    private $accept;
    private $content_type;
    private $user;
    private $roll;
    private $expire;

    public function __construct($verb, $url_elements, $query_string, $body, $content_type, $accept, $user, $roll)
    {
        $this->content_type = $content_type;
        $this->url_elements = $url_elements;
        $this->query_string = $query_string;
        $this->verb = $verb;
        $this->user = $user;
        $this->roll = $roll;

        $this->parseBody($body, $content_type);

        switch ($accept) {
            case 'application/json':
            case  '*/*':
            case null:
                $this->accept = 'json';
                break;
            case 'application/xml':
            case 'text/xml':
                $this->accept = 'xml';
                break;
            default:
                $this->accept = 'unsupported';
                break;
        }
    }

    private function parseBody($body, $content_type) {
        $params = array();

        switch ($content_type) {
            case "application/json":
                $this->format = "json";
                $params = json_decode($body);
                break;
            case "application/x-www-form-urlencoded":
                $this->format = "html";
                parse_str($body, $params);
                break;
            // Parse otros formatos

        }

        $this->body_parameters = $params;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getRoll()
    {
        return $this->roll;
    }

    /**
     * @param mixed $roll
     */
    public function setRoll($roll)
    {
        $this->roll = $roll;
    }

    public function getAutorization() {
        return $this->autorization;
    }

    /**
     * @return mixed
     */
    public function getUrlElements()
    {
        return $this->url_elements;
    }

    /**
     * @return mixed
     */
    public function getQueryString()
    {
        return $this->query_string;
    }

    /**
     * @return mixed
     */
    public function getVerb()
    {
        return $this->verb;
    }

    /**
     * @return mixed
     */
    public function getBodyParameters()
    {
        return $this->body_parameters;
    }

    /**
     * @return mixed
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @return string
     */
    public function getAccept()
    {
        return $this->accept;
    }


}