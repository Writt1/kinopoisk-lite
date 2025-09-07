<?php

namespace App\Models;

class Category
{
    public function __construct(
        private int $id,
        private string $name,
        private string $createdAt,
        private string $updatedAt,
        private int $moviesCount = 0
    )
    {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function createdAt(): string
    {
        return $this->createdAt;
    }

    public function updatedAt(): string
    {
        return $this->updatedAt;
    }

    public function setMoviesCount(int $count): void
    {
        $this->moviesCount = $count;
    }

    public function moviesCount(): int
    {
        return $this->moviesCount;
    }

}