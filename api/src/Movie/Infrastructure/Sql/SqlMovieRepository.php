<?php

namespace Alice\MoviesTutorial\Movie\Infrastructure\Sql;

use Alice\MoviesTutorial\Movie\Domain\Movie;
use Alice\MoviesTutorial\Movie\Domain\MovieRepository;
use Alice\MoviesTutorial\Shared\Id\MovieId;
use DateTimeImmutable;
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
        "SELECT 
            ID, NAME, RELEASE_DATE 
        FROM T_MOVIES";

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

    public function insert(Movie $movie): void
    {
        $query =
        "INSERT INTO T_MOVIES (ID, NAME, RELEASE_DATE)
        VALUES (:id, :name, :releaseDate)";

        $bind = $movie->serialize();
        
        $this->connection->executeQuery($query,$bind);

    }

    public function nextId(): MovieId
    {
        $query =
        "SELECT SEQ_T_MOVIES.NEXTVAL
        FROM DUAL";

        $row = $this->connection->executeQuery($query)->fetchOne();

        return MovieId::fromInteger($row);
    }

    public function delete(MovieId $movieId): void
    {
        $query =
        "DELETE FROM T_MOVIES
        WHERE ID = :id";

        $bind = [
            "id" => $movieId->toInteger()
        ];

        $this->connection->executeQuery($query,$bind)->fetchAssociative();
    }

    public function update(Movie $movie): void
    {
        $query =
        "UPDATE T_MOVIES
        SET NAME = :name, RELEASE_DATE = :releaseDate
        WHERE ID = :id";

        $bind = $movie->serialize();

        $this->connection->executeQuery($query, $bind);
    }
}