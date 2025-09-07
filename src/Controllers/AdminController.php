<?php

namespace App\Controllers;

use App\Kernel\Controller\Controller;
use App\Services\CategoryService;
use App\Services\MovieService;
use App\Services\ReviewService;

class AdminController extends Controller
{

    public function index(): void
    {
        $reviewService = new ReviewService($this->db());
        $categories = new CategoryService($this->db(), $reviewService);
        $movies = new MovieService($this->db(), $reviewService);

        $this->view('admin/index', [
            'categories' => $categories->all(),
            'movies' => $movies->all()
        ]);
    }

}