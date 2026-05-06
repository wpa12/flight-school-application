@extends('welcome')
@section('content')
    <main class="w-full">
        <section class="border-b border-slate-200/80 bg-linear-to-b from-sky-50 via-white to-white py-10 dark:border-slate-800 dark:from-slate-900 dark:via-slate-950 dark:to-slate-950 sm:py-12">
            <div class="mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
                <p class="text-sm font-semibold uppercase tracking-wider text-sky-600 dark:text-sky-400">Booking Details</p>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl dark:text-white">
                    Booking #{{ $booking->id }}
                </h1>
                <p class="mx-auto mt-4 max-w-xl text-base leading-relaxed text-slate-600 dark:text-slate-400">
                    View your booking information and manage your reservation.
                </p>
            </div>
        </section>

        <section class="bg-white py-12 dark:bg-slate-950 sm:py-16">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <div class="space-y-8">
                    {{-- Booking Status Banner --}}
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/80 p-6 shadow-sm ring-1 ring-slate-200/60 dark:border-slate-800 dark:bg-slate-900/60 dark:ring-slate-800/80">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Booking Status</h2>
                                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                                    Reference: #{{ $booking->id }} &bull; Created {{ $booking->created_at->format('M j, Y \a\t g:i A') }}
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

                    {{-- Booking Summary --}}
                    <div class="rounded-2xl border border-sky-200 bg-sky-50/80 p-6 shadow-sm ring-1 ring-sky-200/60 dark:border-sky-800 dark:bg-sky-900/20 dark:ring-sky-800/80">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-sky-100 dark:bg-sky-900/50">
                                @if($bookableType === 'aircraft')
                                    <svg class="h-5 w-5 text-sky-600 dark:text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                @elseif($bookableType === 'lesson')
                                    <svg class="h-5 w-5 text-sky-600 dark:text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                @elseif($bookableType === 'exam')
                                    <svg class="h-5 w-5 text-sky-600 dark:text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @else
                                    <svg class="h-5 w-5 text-sky-600 dark:text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">{{ ucfirst($bookableType) }} Booking</h2>
                                <p class="text-sm text-slate-600 dark:text-slate-400">{{ $booking->bookableSummary() }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Schedule Details --}}
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/80 p-6 shadow-sm ring-1 ring-slate-200/60 dark:border-slate-800 dark:bg-slate-900/60 dark:ring-slate-800/80">
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Schedule</h2>
                        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Date and time details for your booking</p>

                        <div class="mt-6 grid gap-6 sm:grid-cols-2">
                            <div class="flex items-start gap-4">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/30">
                                    <svg class="h-5 w-5 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Start</p>
                                    <p class="mt-1 text-lg font-semibold text-slate-900 dark:text-white">
                                        {{ $booking->booking_date_time_start?->format('l, M j, Y') }}
                                    </p>
                                    <p class="text-slate-600 dark:text-slate-400">
                                        {{ $booking->booking_date_time_start?->format('g:i A') }}
                                    </p>
                                </div>
                            </div>

                            @if($booking->booking_date_time_end)
                                <div class="flex items-start gap-4">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-100 dark:bg-red-900/30">
                                        <svg class="h-5 w-5 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400">End</p>
                                        <p class="mt-1 text-lg font-semibold text-slate-900 dark:text-white">
                                            {{ $booking->booking_date_time_end->format('l, M j, Y') }}
                                        </p>
                                        <p class="text-slate-600 dark:text-slate-400">
                                            {{ $booking->booking_date_time_end->format('g:i A') }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if($booking->booking_date_time_end && $booking->booking_date_time_start)
                            @php
                                $duration = $booking->booking_date_time_start->diff($booking->booking_date_time_end);
                                $hours = $duration->h + ($duration->days * 24);
                                $minutes = $duration->i;
                            @endphp
                            <div class="mt-6 flex items-center gap-2 rounded-lg bg-slate-100 px-4 py-3 dark:bg-slate-800">
                                <svg class="h-5 w-5 text-slate-500 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                    Duration: {{ $hours > 0 ? $hours . ' hour' . ($hours > 1 ? 's' : '') : '' }}{{ $hours > 0 && $minutes > 0 ? ' ' : '' }}{{ $minutes > 0 ? $minutes . ' minute' . ($minutes > 1 ? 's' : '') : '' }}
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- Bookable Details --}}
                    @if($bookableType === 'aircraft' && $booking->bookable)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50/80 p-6 shadow-sm ring-1 ring-slate-200/60 dark:border-slate-800 dark:bg-slate-900/60 dark:ring-slate-800/80">
                            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Aircraft Details</h2>
                            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Information about the aircraft you're renting</p>

                            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                <div>
                                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Registration</p>
                                    <p class="mt-1 text-slate-900 dark:text-white">{{ $booking->bookable->registration ?? '—' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Make & Model</p>
                                    <p class="mt-1 text-slate-900 dark:text-white">{{ ($booking->bookable->make ?? '') . ' ' . ($booking->bookable->model ?? '') ?: '—' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Hourly Rate</p>
                                    <p class="mt-1 text-slate-900 dark:text-white">£{{ number_format($booking->bookable->rental_price_per_hour ?? 0, 2) }}/hr</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($bookableType === 'lesson' && $booking->bookable)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50/80 p-6 shadow-sm ring-1 ring-slate-200/60 dark:border-slate-800 dark:bg-slate-900/60 dark:ring-slate-800/80">
                            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Lesson Details</h2>
                            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Information about your flight lesson</p>

                            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                                @if($booking->bookable->aircraft)
                                    <div>
                                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Aircraft</p>
                                        <p class="mt-1 text-slate-900 dark:text-white">
                                            {{ $booking->bookable->aircraft->registration ?? '—' }} -
                                            {{ ($booking->bookable->aircraft->make ?? '') . ' ' . ($booking->bookable->aircraft->model ?? '') }}
                                        </p>
                                    </div>
                                @endif
                                @if($booking->instructor)
                                    <div>
                                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Instructor</p>
                                        <p class="mt-1 text-slate-900 dark:text-white">{{ $booking->instructorDisplayName() ?? '—' }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if($bookableType === 'exam' && $booking->bookable)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50/80 p-6 shadow-sm ring-1 ring-slate-200/60 dark:border-slate-800 dark:bg-slate-900/60 dark:ring-slate-800/80">
                            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Exam Details</h2>
                            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Information about your exam registration</p>

                            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                                <div>
                                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Exam Type</p>
                                    <p class="mt-1 text-slate-900 dark:text-white">{{ $booking->bookable->type ?? '—' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Exam Fee</p>
                                    <p class="mt-1 text-slate-900 dark:text-white">£{{ number_format($booking->bookable->total_price ?? 0, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Notes Section --}}
                    @if($booking->notes)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50/80 p-6 shadow-sm ring-1 ring-slate-200/60 dark:border-slate-800 dark:bg-slate-900/60 dark:ring-slate-800/80">
                            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Additional Notes</h2>
                            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Special requests or notes for this booking</p>

                            <div class="mt-4 rounded-lg bg-slate-100 px-4 py-3 dark:bg-slate-800">
                                <p class="text-slate-700 dark:text-slate-300">{{ $booking->notes }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Payment Summary --}}
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/80 p-6 shadow-sm ring-1 ring-slate-200/60 dark:border-slate-800 dark:bg-slate-900/60 dark:ring-slate-800/80">
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Payment Summary</h2>
                        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Total cost for this booking</p>

                        <div class="mt-6 flex items-end justify-between border-t border-slate-200 pt-4 dark:border-slate-700">
                            <div>
                                <p class="text-sm text-slate-600 dark:text-slate-400">Total Amount</p>
                            </div>
                            <div class="text-right">
                                <p class="text-3xl font-bold text-slate-900 dark:text-white">£{{ number_format($booking->total_price ?? 0, 2) }}</p>
                                @if($bookableType !== 'exam')
                                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-500">Excludes landing fees and fuel</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        @if($booking->booking_status !== 'cancelled' && $booking->booking_status !== 'completed')
                            <form
                                action="{{ route('dashboard.bookings.cancel', $booking) }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to cancel this booking? This action cannot be undone.')"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-red-300 bg-white px-4 py-2.5 text-sm font-medium text-red-600 shadow-sm transition hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500/20 dark:border-red-700 dark:bg-slate-800 dark:text-red-400 dark:hover:bg-red-900/20"
                                >
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Cancel Booking
                                </button>
                            </form>
                        @else
                            <div></div>
                        @endif

                        <div class="flex items-center gap-4">
                            <a
                                href="{{ route('dashboard.index') }}"
                                class="rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-sky-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700"
                            >
                                Back to Dashboard
                            </a>
                            @if($booking->booking_status !== 'cancelled' && $booking->booking_status !== 'completed')
                                <a
                                    href="{{ route('dashboard.bookings.edit', $booking) }}"
                                    class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500/50 dark:bg-sky-500 dark:hover:bg-sky-600"
                                >
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit Booking
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
