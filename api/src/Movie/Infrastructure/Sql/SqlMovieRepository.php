<?php

namespace Alice\MoviesTutorial\Movie\Infrastructure\Sql;

use Alice\MoviesTutorial\Movie\Domain\Movie;
use Alice\MoviesTutorial\Movie\Domain\MovieRepository;
use Alice\MoviesTutorial\Shared\Id\MovieId;
use Doctrine\DBAL\Connection;

class SqlMovieRepository implements MovieRepository
{
    /** @var Connection */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;   
    }

    public function findAll(): array
    {
        $query =
        "SELECT ID, NAME, RELEASE_DATE FROM T_MOVIES";

        $rows = $this->connection->executeQuery($query)->fetchAllAssociative();

        $movies = [];

        foreach($rows as $row){
            $movies[] = Movie::fromDataBase($row);
        }
        return $movies;
    }

    public function findById(MovieId $movieId): Movie
    {
        $query =
        "SELECT
            ID, NAME, RELEASE_DATE
        FROM T_MOVIES
        WHERE ID = :id";

        $bind = [
            "id" => $movieId->toInteger()
        ];

        $row = $this->connection->executeQuery($query,$bind)->fetchAssociative();

        return Movie::fromDataBase($row);
    }
}