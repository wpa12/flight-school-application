@extends('welcome')

@section('content')
    @php($user = auth()->user())
    <main class="w-full bg-slate-50 dark:bg-slate-950">
        <div class="border-b border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
            <div class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-6 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                <div>
                    <h1 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-white">Dashboard</h1>
                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                        Signed in as: <span class="font-medium text-slate-800 dark:text-slate-200">{{ $user->name }}</span>
                        @if ($isAdmin)
                            <span class="ml-2 inline-flex items-center rounded-full bg-sky-100 px-2 py-0.5 text-xs font-semibold text-sky-800 dark:bg-sky-950/80 dark:text-sky-200">Admin</span>
                        @else
                            <span class="ml-2 inline-flex items-center rounded-full bg-slate-200 px-2 py-0.5 text-xs font-semibold text-slate-700 dark:bg-slate-700 dark:text-slate-200">Student</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:border-emerald-900/50 dark:bg-emerald-950/40 dark:text-emerald-200">
                    {{ session('status') }}
                </div>
            @endif

            @if (! $isAdmin)
                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-8" aria-labelledby="student-bookings-heading">
                    <h2 id="student-bookings-heading" class="text-lg font-semibold text-slate-900 dark:text-white">Your bookings</h2>
                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Upcoming and past reservations tied to your account.</p>

                    @if ($bookings->isEmpty())
                        <p class="mt-6 rounded-xl border border-dashed border-slate-300 bg-slate-50 py-10 text-center text-sm text-slate-600 dark:border-slate-700 dark:bg-slate-950/50 dark:text-slate-400">
                            You have no bookings yet. Contact the school or log in after booking online when that flow is available.
                        </p>
                    @else
                        <div class="mt-6 overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-800">
                            <table class="min-w-full divide-y divide-slate-200 text-left text-sm dark:divide-slate-800">
                                <thead class="bg-slate-50 dark:bg-slate-800/80">
                                    <tr>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Resource</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Start</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">End</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Instructor</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Status</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                                    @foreach ($bookings as $booking)
                                        <tr>
                                            <td class="whitespace-nowrap px-4 py-3 text-slate-800 dark:text-slate-200">{{ $booking->bookableSummary() }}</td>
                                            <td class="whitespace-nowrap px-4 py-3 text-slate-600 dark:text-slate-400">{{ $booking->booking_date_time_start?->format('M j, Y g:i A') }}</td>
                                            <td class="whitespace-nowrap px-4 py-3 text-slate-600 dark:text-slate-400">{{ $booking->booking_date_time_end?->format('M j, Y g:i A') }}</td>
                                            <td class="whitespace-nowrap px-4 py-3 text-slate-600 dark:text-slate-400">{{ $booking->instructorDisplayName() ?? '—' }}</td>
                                            <td class="whitespace-nowrap px-4 py-3">
                                                <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium capitalize text-slate-800 dark:bg-slate-800 dark:text-slate-200">{{ $booking->booking_status }}</span>
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 text-slate-800 dark:text-slate-200">£{{ number_format((float) $booking->total_price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </section>
            @else
                <nav class="mb-8 flex flex-wrap gap-2 text-sm" aria-label="Admin sections">
                    <a href="#admin-bookings" class="rounded-lg bg-white px-3 py-1.5 font-medium text-slate-700 shadow-sm ring-1 ring-slate-200 transition hover:bg-slate-50 dark:bg-slate-900 dark:text-slate-200 dark:ring-slate-700 dark:hover:bg-slate-800">Bookings</a>
                    <a href="#admin-users" class="rounded-lg bg-white px-3 py-1.5 font-medium text-slate-700 shadow-sm ring-1 ring-slate-200 transition hover:bg-slate-50 dark:bg-slate-900 dark:text-slate-200 dark:ring-slate-700 dark:hover:bg-slate-800">Users</a>
                    <a href="#admin-aircraft" class="rounded-lg bg-white px-3 py-1.5 font-medium text-slate-700 shadow-sm ring-1 ring-slate-200 transition hover:bg-slate-50 dark:bg-slate-900 dark:text-slate-200 dark:ring-slate-700 dark:hover:bg-slate-800">Aircraft</a>
                    <a href="#admin-instructors" class="rounded-lg bg-white px-3 py-1.5 font-medium text-slate-700 shadow-sm ring-1 ring-slate-200 transition hover:bg-slate-50 dark:bg-slate-900 dark:text-slate-200 dark:ring-slate-700 dark:hover:bg-slate-800">Instructors</a>
                </nav>

                <section id="admin-bookings" class="scroll-mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-8">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">All bookings</h2>
                            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Every reservation in the system. Actions point to admin routes—implement controllers to enable them.</p>
                        </div>
                        <a href="{{ route('admin.bookings.create') }}" class="inline-flex shrink-0 items-center justify-center rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700 dark:bg-sky-500 dark:hover:bg-sky-400">
                            Create booking
                        </a>
                    </div>

                    @if ($bookings->isEmpty())
                        <p class="mt-6 text-sm text-slate-600 dark:text-slate-400">No bookings found.</p>
                    @else
                        <div class="mt-6 overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-800">
                            <table class="min-w-full divide-y divide-slate-200 text-left text-sm dark:divide-slate-800">
                                <thead class="bg-slate-50 dark:bg-slate-800/80">
                                    <tr>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">ID</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Student</th>
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
                                            <td class="whitespace-nowrap px-4 py-3 font-mono text-slate-600 dark:text-slate-400">#{{ $booking->id }}</td>
                                            <td class="whitespace-nowrap px-4 py-3 text-slate-800 dark:text-slate-200">{{ $booking->user?->name ?? '—' }}</td>
                                            <td class="max-w-xs truncate px-4 py-3 text-slate-800 dark:text-slate-200" title="{{ $booking->bookableSummary() }}">{{ $booking->bookableSummary() }}</td>
                                            <td class="whitespace-nowrap px-4 py-3 text-slate-600 dark:text-slate-400">{{ $booking->booking_date_time_start?->format('M j, Y g:i A') }}</td>
                                            <td class="whitespace-nowrap px-4 py-3 text-slate-600 dark:text-slate-400">{{ $booking->booking_date_time_end?->format('M j, Y g:i A') }}</td>
                                            <td class="whitespace-nowrap px-4 py-3 text-slate-600 dark:text-slate-400">{{ $booking->instructorDisplayName() ?? '—' }}</td>
                                            <td class="whitespace-nowrap px-4 py-3">
                                                <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium capitalize text-slate-800 dark:bg-slate-800 dark:text-slate-200">{{ $booking->booking_status }}</span>
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 text-slate-800 dark:text-slate-200">£{{ number_format((float) $booking->total_price, 2) }}</td>
                                            <td class="whitespace-nowrap px-4 py-3">
                                                <div class="flex flex-wrap items-center gap-2">
                                                    <a href="{{ route('admin.bookings.edit', $booking) }}" class="rounded-md bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-800 transition hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">Update</a>
                                                    <form method="post" action="{{ route('admin.bookings.destroy', $booking) }}" class="inline" onsubmit="return confirm('Cancel this booking?');">
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
                    @endif
                </section>

                <section id="admin-users" class="mt-10 scroll-mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-8">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Users</h2>
                            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Add or update accounts manually (password resets, roles, etc.).</p>
                        </div>
                        <a href="{{ route('admin.users.create') }}" class="inline-flex shrink-0 items-center justify-center rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700 dark:bg-sky-500 dark:hover:bg-sky-400">
                            Add user
                        </a>
                    </div>

                    <div class="mt-6 overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-800">
                        <table class="min-w-full divide-y divide-slate-200 text-left text-sm dark:divide-slate-800">
                            <thead class="bg-slate-50 dark:bg-slate-800/80">
                                <tr>
                                    <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Name</th>
                                    <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Email</th>
                                    <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Role</th>
                                    <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                                @foreach ($users as $u)
                                    <tr>
                                        <td class="whitespace-nowrap px-4 py-3 text-slate-800 dark:text-slate-200">{{ $u->name }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-slate-600 dark:text-slate-400">{{ $u->email }}</td>
                                        <td class="whitespace-nowrap px-4 py-3">
                                            @if ($u->is_admin)
                                                <span class="text-xs font-semibold text-sky-700 dark:text-sky-300">Admin</span>
                                            @else
                                                <span class="text-xs text-slate-600 dark:text-slate-400">Student</span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3">
                                            <a href="{{ route('admin.users.edit', $u) }}" class="rounded-md bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-800 transition hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">Update</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>

                <section id="admin-aircraft" class="mt-10 scroll-mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-8">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Aircraft</h2>
                            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Fleet records shown on the public aircraft page use this data.</p>
                        </div>
                        <a href="{{ route('admin.aircraft.create') }}" class="inline-flex shrink-0 items-center justify-center rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700 dark:bg-sky-500 dark:hover:bg-sky-400">
                            Add aircraft
                        </a>
                    </div>

                    @if ($aircraft->isEmpty())
                        <p class="mt-6 text-sm text-slate-600 dark:text-slate-400">No aircraft in the database.</p>
                    @else
                        <div class="mt-6 overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-800">
                            <table class="min-w-full divide-y divide-slate-200 text-left text-sm dark:divide-slate-800">
                                <thead class="bg-slate-50 dark:bg-slate-800/80">
                                    <tr>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Registration</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Make / model</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">In service</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">£/hr</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                                    @foreach ($aircraft as $plane)
                                        <tr>
                                            <td class="whitespace-nowrap px-4 py-3 font-mono font-medium text-slate-800 dark:text-slate-200">{{ $plane->registration }}</td>
                                            <td class="whitespace-nowrap px-4 py-3 text-slate-800 dark:text-slate-200">{{ $plane->make }} {{ $plane->model }}</td>
                                            <td class="whitespace-nowrap px-4 py-3 text-slate-600 dark:text-slate-400">{{ $plane->in_service ? 'Yes' : 'No' }}</td>
                                            <td class="whitespace-nowrap px-4 py-3 text-slate-800 dark:text-slate-200">£{{ number_format((float) $plane->rental_price_per_hour, 2) }}</td>
                                            <td class="whitespace-nowrap px-4 py-3">
                                                <div class="flex flex-wrap items-center gap-2">
                                                    <a href="{{ route('admin.aircraft.edit', $plane) }}" class="rounded-md bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-800 transition hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">Update</a>
                                                    <form method="post" action="{{ route('admin.aircraft.destroy', $plane) }}" class="inline" onsubmit="return confirm('Remove this aircraft from the fleet?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="rounded-md bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700 transition hover:bg-red-100 dark:bg-red-950/50 dark:text-red-300 dark:hover:bg-red-950">Remove</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </section>

                <section id="admin-instructors" class="mt-10 scroll-mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-8">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Instructors</h2>
                            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Directory used for bookings and the public instructors page.</p>
                        </div>
                        <a href="{{ route('admin.instructors.create') }}" class="inline-flex shrink-0 items-center justify-center rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700 dark:bg-sky-500 dark:hover:bg-sky-400">
                            Add instructor
                        </a>
                    </div>

                    @if ($instructors->isEmpty())
                        <p class="mt-6 text-sm text-slate-600 dark:text-slate-400">No instructors in the database.</p>
                    @else
                        <div class="mt-6 overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-800">
                            <table class="min-w-full divide-y divide-slate-200 text-left text-sm dark:divide-slate-800">
                                <thead class="bg-slate-50 dark:bg-slate-800/80">
                                    <tr>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Name</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Email</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Phone</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                                    @foreach ($instructors as $instructor)
                                        <tr>
                                            <td class="whitespace-nowrap px-4 py-3 text-slate-800 dark:text-slate-200">{{ trim($instructor->first_name.' '.$instructor->last_name) }}</td>
                                            <td class="whitespace-nowrap px-4 py-3 text-slate-600 dark:text-slate-400">{{ $instructor->email ?? '—' }}</td>
                                            <td class="whitespace-nowrap px-4 py-3 text-slate-600 dark:text-slate-400">{{ $instructor->phone ?? '—' }}</td>
                                            <td class="whitespace-nowrap px-4 py-3">
                                                <div class="flex flex-wrap items-center gap-2">
                                                    <a href="{{ route('admin.instructors.edit', $instructor) }}" class="rounded-md bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-800 transition hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">Update</a>
                                                    <form method="post" action="{{ route('admin.instructors.destroy', $instructor) }}" class="inline" onsubmit="return confirm('Remove this instructor?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="rounded-md bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700 transition hover:bg-red-100 dark:bg-red-950/50 dark:text-red-300 dark:hover:bg-red-950">Remove</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </section>
            @endif
        </div>
    </main>
@endsection
