<?php

namespace controller;

use \inputValidator\Validator;
use \model\DatabaseInstance;

abstract class Controller
{
    protected const AVAILABLE_METHODS = ['GET', 'POST'];
    protected const RESPONSE_CODE = 200;

    public $className;

    protected $config;
    protected $model;
    protected $inputValidator;

    protected $class;
    protected $controller;
    protected $action;
    protected $arguments;
    protected $last;

    protected $requestHeaders;
    protected $method;
    protected $input;

    protected $successOutput = [
        'message' => 'OK',
        'code'    => self::RESPONSE_CODE,
        'data'    => []
    ];


    function __construct()
    {
        $this->config = include($_SERVER['DOCUMENT_ROOT'] . '/config.php');

        $this->model = DatabaseInstance::Instance($this->config);
        $this->inputValidator = new Validator();

        $this->requestHeaders = getallheaders();
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->input = $_REQUEST;
    }

    public function request($options)
    {
        $this->class = $options['class'];
        $this->controller = $options['controller'];
        $this->action = !empty($options['action']) && !is_numeric($options['action']) ? $options['action'] . 'Action' : null;
        $this->arguments = !empty(urldecode($options['arguments'])) ? urldecode($options['arguments']) : null;
        $this->last = is_numeric(urldecode($options['last'])) ? (int) urldecode($options['last']) : urldecode($options['last']);

        $this->OnInput();
        $this->OnOutput();
    }

    protected function OnInput()
    {
    }

    protected function OnOutput()
    {
    }

    protected function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    protected function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

}
