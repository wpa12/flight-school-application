<header class="w-full border-b border-slate-200/80 bg-white/90 shadow-sm backdrop-blur-md dark:border-slate-800 dark:bg-slate-950/90">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
        <a href="{{ url('/') }}" class="group flex shrink-0 items-center gap-2.5">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-sky-600 text-white shadow-sm ring-1 ring-sky-600/20 transition group-hover:bg-sky-700 dark:bg-sky-500 dark:ring-sky-500/30 dark:group-hover:bg-sky-400" aria-hidden="true">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z" />
                </svg>
            </span>
            <span class="text-lg font-semibold tracking-tight text-slate-900 dark:text-white">
                {{ config('app.name', 'Flight School') }}
            </span>
        </a>

        <nav class="hidden items-center gap-1 md:flex" aria-label="Main">
            <a href="{{ url('/') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white">Home</a>
            <a href="{{ url('/about') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white">About</a>
            <a href="{{ url('/aircraft') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white">Aircraft</a>
            <a href="{{ url('/exams') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white">Exams</a>
        </nav>

        <div class="hidden items-center gap-3 md:flex">
            <a href="{{ url('/login') }}" class="inline-flex items-center justify-center rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-500 focus-visible:ring-offset-2 dark:bg-sky-500 dark:hover:bg-sky-400 dark:focus-visible:ring-offset-slate-950">
                Login
            </a>
            <a href="{{ url('/register') }}" class="inline-flex items-center justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-sky-600 shadow-sm transition hover:bg-slate-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-500 focus-visible:ring-offset-2 dark:bg-slate-900 dark:hover:bg-slate-800 dark:focus-visible:ring-offset-slate-950">
                Register
            </a>
        </div>

        <details class="relative md:hidden">
            <summary class="list-none [&::-webkit-details-marker]:hidden">
                <span class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-200 bg-white p-2 text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
                    <span class="sr-only">Open menu</span>
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </span>
            </summary>
            <div class="absolute right-0 z-50 mt-2 w-52 origin-top-right rounded-xl border border-slate-200 bg-white p-2 shadow-lg dark:border-slate-700 dark:bg-slate-900">
                <nav class="flex flex-col gap-0.5" aria-label="Mobile main">
                    <a href="{{ url('/') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">Home</a>
                    <a href="{{ url('/about') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">About</a>
                    <a href="{{ url('/aircraft') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">Aircraft</a>
                    <hr class="my-1 border-slate-200 dark:border-slate-700" />
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="rounded-lg bg-sky-600 px-3 py-2.5 text-center text-sm font-semibold text-white hover:bg-sky-700 dark:bg-sky-500 dark:hover:bg-sky-400">Login</a>
                    @else
                        <a href="{{ url('/login') }}" class="rounded-lg bg-sky-600 px-3 py-2.5 text-center text-sm font-semibold text-white hover:bg-sky-700 dark:bg-sky-500 dark:hover:bg-sky-400">Login</a>
                    @endif
                </nav>
            </div>
        </details>
    </div>
</header>
