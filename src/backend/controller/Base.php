<?php

namespace controller;

use Exception;

abstract class Base extends Controller
{
    protected $_der = 'der'; // Производный запрос /controller/action/:id
    protected $model;


    function __construct()
    {
        parent::__construct();
    }

    protected function OnInput()
    {
        parent::__construct();

        $controller = $this->class;
        $action = $this->action;

        if (method_exists($controller, $action) || method_exists($controller, '__call')) {
            return $this->output = $controller::$action();
        } elseif ($restMethod = $this->getRestMethod()) {
            if (method_exists($controller, $restMethod)) {
                return $this->output = $controller::$restMethod($this->last);
            }
        }

        throw new Exception('Invalid method', 405);
    }

    protected function OnOutput()
    {
        header('Content-type: application/json; charset=utf-8');
        http_response_code(self::RESPONSE_CODE);
        $this->successOutput['data'] = $this->output;
        echo json_encode($this->successOutput);
        die;
    }

    private function getRestMethod()
    {
        if (!in_array($this->method, self::AVAILABLE_METHODS)) {
            return false;
        }

        if (!isset($this->action) && (mb_strtolower($this->last . 'controller') === mb_strtolower($this->controller))) {
            return $this->method . 'Action'; // GETAction || POSTAction
        } elseif (!isset($this->action) || (method_exists($this->class, $this->_der . $this->method . 'Action'))) {
            return $this->_der . $this->method . 'Action'; // derGETAction || derPOSTAction
        } else {
            return false;
        }
    }
}
