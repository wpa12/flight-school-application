<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Booking;
use App\Services\BookingService;
use App\Http\Requests\CreateBookingRequest;
use App\Http\Requests\UpdateBookingRequest;

class BookingController extends Controller
{

    public function __construct(private readonly BookingService $bookingService)
    {}

    /** Show the form for creating a new booking */
    public function create(): View
    {
        return view('booking.create');
    }

    /** Store a new booking */
    public function store(CreateBookingRequest $request): RedirectResponse
    {
        $this->bookingService->createBooking($request->bookable_type, $request->bookable_id, $request->validated());

        return redirect()->route('dashboard.index')->with('status', 'Booking created successfully');
    }

    /** Show a booking */
    public function show(Booking $booking): View
    {
        $bookableType = $this->bookingService->getBookableType($booking);

        return view('booking.show', [
            'booking' => $booking->load(['bookable', 'instructor', 'user']), // load the relationships on the booking
            'bookableType' => $bookableType,
        ]);
    }

    /** Edit a booking */
    public function edit(Booking $booking): View
    {
        $bookableType = $this->bookingService->getBookableType($booking);

        return view('booking.edit', [
            'booking' => $booking->load(['bookable', 'instructor', 'user']), // booking to the edit view
            'bookableType' => $bookableType,
        ]);
    }

    /** Update a booking */
    public function update(UpdateBookingRequest $request, Booking $booking): RedirectResponse
    {
        $this->bookingService->updateBooking($booking, $request->all()); // upate the booking with the new data

        return redirect()->route('dashboard.index')->with('status', 'Booking updated successfully');
    }


    /** Cancel a booking */
    public function cancel(Booking $booking): RedirectResponse
    {
        $this->bookingService->cancelBooking($booking);
        return redirect()->route('dashboard.index')->with('status', 'Booking cancelled successfully');
    }
}
