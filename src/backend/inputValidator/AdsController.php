<?php declare(strict_types=1);

namespace inputValidator;

use Exception;

class AdsController extends Controller
{
    protected static $instance;

    protected static $requiredId = [
        'id' => 'required|integer',
    ];

    protected static $requiredFields = [
        'text'   => 'required|regex:/[\w+ ]/',
        'price'  => 'required|integer',
        'limit'  => 'required|integer',
        'banner' => 'required|url'
    ];

    protected static $updateFields = [
        'text'   => 'regex:/[\w+ ]/|default:',
        'price'  => 'integer|nullable',
        'limit'  => 'integer|nullable',
        'banner' => 'url|default:'
    ];

    protected static $errors = [
        'text'   => 'Invalid text',
        'price'  => 'Invalid price',
        'limit'  => 'Invalid limit',
        'banner' => 'Invalid banner link'
    ];


    public static function create(array $arrayToValidate)
    {
        $validation = self::$validator->validate($arrayToValidate, self::$requiredFields, self::$errors);
        if ($validation->fails()) {
            $errors = $validation->errors();
            throw new Exception(json_encode($errors->all()), 400);
        }

        return $validation;
    }

    public static function update(array $arrayToValidate)
    {
        $validation = self::$validator->validate($arrayToValidate, (self::$requiredId + self::$updateFields), self::$errors);
        if ($validation->fails()) {
            $errors = $validation->errors();
            throw new Exception(json_encode($errors->all()), 400);
        }

        return $validation;
    }

    public static function updateLimit(array $arrayToValidate)
    {
        $validation = self::$validator->validate($arrayToValidate, self::$requiredId, self::$errors);
        if ($validation->fails()) {
            $errors = $validation->errors();
            throw new Exception(json_encode($errors->all()), 400);
        }

        return $validation;
    }

    public static function getById(array $arrayToValidate)
    {
        $validation = self::$validator->validate($arrayToValidate, self::$requiredId, self::$errors);
        if ($validation->fails()) {
            $errors = $validation->errors();
            throw new Exception(json_encode($errors->all()), 400);
        }

        return $validation;
    }

}
