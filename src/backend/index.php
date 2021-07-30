<?php

require(__DIR__ . '/vendor/autoload.php');

$configs = include('config.php');
session_start();

# debug
if (isset($_SERVER['HTTP_DEBUG'])) {
    error_reporting(-1);
    ini_set('display_errors', 'On');
    ini_set('session.use_cookies', false);
}

# Автозагрузка классов
spl_autoload_register('initProject');

function initProject($className)
{
    $dr = $_SERVER['DOCUMENT_ROOT'];
    $ds = DIRECTORY_SEPARATOR;

    $className = ltrim($className, '\\');
    $classDir  = $dr . '';
    $namespace = '';

    if ($lastNsPos = strripos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', $ds, $namespace) . $ds . $className;
    }
    $fileName = $classDir . $ds . $fileName . '.php';
    if (file_exists($fileName)) {
        require $fileName;
    }
}

$_SERVER['DOCUMENT_ROOT'] = __DIR__;

try {
    $routing = new controller\Routing();
} catch (Throwable $e) {
    header('Content-type: application/json; charset=utf-8');
    http_response_code(200);

    if (is_string($e->getMessage()) && is_array(json_decode($e->getMessage(), true))) {
        $messageArray = json_decode($e->getMessage(), true);
        $message = (count($messageArray) === 1) ? $messageArray[0] : $messageArray;
    } else {
        $message = $e->getMessage();
    }

    echo json_encode([
        'message' => $message,
        'code'    => ($e->getCode() !== 0) ? $e->getCode() : 200,
        'data'    => [],
    ]);
    die;
}
