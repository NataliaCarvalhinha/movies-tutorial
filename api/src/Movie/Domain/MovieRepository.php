<?php

namespace Alice\MoviesTutorial\Movie\Domain;

use Alice\MoviesTutorial\Shared\Id\MovieId;
use DateTimeImmutable;


interface MovieRepository
{
    /** @return Movie[] */
    public function findAll(): array;
    public function findById(MovieId $movieId): Movie;
    public function insert(Movie $movie): void;
    public function nextId(): MovieId;
    public function delete(MovieId $movieId): void;
    public function update(Movie $movie): void;

}