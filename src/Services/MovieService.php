<?php

namespace App\Services;

use App\Kernel\Auth\User;
use App\Kernel\Database\DatabaseInterface;
use App\Kernel\Upload\UploadedFileInterface;
use App\Models\Category;
use App\Models\Movie;
use App\Models\Review;

class MovieService
{
    public function __construct(
        private DatabaseInterface $db,
        private ReviewService $reviewService
    )
    {
    }

    public function store(string $name, string $description, UploadedFileInterface $image, int $category): false|int
    {
        $filePath = $image->move('movies');

        return $this->db->insert('movies', [
            'name' => $name,
            'description' => $description,
            'preview' => $filePath,
            'category_id' => $category
        ]);
    }

    public function all(): array
    {
        $movies =  $this->db->get('movies');

        return array_map(function ($movie) {
            return new Movie(
                id: $movie['id'],
                name: $movie['name'],
                description: $movie['description'],
                preview: $movie['preview'],
                categoryId: $movie['category_id'],
                createdAt: $movie['created_at'],
            );
        }, $movies);
    }

    public function delete(int $id): void
    {
        $this->db->delete('movies', [
            'id' => $id
        ]);
    }

    public function find(int $id): ?Movie
    {
        $movie = $this->db->first('movies', [
            'id' => $id
        ]);

        if (! $movie) {
            return null;
        }

        return new Movie(
            id: $movie['id'],
            name: $movie['name'],
            description: $movie['description'],
            preview: $movie['preview'],
            categoryId: $movie['category_id'],
            createdAt: $movie['created_at'],
            reviews: $this->reviewService->getReviews($id)

        );

    }

    public function update(int $id, string $name, string $description, ?UploadedFileInterface $image, int $category): void
    {

        $data = [
            'name' => $name,
            'description' => $description,
            'category_id' => $category
        ];


        if ($image && ! $image->hasError()) {
            $data['preview'] = $image->move('movies');
        }

        $this->db->update('movies', $data, [
            'id' => $id
        ]);
    }

    public function new(): array
    {
        $movies = $this->db->get('movies', [], ['id' => 'DESC'], 10);

        return array_map(function ($movie) {
            return new Movie(
                id: $movie['id'],
                name: $movie['name'],
                description: $movie['description'],
                preview: $movie['preview'],
                categoryId: $movie['category_id'],
                createdAt: $movie['created_at'],
                reviews: $this->reviewService->getReviews($movie['id'])
            );
        }, $movies);
    }

    public function best(string $rating): ?array
    {
        $movies = $this->db->topRated(8.5);

        return array_map(function ($movie) {
            return new Movie(
                id: $movie['id'],
                name: $movie['name'],
                description: $movie['description'],
                preview: $movie['preview'],
                categoryId: $movie['category_id'],
                createdAt: $movie['created_at'],
                reviews: $this->reviewService->getReviews($movie['id'])
            );
        }, $movies);
    }



}


