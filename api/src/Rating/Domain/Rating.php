<?php

namespace Alice\MoviesTutorial\Rating\Domain;

use Alice\MoviesTutorial\Shared\Id\MemberId;
use Alice\MoviesTutorial\Shared\Id\MovieId;
use Alice\MoviesTutorial\Shared\Id\RatingId;
use BadFunctionCallException;
use Exception;

class Rating {
    
    /*Parameters */
    /** @var MovieId */
    private $movieId;
    /** @var MemberId */
    private $memberId;
    /** @var RatingId */
    private $id;
    /** @var int */
    private $rating;

    private function __construct(RatingId $id, int $rating, MovieId $movieId, MemberId $memberId){
        
        $this->movieId = $movieId;
        $this->memberId = $memberId;
        $this->id = $id;

        if ($rating < 0){
            throw new Exception("Rating cannot be negative.");
        }
        if ($rating > 5){
            throw new Exception("Rating cannot be higher than 5.");
        }
        
        $this->rating = $rating;

    }

    public static function fromDataBase($row): self
    {
        if ($row == false){
            throw new Exception("Not found.",404);
        }
        return new self(
            RatingId:: fromInteger((int) $row["ID"]),
            $row["RATING"],
            MovieId::fromInteger((int) $row["MOVIE_ID"]) ,
            MemberId:: fromInteger((int) $row["MEMBER_ID"])
        );
    }

    public static function register(RatingId $id, int $rating, MovieId $movieId, MemberId $memberId):self
    {
        return new self ($id,$rating,$movieId,$memberId);
    }

    public function id(): RatingId
    {
        return $this->id;
    }

    public function rating(): int
    {
        return $this->rating;
    }

    public function movieId(): MovieId
    {
        return $this->movieId;
    }

    public function memberId(): MemberId
    {
        return $this->memberId;
    }

    public function changeRating(int $rating): void
    {
        $this->rating = $rating;
    }

    public function serialize(): array
    {
        return [
            "id"=>$this->id->toInteger(),
            "rating"=>$this->rating,
            "movieId"=>$this->movieId->toInteger(),
            "memberId"=>$this->memberId->toInteger(),
        ];
        
    }

}