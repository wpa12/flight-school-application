<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Aircraft;
use App\Models\Booking;
use App\Models\Instructor;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Services\UserService;

class DashboardController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {}

    public function index(Request $request): View
    {
        $user = $request->user();

        $users = $this->userService->getUsers(['id', 'name', 'email', 'is_admin']);

        if ($user->is_admin) {
            return view('dashboard', [
                'isAdmin' => $request->user()->is_admin,
                'bookings' => Booking::query()
                    ->with(['user', 'bookable', 'instructor'])
                    ->orderByDesc('booking_date_time_start')
                    ->get(),
                'aircraft' => Aircraft::query()->orderBy('registration')->get(),
                'instructors' => Instructor::query()
                    ->orderBy('last_name')
                    ->orderBy('first_name')
                    ->get(),
                'users' => $this->userService->getUsers(['id', 'name', 'email', 'is_admin']),
            ]);
        }

        return view('dashboard', [
            'isAdmin' => false,
            'bookings' => Booking::query()
                ->where('user_id', $user->id)
                ->with(['bookable', 'instructor'])
                ->orderByDesc('booking_date_time_start')
                ->get(),
        ]);
    }

    public function adminPlaceholder(): RedirectResponse
    {
        return redirect()
            ->route('dashboard')
            ->with('status', 'This admin action is not wired yet. Add a controller method and update the route.');
    }
}
