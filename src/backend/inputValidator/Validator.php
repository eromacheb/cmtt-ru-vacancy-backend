<?php declare(strict_types=1);

namespace inputValidator;

class Validator
{
    public static function check(array $array, string $class = '', string $function = '')
    {
        $backTrace = debug_backtrace()[1];
        
        if (!$class) {
            $class = explode("\\", $backTrace['class']);
            $class = array_pop($class);
        } 
        if (!$function) {
            $function = $backTrace['function'];
        }
        $class = "\inputValidator\\" . $class;
        $classInstance = $class::instance();

        return $classInstance::{$function}($array);
    }

    public function callMethod($object, $method)
    {
        return $object->$method();
    }
}
