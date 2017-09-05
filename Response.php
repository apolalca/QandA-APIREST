<?php

/**
 * Created by PhpStorm.
 * User: apol
 * Date: 24/11/16
 * Time: 11:50
 */

use Firebase\JWT\JWT;

class Response
{
    private $code;
    private $headers;
    private $body;
    private $format;

    public function __construct($code = '200', $headers = null, $body = null, $format = 'json')
    {
        $this->code = $code;
        $this->headers = $headers;
        $this->body = $body;
        $this->format = $format;
    }



    /**
     * En caso del formato se generará automaticamente el body del documento.
     * En case de JSON ponremos en el headers el tipo y en el body con json_encode
     * lo codificaremos en json.
     */
    public function generate() {
        switch ($this->format) {
            case 'json':
                if (!empty($this->body)) {
                    $this->headers['Content-Type'] = "application/json";
                    $this->body = json_encode($this->body, JSON_UNESCAPED_UNICODE);
                }
                break;
            case 'xml':
                if (!empty($this->body)) {
                    $this->headers['Content-Type'] = "text/xaml";
                    // ENCODE EN XML
                }
                break;
            case 'usupported':
                // En caso de no ser soportado mandamos un error 406 (No aceptado)
                // y el body lo pondremos nulo.
                if ($this->body != null) {
                    $this->code = '406';
                    $this->body = null;
                }
                break;
        }

        // Establece el codigo de estado
        http_response_code($this->code);
        if (isset($this->headers)) {
            // rellenamos el header
            foreach ($this->headers as $key => $value) {
                header($key . ': ' . $value);
            }
        }

        // Imprimimos el body
        if (!empty($this->body))  {
            echo $this->body;
        }
    }

    // https://www.darklaunch.com/2009/05/23/php-xml-encode-using-domdocument-convert-array-to-xml-json-encode
    // http://stackoverflow.com/questions/7609095/is-there-an-xml-encode-like-json-encode-in-php
    private function xml_encode($mixed, $domElement=null, $DOMDocument=null) {
        if (is_null($DOMDocument)) {
            $DOMDocument =new DOMDocument;
            $DOMDocument->formatOutput = true;
            $this->xml_encode($mixed, $DOMDocument, $DOMDocument);
            echo $DOMDocument->saveXML();
        }
        else {
            if (is_array($mixed)) {
                foreach ($mixed as $index => $mixedElement) {
                    if (is_int($index)) {
                        if ($index === 0) {
                            $node = $domElement;
                        }
                        else {
                            $node = $DOMDocument->createElement($domElement->tagName);
                            $domElement->parentNode->appendChild($node);
                        }
                    }
                    else {
                        $plural = $DOMDocument->createElement($index);
                        $domElement->appendChild($plural);
                        $node = $plural;
                        if (!(rtrim($index, 's') === $index)) {
                            $singular = $DOMDocument->createElement(rtrim($index, 's'));
                            $plural->appendChild($singular);
                            $node = $singular;
                        }
                    }

                    $this->xml_encode($mixedElement, $node, $DOMDocument);
                }
            }
            else {
                $domElement->appendChild($DOMDocument->createTextNode($mixed));
            }
        }
    }

    public function setHeader($header) {
        $this->headers = $header;
    }
}