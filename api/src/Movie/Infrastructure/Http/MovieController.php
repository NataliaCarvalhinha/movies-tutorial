<?php

namespace Alice\MoviesTutorial\Movie\Infrastructure\Http;

use Alice\MoviesTutorial\Movie\Application\ListAllMovies\Handler as ListAllMoviesHandler;
use Alice\MoviesTutorial\Movie\Application\FindMovieById\Handler as FindMovieByIdHandler;
use Alice\MoviesTutorial\Movie\Application\FindMovieById\Command as FindMovieByIdCommand;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class MovieController
{
    /** @var ListAllMoviesHandler */
    private $listAllMoviesHandler;
    /** @var FindMovieByIdHandler */
    private $findMovieByIdHandler;


    public function __construct(
        ListAllMoviesHandler $listAllMoviesHandler,
        FindMovieByIdHandler $findMovieByIdHandler
    ){
        $this->listAllMoviesHandler = $listAllMoviesHandler;
        $this->findMovieByIdHandler = $findMovieByIdHandler;
    }

    public function listAll(Request $request, Response $response): Response
    {
        $movies = $this->listAllMoviesHandler->handle();

        $response->getBody()->write(json_encode($movies));

        return $response->withAddedHeader("Content-Type","application/json");

    }
    
    public function findById(Request $request, Response $response): Response
    {
        $movie = $this->findMovieByIdHandler->handle(FindMovieByIdCommand::fromRequest($request));

        $response->getBody()->write(json_encode($movie));

        return $response->withAddedHeader("Content-Type","application/json");

    }

}