@extends('welcome')
@section('content')
    <main class="w-full">
        <section class="border-b border-slate-200/80 bg-linear-to-b from-sky-50 via-white to-white py-10 dark:border-slate-800 dark:from-slate-900 dark:via-slate-950 dark:to-slate-950 sm:py-12">
            <div class="mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
                <p class="text-sm font-semibold uppercase tracking-wider text-sky-600 dark:text-sky-400">Manage</p>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl dark:text-white">
                    Edit Booking
                </h1>
                <p class="mx-auto mt-4 max-w-xl text-base leading-relaxed text-slate-600 dark:text-slate-400">
                    Reschedule your booking to a different date or time.
                </p>
            </div>
        </section>

        <section class="bg-white py-12 dark:bg-slate-950 sm:py-16">
            <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                <form
                    x-data="{
                        startDate: '{{ $booking->booking_date_time_start?->format('Y-m-d') }}',
                        startTime: '{{ $booking->booking_date_time_start?->format('H:i') }}'
                    }"
                    action="{{ route('dashboard.bookings.update', $booking) }}"
                    method="POST"
                    class="space-y-8"
                >
                    @csrf
                    @method('PUT')

                    {{-- Booking Status Banner --}}
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/80 p-6 shadow-sm ring-1 ring-slate-200/60 dark:border-slate-800 dark:bg-slate-900/60 dark:ring-slate-800/80">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Booking Status</h2>
                                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                                    Reference: #{{ $booking->id }} &bull; Created {{ $booking->created_at->format('M j, Y') }}
                                </p>
                            </div>
                            <div>
                                @php
                                    $statusColors = match ($booking->booking_status) {
                                        'confirmed' => 'bg-green-100 text-green-800 ring-green-600/20 dark:bg-green-900/30 dark:text-green-400 dark:ring-green-400/30',
                                        'pending' => 'bg-yellow-100 text-yellow-800 ring-yellow-600/20 dark:bg-yellow-900/30 dark:text-yellow-400 dark:ring-yellow-400/30',
                                        'cancelled' => 'bg-red-100 text-red-800 ring-red-600/20 dark:bg-red-900/30 dark:text-red-400 dark:ring-red-400/30',
                                        'completed' => 'bg-slate-100 text-slate-800 ring-slate-600/20 dark:bg-slate-800 dark:text-slate-400 dark:ring-slate-400/30',
                                        default => 'bg-slate-100 text-slate-800 ring-slate-600/20 dark:bg-slate-800 dark:text-slate-400 dark:ring-slate-400/30',
                                    };
                                @endphp
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium ring-1 ring-inset {{ $statusColors }}">
                                    {{ ucfirst($booking->booking_status ?? 'Unknown') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Current Booking Summary --}}
                    <div class="rounded-2xl border border-sky-200 bg-sky-50/80 p-6 shadow-sm ring-1 ring-sky-200/60 dark:border-sky-800 dark:bg-sky-900/20 dark:ring-sky-800/80">
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Booking Details</h2>
                        <div class="mt-3 grid gap-3 sm:grid-cols-2">
                            <div>
                                <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Type</p>
                                <p class="mt-0.5 text-slate-900 dark:text-white">{{ ucfirst($bookableType) }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Details</p>
                                <p class="mt-0.5 text-slate-900 dark:text-white">{{ $booking->bookableSummary() }}</p>
                            </div>
                            @if($booking->instructor)
                                <div>
                                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Instructor</p>
                                    <p class="mt-0.5 text-slate-900 dark:text-white">{{ $booking->instructorDisplayName() }}</p>
                                </div>
                            @endif
                            <div>
                                <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Total Price</p>
                                <p class="mt-0.5 text-slate-900 dark:text-white">£{{ number_format($booking->total_price, 2) }}</p>
                            </div>
                            @if($booking->booking_date_time_start && $booking->booking_date_time_end && $bookableType !== 'exam')
                                <div>
                                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Duration</p>
                                    <p class="mt-0.5 text-slate-900 dark:text-white">{{ number_format($booking->booking_date_time_start->diffInMinutes($booking->booking_date_time_end) / 60, 1) }} hours</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Schedule --}}
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/80 p-6 shadow-sm ring-1 ring-slate-200/60 dark:border-slate-800 dark:bg-slate-900/60 dark:ring-slate-800/80">
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Reschedule</h2>
                        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Choose a new date and time for your booking</p>

                        <div class="mt-4 grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Start Date</label>
                                <input
                                    x-model="startDate"
                                    type="date"
                                    name="start_date"
                                    id="start_date"
                                    required
                                    :min="new Date().toISOString().split('T')[0]"
                                    class="mt-1.5 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-sky-400"
                                >
                                @error('start_date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="start_time" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Start Time</label>
                                <input
                                    x-model="startTime"
                                    type="time"
                                    name="start_time"
                                    id="start_time"
                                    required
                                    min="06:00"
                                    max="20:00"
                                    step="1800"
                                    class="mt-1.5 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-sky-400"
                                >
                                @error('start_time')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-end">
                        <a
                            href="{{ url()->previous() ?? route('dashboard.index') }}"
                            class="rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-sky-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700"
                        >
                            Back
                        </a>
                        <button
                            type="submit"
                            class="rounded-lg bg-sky-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500/50 dark:bg-sky-500 dark:hover:bg-sky-600"
                        >
                            Reschedule Booking
                        </button>
                    </div>
                </form>

                {{-- Cancel Booking Form (separate from main form) --}}
                <form
                    action="{{ route('dashboard.bookings.cancel', $booking) }}"
                    method="POST"
                    onsubmit="return confirm('Are you sure you want to cancel this booking? This action cannot be undone.')"
                    class="mt-8 border-t border-slate-200 pt-8 dark:border-slate-800"
                >
                    @csrf
                    @method('DELETE')
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-slate-900 dark:text-white">Cancel this booking</h3>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">This action cannot be undone.</p>
                        </div>
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-lg border border-red-300 bg-white px-4 py-2.5 text-sm font-medium text-red-600 shadow-sm transition hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500/20 dark:border-red-700 dark:bg-slate-800 dark:text-red-400 dark:hover:bg-red-900/20"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel Booking
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </main>
@endsection
