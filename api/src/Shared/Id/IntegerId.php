<?php

namespace Alice\MoviesTutorial\Shared\Id;

class IntegerId{

    /** @var int */
    private $id;

    private function __construct(int $id)
    {
        $this->id = $id;
        
    }

    public static function fromInteger(int $id): self
    {
        return new static($id);
    }

    public function toInteger(): int
    {
        return $this->id;
    }

    /** @param static $id */
    public function equals($id): bool
    {
        return $this->id === $id->id;
    }

}