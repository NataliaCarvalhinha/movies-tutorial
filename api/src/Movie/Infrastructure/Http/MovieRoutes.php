<?php

namespace Alice\MoviesTutorial\Movie\Infrastructure\Http;
use Slim\App;

class MovieRoutes
{
    public static function addRoutes(App $app): void
    {
        $app->get("/movies",[MovieController::class, "listAll"]);
        $app->get("/movies/{movieId}",[MovieController::class, "findById"]);
        $app->post("/movies",[MovieController::class, "insertNewMovie"]);
        $app->delete("/movies/{movieId}",[MovieController::class, "deleteMovie"]);
        $app->put("/movies/{movieId}", [MovieController::class, "updateMovie"]);
    }
}