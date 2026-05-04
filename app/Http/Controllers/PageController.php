<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Aircraft;
use App\Models\Instructor;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        return view('index');
    }

    public function aircraft(): View
    {
        return view('aircraft', [
            'aircraft' => Aircraft::query()
                ->where('in_service', true)
                ->orderBy('make')
                ->orderBy('model')
                ->get(),
        ]);
    }

    public function exams(): View
    {
        return view('exams');
    }

    public function instructors(): View
    {
        return view('instructors', [
            'instructors' => Instructor::query()
                ->orderBy('last_name')
                ->orderBy('first_name')
                ->get(),
        ]);
    }

    public function login(): View
    {
        return view('login');
    }

    public function register(): View
    {
        return view('register');
    }
}
