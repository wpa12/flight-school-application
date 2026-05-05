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

            @if ($isAdmin)
                <nav class="mb-8 flex flex-wrap gap-2 text-sm" aria-label="Admin sections">
                    <a href="#bookings" class="rounded-lg bg-white px-3 py-1.5 font-medium text-slate-700 shadow-sm ring-1 ring-slate-200 transition hover:bg-slate-50 dark:bg-slate-900 dark:text-slate-200 dark:ring-slate-700 dark:hover:bg-slate-800">Bookings</a>
                    <a href="#users" class="rounded-lg bg-white px-3 py-1.5 font-medium text-slate-700 shadow-sm ring-1 ring-slate-200 transition hover:bg-slate-50 dark:bg-slate-900 dark:text-slate-200 dark:ring-slate-700 dark:hover:bg-slate-800">Users</a>
                    <a href="#aircraft" class="rounded-lg bg-white px-3 py-1.5 font-medium text-slate-700 shadow-sm ring-1 ring-slate-200 transition hover:bg-slate-50 dark:bg-slate-900 dark:text-slate-200 dark:ring-slate-700 dark:hover:bg-slate-800">Aircraft</a>
                    <a href="#instructors" class="rounded-lg bg-white px-3 py-1.5 font-medium text-slate-700 shadow-sm ring-1 ring-slate-200 transition hover:bg-slate-50 dark:bg-slate-900 dark:text-slate-200 dark:ring-slate-700 dark:hover:bg-slate-800">Instructors</a>
                </nav>
            @endif

            @include('dashboard.bookings')

            @if ($isAdmin)
                @include('dashboard.users')
            @endif

            @include('dashboard.aircraft')

            @include('dashboard.instructors')
        </div>
    </main>
@endsection
