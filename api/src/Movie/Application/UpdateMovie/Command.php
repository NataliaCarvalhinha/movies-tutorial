<?php

namespace Alice\MoviesTutorial\Movie\Application\UpdateMovie;

use Alice\MoviesTutorial\Shared\Id\MovieId;
use DateTimeImmutable;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Command
{
    /** @var MovieId */
    public $movieId;
    /** @var string */
    public $name;
    /** @var DateTimeImmutable */
    public $releaseDate;

    public function __construct(MovieId $movieId, string $name, ?DateTimeImmutable $releaseDate = null)
    {
        $this->movieId = $movieId;
        $this->name = $name;
        $this->releaseDate = $releaseDate;
    }

    public static function fromRequest(Request $request): self
    {
        $id = $request->getAttribute("movieId");
        $input = $request->getBody();
        $parsedInput = json_decode($input, true);

        $releaseDate = $parsedInput["releaseDate"] === null
        ? null
        : DateTimeImmutable::createFromFormat("Y-m-d", $parsedInput["releaseDate"]);

        return new self(
            MovieId::fromInteger($id), 
            $parsedInput["name"], 
            $releaseDate);
    }
}