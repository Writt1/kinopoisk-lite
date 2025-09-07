<?php

namespace App\Middleware;

use App\Kernel\Middleware\AbstractMiddleware;

class AdminMiddleware extends AbstractMiddleware
{

    public function handle(): void
    {
        if (! $this->auth->check()) {
            $this->redirect->to('/login');
        }

        if (! $this->auth->user()->isAdmin()) {
            $this->redirect->to('/');
        }
    }
}