<section id="bookings" class="scroll-mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-8" aria-labelledby="bookings-heading">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h2 id="bookings-heading" class="text-lg font-semibold text-slate-900 dark:text-white">
                {{ $isAdmin ? 'All bookings' : 'Your bookings' }}
            </h2>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                {{ $isAdmin ? 'Every reservation in the system.' : 'Upcoming and past reservations tied to your account.' }}
            </p>
        </div>
        <a href="{{ route('dashboard.bookings.create') }}" class="inline-flex shrink-0 items-center justify-center rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700 dark:bg-sky-500 dark:hover:bg-sky-400">
            Create booking
        </a>
    </div>

    @if ($bookings->isEmpty())
        <p class="mt-6 rounded-xl border border-dashed border-slate-300 bg-slate-50 py-10 text-center text-sm text-slate-600 dark:border-slate-700 dark:bg-slate-950/50 dark:text-slate-400">
            {{ $isAdmin ? 'No bookings found.' : 'You have no bookings yet. Contact the school or log in after booking online when that flow is available.' }}
        </p>
    @else
        <div class="mt-6 overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-800">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm dark:divide-slate-800">
                <thead class="bg-slate-50 dark:bg-slate-800/80">
                    <tr>
                        @if ($isAdmin)
                            <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">ID</th>
                            <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Student</th>
                        @endif
                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Resource</th>
                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Start</th>
                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">End</th>
                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Instructor</th>
                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Status</th>
                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Total</th>
                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                    @foreach ($bookings as $booking)
                        <tr>
                            @if ($isAdmin)
                                <td class="whitespace-nowrap px-4 py-3 font-mono text-slate-600 dark:text-slate-400">#{{ $booking->id }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-slate-800 dark:text-slate-200">{{ $booking->user?->name ?? '—' }}</td>
                            @endif
                            <td class="max-w-xs truncate px-4 py-3 text-slate-800 dark:text-slate-200" title="{{ $booking->bookableSummary() }}">{{ $booking->bookableSummary() }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-slate-600 dark:text-slate-400">{{ $booking->booking_date_time_start?->format('M j, Y g:i A') }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-slate-600 dark:text-slate-400">{{ $booking->booking_date_time_end?->format('M j, Y g:i A') }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-slate-600 dark:text-slate-400">{{ $booking->instructorDisplayName() ?? '—' }}</td>
                            <td class="whitespace-nowrap px-4 py-3">
                                @if($booking->booking_status === \App\Enums\BookingStatus::CONFIRMED->value)
                                    <span class="inline-flex rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium capitalize text-green-800 dark:bg-green-800 dark:text-green-200">{{ $booking->booking_status }}</span>
                                @elseif($booking->booking_status === \App\Enums\BookingStatus::PENDING->value)
                                    <span class="inline-flex rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium capitalize text-yellow-800 dark:bg-yellow-800 dark:text-yellow-200">{{ $booking->booking_status }}</span>
                                @elseif($booking->booking_status === \App\Enums\BookingStatus::CANCELLED->value)
                                    <span class="inline-flex rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium capitalize text-red-800 dark:bg-red-800 dark:text-red-200">{{ $booking->booking_status }}</span>
                                @elseif($booking->booking_status === \App\Enums\BookingStatus::COMPLETED->value)
                                    <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium capitalize text-slate-800 dark:bg-slate-800 dark:text-slate-200">{{ $booking->booking_status }}</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 text-slate-800 dark:text-slate-200">£{{ number_format((float) $booking->total_price, 2) }}</td>
                                <td class="whitespace-nowrap px-4 py-3">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <a href="{{ route('dashboard.bookings.show', $booking) }}" class="rounded-md bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-800 transition hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">View</a>
                                        @if($isAdmin)
                                        <a href="{{ route('dashboard.bookings.edit', $booking) }}" class="rounded-md bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-800 transition hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">Update</a>
                                        @endif
                                        <form method="post" action="{{ route('dashboard.bookings.cancel', $booking) }}" class="inline" onsubmit="return confirm('Cancel this booking?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-md bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700 transition hover:bg-red-100 dark:bg-red-950/50 dark:text-red-300 dark:hover:bg-red-950">Cancel</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $bookings->links() }}
        </div>
    @endif
</section>
