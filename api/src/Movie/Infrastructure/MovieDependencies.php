<?php

namespace Alice\MoviesTutorial\Movie\Infrastructure;

use Alice\MoviesTutorial\Movie\Domain\MovieRepository;
use Alice\MoviesTutorial\Movie\Infrastructure\Sql\SqlMovieRepository;

use function DI\get;

final class MovieDependencies
{
    public static function definitions(): array
    {
        return[
            MovieRepository::class => get(SqlMovieRepository::class),
        ];
    }
}