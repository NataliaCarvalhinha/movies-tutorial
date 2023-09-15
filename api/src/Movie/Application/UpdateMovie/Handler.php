<?php

namespace Alice\MoviesTutorial\Movie\Application\UpdateMovie;

use Alice\MoviesTutorial\Movie\Domain\MovieRepository;

class Handler
{
    /** @var MovieRepository */
    private $movieRepository;

    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function handle(Command $command): array
    {
        $movie = $this->movieRepository->findById($command->movieId);
        $movie->changeName($command->name);
        $movie->changeReleaseDate($command->releaseDate);
        $this->movieRepository->update($movie);
        $movieData = $movie->serialize();

        return $movieData;

    }

}