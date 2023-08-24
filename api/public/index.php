<?php

ini_set("error_log", "/srv/aliglance/log/api.log");
error_reporting(E_ALL);

require __DIR__ . "/../vendor/autoload.php";

use Alice\MoviesTutorial\Movie\Infrastructure\Http\MovieRoutes;
use Alice\MoviesTutorial\Movie\Infrastructure\MovieDependencies;
use DI\ContainerBuilder;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\OCI8\Driver;
use Glance\ErrorMiddleware\ErrorMiddleware;
use GlanceProject\CorsMiddleware\CorsMiddleware;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Dotenv\Dotenv;

use function DI\env;

Dotenv::createMutable(dirname(__DIR__), ".env")->load(); 

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(
    [
        "log_dir" => "/srv/aliglance/log",
        "in_production" => false,
        "db_username" => env("DB_USERNAME"),
        "db_password" => env("DB_PASSWORD"),
        "db_dns" => env("DB_DNS"),

        Connection::class => function (ContainerInterface $container) {
            $connection = new Connection(
                [
                    "drive" => "oci8",
                    "user" => $container->get("db_username"),
                    "password" => $container->get("db_password"),
                    "dbname" => $container->get("db_dns"),
                    "pooled" => true,
                ],
                new Driver()
            );
            $connection->executeQuery("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD'"); 
            return $connection;
        },
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
        
    ],
    /** Context Definitions */
    MovieDependencies::definitions(),

);

$container = $containerBuilder->build();

$app = AppFactory::createFromContainer($container);
$app->setBasePath("/movies-tutorial/api");

$app->addMiddleware($container->get(ErrorMiddleware::class));
$app->addMiddleware(CorsMiddleware::create());

MovieRoutes::addRoutes($app);

$app->get(
    "/teste/{testevar}",
    function (Request $request, Response $response){
        $var = $request->getAttribute("testevar");
        $response->getBody()->write($var);
        return $response;
    }
);

$app->get(
    "/teste",
    function (Request $request, Response $response){
        $var = json_decode($request->getBody(), true)["NAME"];
        $response->getBody()->write(json_encode($var));
        return $response;
    }
);

$app->any(
    "/{routes:.+}", 
    function (Request $request, Response $response) {
        global $container;
        $connection = $container->get(Connection::class);
        $connection->executeQuery("INSERT INTO T_MOVIES(ID,NAME,RELEASE_DATE)
        VALUES(SEQ_T_MOVIES.NEXTVAL, 'A Era do Gelo',TO_DATE('2002-03-21','YYYY-MM-DD'))");
        $rows = $connection->executeQuery("select * from t_movies")->fetchAllAssociative();
        $response->getBody()->write(json_encode($rows));
        return $response;
});



$app->run();
