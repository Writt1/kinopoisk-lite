<?php

namespace App\Controllers;

use App\Kernel\Controller\Controller;
use App\Services\ReviewService;

class ReviewController extends Controller
{
    private ReviewService $service;
    public function store(): void
    {
        $validation = $this->request()->validate([
            'rating' => ['required'],
            'review' => ['required'],
        ]);

        if (! $validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }
            $this->redirect("/movie?id={$this->request()->input('id')}");
        }

        $this->service()->store(
            $this->request()->input('rating'),
            $this->request()->input('review'),
            $this->request()->input('id'),
            $this->auth()->id()
        );

        $this->redirect("/movie?id={$this->request()->input('id')}");
    }

    public function service(): ReviewService
    {
        if (! isset($this->service)) {
            $this->service = new ReviewService($this->db());
        }

        return $this->service;
    }
}