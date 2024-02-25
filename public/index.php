<?php

declare(strict_types=1);

use Easy\Wallet\Controllers\NotFountController;
use Easy\Wallet\Services\UserService;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Controllers/NotFountController.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

/** @var \Psr\Container\ContainerInterface $diContainer */
$diContainer = require_once __DIR__ . '/../config/dependencyInjection.php';

$routes = require_once __DIR__ . "/../config/routes.php";
$pathInfo = $_SERVER['REQUEST_URI'] ?? '/';
$httpMethod = $_SERVER['REQUEST_METHOD'];

// Verify auth here

if (preg_match('/\d+/', $pathInfo)) {
    $pathInfo = preg_replace('/\d+/', '{id}', $pathInfo);
}

$key = "$httpMethod|$pathInfo";

if (array_key_exists($key, $routes)) {
    $controllerClass = $routes["$httpMethod|$pathInfo"];

    $controller =  $diContainer->get($controllerClass);
} else {
    $controller = new NotFountController();
}

$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

$creator = new \Nyholm\Psr7Server\ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);

$serverRequest = $creator->fromGlobals();

/** @var \psr\Http\Server\RequestHandlerInterface $controller */
$response = $controller->handle($serverRequest);


http_response_code($response->getStatusCode());
foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}

echo $response->getBody();