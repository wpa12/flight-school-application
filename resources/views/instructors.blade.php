@extends('welcome')

@section('content')
    <main class="w-full">
        <section class="border-b border-slate-200/80 bg-linear-to-b from-sky-50 via-white to-white py-10 dark:border-slate-800 dark:from-slate-900 dark:via-slate-950 dark:to-slate-950 sm:py-12">
            <div class="mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
                <p class="text-sm font-semibold uppercase tracking-wider text-sky-600 dark:text-sky-400">Our team</p>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl dark:text-white">
                    Instructors
                </h1>
                <p class="mx-auto mt-4 max-w-2xl text-base leading-relaxed text-slate-600 dark:text-slate-400">
                    These are the certificated flight instructors who teach at {{ config('app.name', 'our school') }}. Each brings real-world experience and a commitment to safe, structured training from first flight through advanced ratings.
                </p>
            </div>
        </section>

        <section class="bg-white py-14 dark:bg-slate-950" aria-labelledby="instructors-list-heading">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 id="instructors-list-heading" class="sr-only">Instructor directory</h2>

                @if ($instructors->isEmpty())
                    <p class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 py-12 text-center text-slate-600 dark:border-slate-700 dark:bg-slate-900/50 dark:text-slate-400">
                        Instructor profiles will appear here once they are added.
                    </p>
                @else
                    <ul class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($instructors as $instructor)
                            @php
                                $fullName = trim($instructor->first_name.' '.$instructor->last_name);
                                $initials = strtoupper(
                                    mb_substr((string) $instructor->first_name, 0, 1).mb_substr((string) $instructor->last_name, 0, 1)
                                );
                            @endphp
                            <li>
                                <article class="flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-slate-50/80 shadow-sm ring-1 ring-slate-200/60 dark:border-slate-800 dark:bg-slate-900/60 dark:ring-slate-800/80">
                                    <div class="flex flex-1 flex-col items-center px-6 pb-6 pt-8 text-center">
                                        @if ($instructor->image_url)
                                            <img
                                                src="{{ $instructor->image_url }}"
                                                alt="{{ $fullName !== '' ? $fullName : 'Instructor' }}"
                                                class="h-28 w-28 rounded-full object-cover ring-4 ring-white dark:ring-slate-900"
                                                loading="lazy"
                                            />
                                        @else
                                            <div class="flex h-28 w-28 items-center justify-center rounded-full bg-linear-to-br from-sky-600 to-slate-700 text-2xl font-bold tracking-tight text-white ring-4 ring-white dark:from-sky-500 dark:to-slate-900 dark:ring-slate-900" aria-hidden="true">
                                                {{ $initials !== '' ? $initials : '?' }}
                                            </div>
                                        @endif

                                        <h3 class="mt-5 text-lg font-semibold text-slate-900 dark:text-white">
                                            {{ $fullName !== '' ? $fullName : 'Instructor' }}
                                        </h3>

                                        <dl class="mt-4 w-full space-y-3 text-left text-sm">
                                            @if ($instructor->email)
                                                <div class="flex gap-3 rounded-lg bg-white/80 px-3 py-2 dark:bg-slate-800/80">
                                                    <dt class="sr-only">Email</dt>
                                                    <dd class="flex min-w-0 flex-1 items-start gap-2">
                                                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-sky-600 dark:text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                        </svg>
                                                        <a href="mailto:{{ $instructor->email }}" class="min-w-0 truncate font-medium text-slate-700 transition hover:text-sky-600 dark:text-slate-200 dark:hover:text-sky-400">
                                                            {{ $instructor->email }}
                                                        </a>
                                                    </dd>
                                                </div>
                                            @endif
                                            @if ($instructor->phone)
                                                <div class="flex gap-3 rounded-lg bg-white/80 px-3 py-2 dark:bg-slate-800/80">
                                                    <dt class="sr-only">Phone</dt>
                                                    <dd class="flex min-w-0 flex-1 items-start gap-2">
                                                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-sky-600 dark:text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                        </svg>
                                                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $instructor->phone) }}" class="min-w-0 font-medium text-slate-700 transition hover:text-sky-600 dark:text-slate-200 dark:hover:text-sky-400">
                                                            {{ $instructor->phone }}
                                                        </a>
                                                    </dd>
                                                </div>
                                            @endif
                                        </dl>
                                    </div>
                                </article>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </section>
    </main>
@endsection
