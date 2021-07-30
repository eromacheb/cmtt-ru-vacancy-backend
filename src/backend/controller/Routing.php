<?php

namespace controller;

use Exception;

class Routing
{
    private $_controller;
    private $_action;
    private $_arguments;
    private $_last;
    private $_class = "\controller\\";


    function __construct()
    {
        # Разделяем запрос на путь и аргументы
        $arguments = explode('?', $_SERVER['REQUEST_URI']);
        $this->_arguments = isset($arguments[1]) ? $arguments[1] : null;

        # Разделяем url на аргументы
        $route = explode('/', $arguments[0]);

        # Удаление первого элемента, если он пуст
        if (isset($route[0]) && empty($route[0])) {
            unset($route[0]);
        }

        # Удаление последнего элемента, если он пуст
        if (isset($route[count($route)]) && empty($route[count($route)]) && $route[count($route)] !== "0") {
            unset($route[count($route)]);
        }

        # Последний аргумент
        $this->_last = $route[count($route)] ?? null;

        $indexRoute = key($route);
        $this->_controller = $route[$indexRoute++] ?? null;
        $this->_action = $route[$indexRoute] ?? null;

        $this->getRoute();
    }

    private function getRoute()
    {
        if (!$this->_controller) { // контроллер не указан
            $this->_class .= "IndexController";
        } else {
            if (class_exists($this->_class . ucwords($this->_controller  . "Controller"))) {  // проверка существования контроллера
                $this->_controller = ucwords($this->_controller) . "Controller";
                $this->_class .= $this->_controller;
            } else {
                throw new Exception("Class {$this->_class}{$this->_controller} not found");
            }
        }

        $options = [];
        $options['class'] = $this->_class;
        $options['controller'] = $this->_controller;
        $options['action'] = $this->_action;
        $options['arguments'] = $this->_arguments;
        $options['last'] = $this->_last;

        $controller = new $this->_class;
        $controller->request($options);
    }
}
