<?php

namespace Alice\MoviesTutorial\Movie\Domain;

use Alice\MoviesTutorial\Shared\Id\MovieId;

interface MovieRepository
{
    /** @return Movie[] */
    public function findAll(): array;
    public function findById(MovieId $movieId): Movie;

}