<?php

namespace App\Services;

use App\Kernel\Auth\User;
use App\Kernel\Database\DatabaseInterface;
use App\Models\Review;

class ReviewService
{
    public function __construct(
        private DatabaseInterface $db
    )
    {
    }

    public function store(float $rating, string $review, int $movie_id, int $user_id): false|int
    {
        return $this->db->insert('reviews', [
            'rating' => $rating,
            'review' => $review,
            'movie_id' => $movie_id,
            'user_id' => $user_id
        ]);
    }

    public function getReviews(int $id): array
    {
        $reviews = $this->db->get('reviews', [
            'movie_id' => $id
        ], ['id' => 'DESC']);

        return array_map(function ($review) {
            $user = $this->db->first('users', [
                'id' => $review['user_id']
            ]);

            return new Review(
                id: $review['id'],
                rating: $review['rating'],
                review: $review['review'],
                createdAt: $review['created_at'],
                user: new User(
                    $user['id'],
                    $user['name'],
                    $user['email'],
                    $user['password'],
                    $user['is_admin']
                )
            );
        }, $reviews);

    }

}

