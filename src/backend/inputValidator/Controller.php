<?php declare(strict_types=1);

namespace inputValidator;

use Rakit\Validation\Validator;

abstract class Controller
{
    protected static $validator;

    function __construct()
    {
        self::$validator = new Validator();
    }

    public static function Instance()
    {
        $class = get_called_class();
        if ($class::$instance == null)
            $class::$instance = new $class();

        return $class::$instance;
    }
}
