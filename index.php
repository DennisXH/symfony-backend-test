<?php
use Libraries\HttpResponse;

date_default_timezone_set('UTC');

define('APP_DIR', __DIR__ . '/app');

require_once APP_DIR . '/bootstrap.php';

try {
    // The initial status of a request is 200
    $responseStatus = 'success';

    // We find the route (controller and action based on the URL)
    $route = Libraries\Router::findRoute($_SERVER['REQUEST_URI'], $_SERVER['QUERY_STRING'] ?? '');

    // Instantiate the controller based on the route
    $controllerName = 'Controllers\\' . $route['controllerName'];
    $controller     = new $controllerName($route);

    // This method is used to start any dependencies or checks throughout the app
    $controller->startApp();

    // Call the method based on the route and pass any URL arguments
    $apiResult = call_user_func_array([$controller, $route['actionName']], $route['arguments']);

    if (is_array($apiResult) === true && isset($apiResult['http_code']) === true) {
        $responseStatus = $apiResult['http_code'];

        unset($apiResult['http_code']);
    }
    HttpResponse::json($responseStatus, $apiResult);
} catch (Exception $e) {
	echo json_encode([
        'error' => 'Unexpected error.'
    ]);
}