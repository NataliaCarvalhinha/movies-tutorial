<?php

namespace Alice\MoviesTutorial\Movie\Application\DeleteMovie;

use Alice\MoviesTutorial\Shared\Id\MovieId;
use Psr\Http\Message\ServerRequestInterface as Request;

class Command
{
    /** @var MovieId */
    public $movieId;

    public function __construct(MovieId $movieId)
    {
        $this->movieId = $movieId;
    }

    public static function fromRequest(Request $request): self
    {
        $id = $request->getAttribute("movieId");
        return new self(MovieId::fromInteger($id));
    }

}