<?php

namespace Alice\MoviesTutorial\Movie\Application\InsertNewMovie;

use Alice\MoviesTutorial\Movie\Domain\Movie;
use Alice\MoviesTutorial\Movie\Domain\MovieRepository;
use Alice\MoviesTutorial\Shared\Id\IntegerId;
use Alice\MoviesTutorial\Shared\Id\MovieId;
use Doctrine\DBAL\Types\IntegerType;

class Handler
{
    /** @var MovieRepository */
    private $movieRepository;
    
    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function handle(Command $command): int
    {
        $nextId = $this->movieRepository->nextId();
        $movie = Movie::register($nextId,$command->name, $command->releaseDate); 
        $this->movieRepository->insert($movie);
        return $movie->id()->toInteger();
    }
}