<?php

namespace App\Controllers;

use App\Kernel\Controller\Controller;
use App\Services\CategoryService;
use App\Services\ReviewService;

class CategoryController extends Controller
{
    private ?CategoryService $categoryService = null;
    private ?ReviewService $reviewService = null;

    public function index(): void
    {
        $this->view('categories/index', [
            'categories' => $this->categoryService()->all()
        ], 'Жанры');
    }

    public function create(): void
    {
        $this->view('admin/categories/add');
    }

    public function store(): void
    {
        $validation = $this->request()->validate([
            'name' => ['required', 'min:3', 'max:255']
        ]);

        if (! $validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }

            $this->redirect('/admin/categories/add');
        }

        $this->categoryService()->store($this->request()->input('name'));

        $this->redirect('/admin');
    }

    public function destroy(): void
    {
        $this->categoryService()->delete($this->request()->input('id'));

        $this->redirect('/admin');

    }

    public function edit(): void
    {
        $category = $this->categoryService()->find($this->request()->input('id'));

        $this->view('admin/categories/update', [
            'category' => $category
        ]);
    }

    public function update(): void
    {
        $validation = $this->request()->validate([
            'name' => ['required', 'min:3', 'max:255']
        ]);

        if (! $validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }

            $this->redirect("/admin/categories/update?id={$this->request()->input('id')}");
        }

        $this->categoryService()->update(
            $this->request()->input('id'),
            $this->request()->input('name')
        );

        $this->redirect('/admin');
    }

    public function show(): void
    {
        $movies = $this->categoryService()->findMovies($this->request()->input('id'));

        $category = $this->categoryService()->find($this->request()->input('id'));


        $this->view('categories/category', [
            'movies' => $movies,
            'category' => $category,
        ], $category->name());
    }

    private function reviewService(): ReviewService
    {
        if (! isset($this->reviewService)) {
            $this->reviewService = new ReviewService($this->db());
        }

        return $this->reviewService;
    }

    private function categoryService(): CategoryService
    {
        if (! isset($this->categoryService)) {
            $this->categoryService = new CategoryService($this->db(), $this->reviewService());
        }

        return $this->categoryService;
    }

}