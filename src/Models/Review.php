<?php

namespace App\Models;

use App\Kernel\Auth\User;
use App\Models\Movie;

class Review
{
    public function __construct(
        private int $id,
        private float $rating,
        private string $review,
        private string $createdAt,
        private ?User $user = null,
        private ?Movie $movie = null
    )
    {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function rating(): string
    {
        return $this->rating;
    }

    public function review(): string
    {
        return $this->review;
    }

    public function createdAt(): string
    {
        return $this->createdAt;
    }

    public function user(): User
    {
        return $this->user;
    }

    public function Movie(): Movie
    {
        return $this->movie;
    }
}