<?php
namespace Libraries;

class Router
{
    private static $urlParts = [];
    private static $route    = [];
    private static $fullUrl  = '';

    public static function findRoute($requestUri)
    {
        self::$urlParts = array_values(array_filter(explode('/', $requestUri)));
        self::$fullUrl  = implode('/', self::$urlParts);
        
        $rawMethod  = self::getRawMethod();
        $controller = self::getControllerName();
        $method     = self::getMethodName();

        self::$route = [
            'controllerName' => "{$controller}Controller",
            'actionName'     => "{$method}Action",
            'actionUrl'      => $rawMethod,
            'controllerUrl'  => strtolower($controller),
            'route'          => '/' . strtolower($controller) . '/' . $rawMethod,
            'arguments'      => $_GET
        ];

        return self::$route;
    }

    private static function getRawMethod()
    {
        $rawMethod = count(self::$urlParts) > 1 ? self::$urlParts[1] : (self::$urlParts[0] ?? 'index');
        $rawMethod = explode('?', $rawMethod);
        
        return reset($rawMethod);
    }

    public static function getControllerUrl()
    {
        return self::$route['controllerUrl'];
    }

    public static function getActionUrl()
    {
        return self::$route['actionUrl'];
    }

    public static function getFullUrl()
    {
        return '/' . self::$fullUrl;
    }

    public static function getRoute()
    {
        return self::$route['route'];
    }

    private static function getMethodName()
    {
        $urlPart = array_shift(self::$urlParts);
        $method  = str_replace('-', '',  $urlPart);
        $method  = explode('?', $method);
        $method  = reset($method);

        if (empty($method) === false && ctype_alpha($method) === true) {
            return $method;
        }

        return 'index';
    }

    private static function getControllerName()
    {
        if (count(self::$urlParts) < 2) {
            return 'Index';
        }

        $urlPart    = array_shift(self::$urlParts);
        $controller = self::camelize($urlPart);

        if (empty($controller) === false && ctype_alpha($controller) === true) {
            return $controller;
        }

        return 'Index';
    }

    private static function camelize($string)
    {
        return trim(str_replace('-', '', ucwords($string, '-')));
    }
}