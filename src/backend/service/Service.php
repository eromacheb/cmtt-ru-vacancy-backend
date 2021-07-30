<?php declare(strict_types=1);

namespace service;

use inputValidator\Validator;
use model\DatabaseInstance;

abstract class Service
{
    protected $config;
    protected $inputValidator;
    protected $model;
    

    function __construct()
    {
        $this->config = include($_SERVER['DOCUMENT_ROOT'] . '/config.php');
        $this->inputValidator = new Validator();
        $this->model = DatabaseInstance::Instance($this->config);
    }

}
