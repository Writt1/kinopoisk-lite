<?php

namespace App\Services;

use App\Kernel\Database\DatabaseInterface;
use App\Models\Category;
use App\Models\Movie;

class CategoryService
{


    public function __construct(
        private DatabaseInterface $db,
        private ReviewService $reviewService
    )
    {
    }

    /**
     * @return array<Category>
     */

    public function all(): array
    {
        $categories = $this->db->get('categories');

        return array_map(function ($category) {
            $categoryObj = new Category(
                id: $category['id'],
                name: $category['name'],
                createdAt: $category['created_at'],
                updatedAt: $category['updated_at']
            );

            $movies = $this->findMovies($category['id']);
            $categoryObj->setMoviesCount(count($movies));

            return $categoryObj;
        }, $categories);
    }

    public function delete(int $id): void
    {
        $this->db->delete('categories', [
            'id' => $id
        ]);
    }

    public function store(string $name): int
    {
        return $this->db->insert('categories', [
            'name' => $name
        ]);
    }

    public function find(int $id): ?Category
    {
        $category = $this->db->first('categories', [
            'id' => $id
        ]);

        if (! $category) {
            return null;
        }

        return new Category(
            id: $category['id'],
            name: $category['name'],
            createdAt: $category['created_at'],
            updatedAt: $category['updated_at']
        );
    }

    public function update(int $id, string $name): void
    {
        $this->db->update('categories', [
            'name' => $name,
        ], [
            'id' => $id
        ]);
    }

    public function findMovies($categoryId): array
    {
        $movies = $this->db->get('movies', ['category_id' => $categoryId]);

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