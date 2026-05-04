@extends('welcome')

@section('content')
    <main class="w-full">
        <section class="border-b border-slate-200/80 bg-linear-to-b from-sky-50 via-white to-white py-10 dark:border-slate-800 dark:from-slate-900 dark:via-slate-950 dark:to-slate-950 sm:py-12">
            <div class="mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
                <p class="text-sm font-semibold uppercase tracking-wider text-sky-600 dark:text-sky-400">Exams</p>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl dark:text-white">
                    Checkrides &amp; practical tests
                </h1>
                <p class="mx-auto mt-4 max-w-2xl text-base leading-relaxed text-slate-600 dark:text-slate-400">
                    We help you schedule stage checks, mock orals, and practical tests so you are prepared and confident. Your instructor and chief pilot team will guide eligibility, paperwork, and aircraft selection.
                </p>
            </div>
        </section>

        <section class="border-b border-slate-200 bg-white py-14 dark:border-slate-800 dark:bg-slate-950" aria-labelledby="exam-types-heading">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl">
                    <h2 id="exam-types-heading" class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-white">
                        What we support
                    </h2>
                    <p class="mt-2 text-slate-600 dark:text-slate-400">
                        From first solo through advanced ratings, we coordinate exam events with DPEs and your training schedule.
                    </p>
                </div>

                <ul class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <li class="rounded-2xl border border-slate-200 bg-slate-50/80 p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900/50">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-sky-600 text-white dark:bg-sky-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-slate-900 dark:text-white">Practical tests</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                            Private, instrument, commercial, multi-engine, CFI, and other practical tests arranged with designated examiners when you meet ACS standards and endorsements are complete.
                        </p>
                    </li>
                    <li class="rounded-2xl border border-slate-200 bg-slate-50/80 p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900/50">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-sky-600 text-white dark:bg-sky-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-slate-900 dark:text-white">Knowledge &amp; stage checks</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                            We help you plan written knowledge tests and syllabus stage checks so gaps are caught early—before you commit to a practical test date.
                        </p>
                    </li>
                    <li class="rounded-2xl border border-slate-200 bg-slate-50/80 p-6 shadow-sm sm:col-span-2 lg:col-span-1 dark:border-slate-800 dark:bg-slate-900/50">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-sky-600 text-white dark:bg-sky-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-slate-900 dark:text-white">Scheduling &amp; fees</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                            Exam slots depend on examiner availability and aircraft. Exam and aircraft fees are quoted when you book; payment and cancellation policies are explained up front.
                        </p>
                    </li>
                </ul>
            </div>
        </section>

        <section class="bg-slate-50 py-14 dark:bg-slate-900/40" aria-labelledby="exam-prep-heading">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 id="exam-prep-heading" class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-white">
                    Before your test day
                </h2>
                <ol class="mt-8 space-y-6 border-l-2 border-sky-200 pl-6 dark:border-sky-800">
                    <li class="relative">
                        <p class="font-medium text-slate-900 dark:text-white">Confirm endorsements &amp; experience</p>
                        <p class="mt-1 text-sm text-slate-600 dark:text-slate-700">Logbook, IACRA or equivalent, and training records reviewed with your instructor.</p>
                    </li>
                    <li class="relative">
                        <p class="font-medium text-slate-900 dark:text-white">Mock oral &amp; flight</p>
                        <p class="mt-1 text-sm text-slate-600 dark:text-slate-700">Schedule a dress rehearsal to identify weak areas before the examiner arrives.</p>
                    </li>
                    <li class="relative">
                        <p class="font-medium text-slate-900 dark:text-white">Aircraft &amp; weather plan</p>
                        <p class="mt-1 text-sm text-slate-600 dark:text-slate-700">Reserve the training aircraft and build a realistic backup plan for weather or maintenance delays.</p>
                    </li>
                </ol>

                <div class="mt-10 flex flex-wrap gap-3">
                    <a href="{{ url('/about') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-800 shadow-sm transition hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-900 dark:text-white dark:hover:bg-slate-800">
                        Contact the school
                    </a>
                    <a href="{{ url('/login') }}" class="inline-flex items-center justify-center rounded-lg bg-sky-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700 dark:bg-sky-500 dark:hover:bg-sky-400">
                        Log in to book
                    </a>
                </div>
            </div>
        </section>
    </main>
@endsection
