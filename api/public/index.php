<?php

require __DIR__ . "/../vendor/autoload.php";

use DI\ContainerBuilder;
use GuzzleHttp\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;


ini_set("error_log", "/srv/aliglance/log/api.log");
error_reporting(E_ALL);

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(
    [
        "log_dir" => "/srv/aliglance/log",
        "in_production" => false,
        LoggerInterface::class => function (ContainerInterface $container) {
            $formatter = new LineFormatter();
            $formatter->ignoreEmptyContextAndExtra();

            $handler = new StreamHandler($container->get("log_dir") . "/api.log");
            $handler->setFormatter($formatter);

            $logger = new Logger("movies-tutorial");
            $logger->pushHandler($handler);

            return $logger;
        },
        
        ErrorMiddleware::class => function (ContainerInterface $container) {
            $inProduction = $container->get("in_production");

            $middleware = ErrorMiddleware::create();
            $middleware->setLogger($container->get(LoggerInterface::class));
            $middleware->debugMode($inProduction === false);

            return $middleware;
        },
    ]
);

$container = $containerBuilder->build();

$app = AppFactory::createFromContainer($container);
$app->setBasePath("/movies-tutorial/api");

$app->addMiddleware($container->get(ErrorMiddleware::class));
$app->addMiddleware(CorsMiddleware::create());

$app->get(
    "/soma/{num1}/{num2}",
    function(Request $request, Response $response){
        $num1 = (int)$request->getAttbute("num1");
        $num2 = (int)$request->getAttbute("num2");

        $response->getBody()->write("Soma: " . ($num1+$num2));

        return $response;
    }
);

$app->any(
    "/{routes:.+}", 
    function (Request $request, Response $response) {
        $response ->getBody()->write("Not Found");

        return $response;
});



$app->run();
