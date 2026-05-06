<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\Aircraft;
use App\Models\Instructor;
use App\Models\Exam;
use App\Enums\BookableType;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // used a view composer for the booking create view to keep controller clean
        View::composer('booking.create', function ($view) {
            $view->with([
                'users' => User::all('id', 'name', 'email'),
                'aircraftFleet' => Aircraft::isServiceable()->get(),
                'instructors' => Instructor::all('id', 'first_name', 'last_name'),
                'exams' => Exam::all('id', 'type', 'duration_minutes', 'total_price'),
                'bookableTypeCases' => BookableType::cases(),
            ]);
        });
    }

}
