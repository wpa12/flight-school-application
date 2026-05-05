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
use Illuminate\Database\Eloquent\Builder;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $isAdmin = (bool) $user->is_admin ?? false; // is the user an admin or not

        // data for the dashboard view
        $data = [
            'isAdmin' => $isAdmin,
            'bookings' => Booking::query()
                ->when(! $isAdmin, fn (Builder $query): Builder => $query->where('user_id', $user->id))
                ->with(['user', 'bookable', 'instructor']) // eagerload the relationships
                ->where('booking_date_time_start', '>=', now())
                ->where(function ($query) {
                    return $query->where('booking_status', 'confirmed')
                        ->orWhere('booking_status', 'pending');
                })
                ->orderBy('booking_date_time_start', 'asc') //lastest bookings at top
                ->paginate(20),
            'aircraft' => Aircraft::query()->orderBy('registration')->get(), // get all the aircraft and order them by registration
            'instructors' => Instructor::query()
                ->orderBy('first_name')
                ->get(), // get all the instructors and order them by first name
        ];

        // if the user is an admin get all the users and order them by name and return the view with the data
        if ($isAdmin) {
            $data['users'] = User::query()->select(['id', 'name', 'email', 'is_admin'])->orderBy('name')->get();
        }

        return view('dashboard', $data);
    }

    public function adminPlaceholder(): RedirectResponse
    {
        return redirect()
            ->route('dashboard.index')
            ->with('status', 'This admin action is not wired yet. Add a controller method and update the route.');
    }
}
