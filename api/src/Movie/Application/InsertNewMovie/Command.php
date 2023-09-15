<?php

namespace Alice\MoviesTutorial\Movie\Application\InsertNewMovie;

use Alice\MoviesTutorial\Movie\Domain\Movie;
use DateTimeImmutable;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Command
{
    /** @var string */
    public $name;
    /** @var DateTimeImmutable */
    public $releaseDate;

    public function __construct(string $name, ?DateTimeImmutable $releaseDate = null)
    {
        $this->name = $name;
        $this->releaseDate = $releaseDate;
    }

    public static function fromRequest(Request $request): self
    {
        $input = $request->getBody();
        $parsedInput = json_decode($input, true);
        $data = $parsedInput["movie"];

        $releaseDate = $data["releaseDate"] === null
        ? null
        : DateTimeImmutable::createFromFormat("Y-m-d", $data["releaseDate"]);


        return new self(
            $data["name"],
            $releaseDate
        );


    }
}