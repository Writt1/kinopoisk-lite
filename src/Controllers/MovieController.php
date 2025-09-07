<?php

namespace App\Controllers;

use App\Kernel\Controller\Controller;
use App\Kernel\Http\Redirect;
use App\Kernel\Http\Request;
use App\Kernel\Validator\Validator;
use App\Kernel\View\View;
use App\Services\CategoryService;
use App\Services\MovieService;
use App\Services\ReviewService;

class MovieController extends Controller
{
    private ?MovieService $movieService = null;
    private ?ReviewService $reviewService = null;

    public function create(): void
    {
        $categories = new CategoryService($this->db(), $this->reviewService());

        $this->view('admin/movies/add', [
            'categories' => $categories->all()
        ]);
    }

    public function add(): void
    {
        $this->view('admin/movies/add');
    }

    public function store(): void
    {
        $file = $this->request()->file('image');



        $validation = $this->request()->validate([
            'name' => ['required', 'min:3', 'max:50'],
            'description' => ['required'],
            'category' => ['required'],
            ]
        );

        if (! $validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }
            $this->redirect('/admin/movies/add');
        }

        $this->movieService()->store(
            $this->request()->input('name'),
            $this->request()->input('description'),
            $this->request()->file('image'),
            $this->request()->input('category'),
        );

        $this->redirect('/admin');
    }

    public function destroy(): void
    {
        $this->movieService()->delete($this->request()->input('id'));

        $this->redirect('/admin');
    }

    public function edit(): void
    {
        $categories = new CategoryService($this->db(), $this->reviewService());

        $this->view('admin/movies/update', [
            'movie' => $this->movieService()->find($this->request()->input('id')),
            'categories' => $categories->all()
        ]);
    }

    public function update(): void
    {
        $validation = $this->request()->validate([
                'name' => ['required', 'min:3', 'max:50'],
                'description' => ['required'],
                'category' => ['required'],
            ]
        );

        if (! $validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }

            $this->redirect("/admin/movies/update?id={$this->request()->input('id')}");
        }

        $this->movieService()->update(
            $this->request()->input('id'),
            $this->request()->input('name'),
            $this->request()->input('description'),
            $this->request()->file('image'),
            $this->request()->input('category'),
        );

        $this->redirect('/admin');
    }

    public function show(): void
    {
        $movie = $this->movieService()->find($this->request()->input('id'));

        $this->view('/movie', [
            'movie' => $movie
        ], $movie->name());
    }

    public function home(): void
    {
        $movies = $this->movieService()->new();

        $this->view('home', [
            'movies' => $movies
        ], 'Главная страница');
    }

    public function best(): void
    {
        $movies = $this->movieService()->best('8.5');

        $this->view('best', [
            'movies' => $movies
        ], 'Лучшее');
    }

    protected function reviewService(): ReviewService
    {
        if ($this->reviewService === null) {
            $this->reviewService = new ReviewService($this->db());
        }
        return $this->reviewService;
    }

    protected function movieService(): MovieService
    {
        if ($this->movieService === null) {
            $this->movieService = new MovieService($this->db(), $this->reviewService());
        }
        return $this->movieService;
    }
}