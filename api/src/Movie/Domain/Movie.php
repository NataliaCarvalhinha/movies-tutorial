<?php

namespace Alice\MoviesTutorial\Movie\Domain;

use Alice\MoviesTutorial\Shared\Id\MemberId;
use Alice\MoviesTutorial\Shared\Id\MovieId;
use Exception;
use DateTimeImmutable;

class Movie {

 private const MAX_NAME_LENGTH = 32;
 /* Parameters */
 /**  @var MovieId */
 private $id;
 /**  @var string */
 private $name;
 /**  @var ?DateTimeImmutable */
 private $releaseDate;

 /** Methods */

 private function __construct(MovieId $id, string $name, ?DateTimeImmutable $releaseDate = null)
 {
    $this->id = $id;

    if (strlen($name)>self::MAX_NAME_LENGTH){
        throw new Exception("Name too long.");
    }
    $this->name = $name;
    $this->releaseDate = $releaseDate;
 }

 public static function fromDataBase($row): self
 {
    if ($row == false){
      throw new Exception("Not found.",404);
    }
    $releaseDate = $row["RELEASE_DATE"] === null
        ? null
        : DateTimeImmutable::createFromFormat("Y-m-d", $row["RELEASE_DATE"]);
    return new self(
        MovieId:: fromInteger((int) $row["ID"]),
        $row["NAME"],
        $releaseDate
    );
 }

 public static function register(MovieId $id,  string $name, ?DateTimeImmutable $releaseDate = null): self
 {
    return new self ($id, $name, $releaseDate);
 }

 public function id(): MovieId
 {
    return $this->id;
 }

 public function name(): string
 {
    return $this->name;
 }

 public  function changeName(string $name): void
 {
    $this->name = $name;
 }

 public function releaseDate(): ?DateTimeImmutable
 {
    return $this->releaseDate;
 }

 public function changeReleaseDate(?DateTimeImmutable $releaseDate): void
 {
    $this->releaseDate = $releaseDate;
 }

 public function release(): void
 {
    $this->releaseDate = new DateTimeImmutable("now");
 }

 public function serialize(): array
 {
    return [
        "id"=>$this->id->toInteger(),
        "name"=>$this->name,
        "releaseDate"=>$this->releaseDate === null
            ? null
            : $this->releaseDate->format("Y-m-d"),
    ];
 }

}

