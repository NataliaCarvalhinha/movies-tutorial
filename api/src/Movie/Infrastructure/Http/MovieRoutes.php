<?php

namespace Alice\MoviesTutorial\Movie\Infrastructure\Http;
use Slim\App;

class MovieRoutes
{
    public static function addRoutes(App $app): void
    {
        $app->get("/movies",[MovieController::class, "listAll"]);
        $app->get("/movies/{movieId}",[MovieController::class, "findById"]);
    }
}