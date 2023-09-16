<?php

namespace Alice\MoviesTutorial\Rating\Infrastructure\Sql;

use Alice\MoviesTutorial\Rating\Domain\RatingRepository;
use Doctrine\DBAL\Connection;

class SqlRatingRepository implements RatingRepository
{
    /** @var Connection */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
    
}