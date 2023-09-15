<?php

namespace Alice\MoviesTutorial\Movie\Application\DeleteMovie;

use Alice\MoviesTutorial\Movie\Domain\MovieRepository;

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
        $movie = $this->movieRepository->findById($command->movieId);
        $id = $movie->id();
        $this->movieRepository->delete($id);
        return $id->toInteger();
    }
}