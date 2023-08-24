<?php

namespace Alice\MoviesTutorial\Movie\Application\ListAllMovies;

use Alice\MoviesTutorial\Movie\Domain\MovieRepository;

class Handler
{
    /** @var MovieRepository */
    private $movieRepository;
    
    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function handle() : array
    {
        $movies = $this->movieRepository->FindAll();

        foreach($movies as $movie){
            $moviesData[] = $movie->serialize();
        }

        return $moviesData;
    }
}