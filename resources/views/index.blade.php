@extends('welcome')

@section('content')
    <main class="w-full">
        <section class="border-b border-slate-200/80 bg-linear-to-b from-sky-50 via-white to-white dark:border-slate-800 dark:from-slate-900 dark:via-slate-950 dark:to-slate-950">
            <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 sm:py-12 lg:px-8">
                <div class="max-w-2xl">
                    <p class="text-sm font-semibold uppercase tracking-wider text-sky-600 dark:text-sky-400">Welcome</p>
                    <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl dark:text-white">
                        Train with us. Fly on your terms.
                    </h1>
                    <p class="mt-3 text-base leading-relaxed text-slate-600 dark:text-slate-400">
                        From your first lesson to checkrides and beyond, we help you schedule training, rent aircraft, and stay exam-ready—all in one place.
                    </p>
                    <div class="mt-6 flex flex-wrap items-center gap-3">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-lg bg-sky-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-500 focus-visible:ring-offset-2 dark:bg-sky-500 dark:hover:bg-sky-400 dark:focus-visible:ring-offset-slate-950">
                                Sign up
                            </a>
                        @endif
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" @class([
                                'inline-flex items-center justify-center rounded-lg border px-5 py-2.5 text-sm font-semibold shadow-sm transition focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-500 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-slate-950',
                                'border-slate-300 bg-white text-slate-800 hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-900 dark:text-white dark:hover:bg-slate-800' => Route::has('register'),
                                'bg-sky-600 text-white hover:bg-sky-700 focus-visible:ring-sky-500 dark:bg-sky-500 dark:hover:bg-sky-400' => ! Route::has('register'),
                            ])>
                                Log in
                            </a>
                        @else
                            <a href="{{ url('/login') }}" class="inline-flex items-center justify-center rounded-lg bg-sky-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-500 focus-visible:ring-offset-2 dark:bg-sky-500 dark:hover:bg-sky-400 dark:focus-visible:ring-offset-slate-950">
                                Log in
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <section class="border-b border-slate-200 bg-white py-14 dark:border-slate-800 dark:bg-slate-950" aria-labelledby="about-heading">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl">
                    <h2 id="about-heading" class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-white">
                        What you can do here
                    </h2>
                    <p class="mt-2 text-slate-600 dark:text-slate-400">
                        Whether you are starting from zero or adding ratings, here is how we support you on the ground and in the air.
                    </p>
                </div>

                <div class="mt-10 grid gap-8 lg:grid-cols-3">
                    <article class="rounded-2xl border border-slate-200 bg-slate-50/80 p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900/50">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-sky-600 text-white dark:bg-sky-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-slate-900 dark:text-white">Aircraft rental</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                            Fly our well-maintained fleet for proficiency flights, cross-country trips, or time-building. Rental is subject to checkout and currency requirements; our team will walk you through scheduling, insurance, and billing before you book.
                        </p>
                    </article>

                    <article class="rounded-2xl border border-slate-200 bg-slate-50/80 p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900/50">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-sky-600 text-white dark:bg-sky-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-slate-900 dark:text-white">Lessons &amp; exams</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                            Book dual instruction that fits your calendar, from private through advanced training. When you are ready, we help you schedule stage checks, mock orals, and practical tests so you arrive prepared and confident on exam day.
                        </p>
                    </article>

                    <article class="rounded-2xl border border-slate-200 bg-slate-50/80 p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900/50">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-sky-600 text-white dark:bg-sky-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-slate-900 dark:text-white">Visit &amp; contact</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                            Questions about training, rentals, or exams? Reach us during office hours or stop by the school.
                        </p>
                        <address class="mt-4 not-italic text-sm leading-relaxed text-slate-700 dark:text-slate-300">
                            <span class="font-medium text-slate-900 dark:text-white">{{ config('app.name', 'Flight School') }}</span><br />
                            Hangar 2, Regional Airport<br />
                            1420 Runway Drive<br />
                            Midfield, ST 78201
                        </address>
                        <ul class="mt-4 space-y-2 text-sm text-slate-600 dark:text-slate-400">
                            <li>
                                <span class="font-medium text-slate-800 dark:text-slate-200">Phone</span><br />
                                <a href="tel:+15555550123" class="transition hover:text-sky-600 dark:hover:text-sky-400">(555) 555-0123</a>
                            </li>
                            @if (config('mail.from.address'))
                                <li>
                                    <span class="font-medium text-slate-800 dark:text-slate-200">Email</span><br />
                                    <a href="mailto:{{ config('mail.from.address') }}" class="transition hover:text-sky-600 dark:hover:text-sky-400">{{ config('mail.from.address') }}</a>
                                </li>
                            @endif
                            <li>
                                <span class="font-medium text-slate-800 dark:text-slate-200">Hours</span><br />
                                Monday–Saturday, 8:00 a.m. – 6:00 p.m.
                            </li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>
    </main>
@endsection
