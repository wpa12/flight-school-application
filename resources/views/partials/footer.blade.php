<footer class="mt-auto w-full border-t border-slate-200 bg-slate-50 dark:border-slate-800 dark:bg-slate-950">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4 lg:gap-8">
            <div class="sm:col-span-2 lg:col-span-2">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2.5">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-sky-600 text-white shadow-sm ring-1 ring-sky-600/20 dark:bg-sky-500 dark:ring-sky-500/30" aria-hidden="true">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z" />
                        </svg>
                    </span>
                    <span class="text-lg font-semibold tracking-tight text-slate-900 dark:text-white">{{ config('app.name', 'Flight School') }}</span>
                </a>
                <p class="mt-4 max-w-md text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                    Professional flight training and aircraft rental. Build confidence in the air with experienced instructors and a well-maintained fleet.
                </p>
            </div>

            <div>
                <h2 class="text-sm font-semibold uppercase tracking-wider text-slate-900 dark:text-white">Explore</h2>
                <ul class="mt-4 space-y-3">
                    <li><a href="{{ url('/') }}" class="text-sm text-slate-600 transition hover:text-sky-600 dark:text-slate-400 dark:hover:text-sky-400">Home</a></li>
                    <li><a href="{{ url('/about') }}" class="text-sm text-slate-600 transition hover:text-sky-600 dark:text-slate-400 dark:hover:text-sky-400">About</a></li>
                    <li><a href="{{ url('/aircraft') }}" class="text-sm text-slate-600 transition hover:text-sky-600 dark:text-slate-400 dark:hover:text-sky-400">Aircraft</a></li>
                    <li><a href="{{ url('/exams') }}" class="text-sm text-slate-600 transition hover:text-sky-600 dark:text-slate-400 dark:hover:text-sky-400">Exams</a></li>
                </ul>
            </div>

            <div>
                <h2 class="text-sm font-semibold uppercase tracking-wider text-slate-900 dark:text-white">Contact</h2>
                <ul class="mt-4 space-y-3">
                    @php($contact = config('mail.from.address'))
                    @if ($contact)
                        <li>
                            <a href="mailto:{{ $contact }}" class="inline-flex items-center gap-2 text-sm text-slate-600 transition hover:text-sky-600 dark:text-slate-400 dark:hover:text-sky-400">
                                <svg class="h-4 w-4 shrink-0 text-sky-600 dark:text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ $contact }}
                            </a>
                        </li>
                    @else
                        <li class="text-sm text-slate-600 dark:text-slate-400">
                            <a href="{{ url('/about') }}" class="transition hover:text-sky-600 dark:hover:text-sky-400">Contact us</a>
                            <span class="text-slate-500 dark:text-slate-500"> — details on About.</span>
                        </li>
                    @endif
                    <li class="text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                        <span class="block font-medium text-slate-800 dark:text-slate-200">Hours</span>
                        Mon–Sat, 8:00–18:00
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-12 flex flex-col items-center justify-between gap-4 border-t border-slate-200 pt-8 sm:flex-row dark:border-slate-800">
            <p class="text-center text-sm text-slate-500 dark:text-slate-500 sm:text-left">
                &copy; {{ date('Y') }} {{ config('app.name', 'Flight School') }}. All rights reserved.
            </p>
            <nav class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2" aria-label="Legal">
                <a href="{{ url('/privacy') }}" class="text-sm text-slate-500 transition hover:text-sky-600 dark:text-slate-500 dark:hover:text-sky-400">Privacy</a>
                <a href="{{ url('/terms') }}" class="text-sm text-slate-500 transition hover:text-sky-600 dark:text-slate-500 dark:hover:text-sky-400">Terms</a>
            </nav>
        </div>
    </div>
</footer>
