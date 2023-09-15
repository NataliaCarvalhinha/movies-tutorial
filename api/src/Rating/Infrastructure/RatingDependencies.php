<?php

namespace Alice\MoviesTutorial\Rating\Infrastructure;

use Alice\MoviesTutorial\Rating\Domain\RatingRepository;
use Alice\MoviesTutorial\Rating\Infrastructure\Sql\SqlRatingRepository;

use function DI\get;

final class RatingDependencies
{
    public static function definitions(): array
    {
        return[
            RatingRepository::class => get(SqlRatingRepository::class),
        ];
    }
}