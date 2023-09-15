<?php

namespace Alice\MoviesTutorial\Movie\Infrastructure\Http;

use Alice\MoviesTutorial\Movie\Application\ListAllMovies\Handler as ListAllMoviesHandler;
use Alice\MoviesTutorial\Movie\Application\FindMovieById\Handler as FindMovieByIdHandler;
use Alice\MoviesTutorial\Movie\Application\FindMovieById\Command as FindMovieByIdCommand;
use Alice\MoviesTutorial\Movie\Application\InsertNewMovie\Handler as InsertNewMovieHandler;
use Alice\MoviesTutorial\Movie\Application\InsertNewMovie\Command as InsertNewMovieCommand;
use Alice\MoviesTutorial\Movie\Application\DeleteMovie\Handler as DeleteMovieHandler;
use Alice\MoviesTutorial\Movie\Application\DeleteMovie\Command as DeleteMovieCommand;
use Alice\MoviesTutorial\Movie\Application\UpdateMovie\Handler as UpdateMovieHandler;
use Alice\MoviesTutorial\Movie\Application\UpdateMovie\Command as UpdateMovieCommand;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class MovieController
{
    /** @var ListAllMoviesHandler */
    private $listAllMoviesHandler;
    /** @var FindMovieByIdHandler */
    private $findMovieByIdHandler;
    /** @var InsertNewMovieHandler */
    private $insertNewMovieHandler;
    /** @var DeleteMovieHandler */
    private $deleteMovieHandler;
    /** @var UpdateMovieHandler */
    private $updateMovieHandler;


    public function __construct(
        ListAllMoviesHandler $listAllMoviesHandler,
        FindMovieByIdHandler $findMovieByIdHandler,
        InsertNewMovieHandler $insertNewMovieHandler,
        DeleteMovieHandler $deleteMovieHandler,
        UpdateMovieHandler $updateMovieHandler
    ){
        $this->listAllMoviesHandler = $listAllMoviesHandler;
        $this->findMovieByIdHandler = $findMovieByIdHandler;
        $this->insertNewMovieHandler = $insertNewMovieHandler;
        $this->deleteMovieHandler = $deleteMovieHandler;
        $this->updateMovieHandler = $updateMovieHandler;

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

    public function insertNewMovie(Request $request, Response $response): Response
    {
        $insertCommand = InsertNewMovieCommand::fromRequest($request);
        $movie = $this->insertNewMovieHandler->handle($insertCommand);

        $response->getBody()->write(json_encode($movie));

        return $response->withAddedHeader("Content-Type","application/json");

    }

    public function deleteMovie(Request $request, Response $response): Response
    {
        $insertCommand = DeleteMovieCommand::fromRequest($request);
        try{
            $this->deleteMovieHandler->handle($insertCommand);

        }catch(Exception $error){
            return $response->withStatus(404, $error->getMessage());
        }
        
        return $response->withStatus(204);
    }

    public function updateMovie(Request $request, Response $response): Response
    {
        $insertCommand = UpdateMovieCommand::fromRequest($request);
        try{
            $this->updateMovieHandler->handle($insertCommand);
        }catch(EXception $error){
            return $response->withStatus(404, $error->getMessage());
        }

        return $response->withStatus(204);
    }
}