@extends('welcome')

@section('content')
    <main class="flex w-full flex-1 justify-center px-4 py-12 sm:px-6 sm:py-16 lg:px-8 min-h-max">
        <div class="w-full max-w-md">
            <div class="text-center">
                <h1 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-white">Sign in</h1>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                    Access your training schedule and account.
                </p>
            </div>

            <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-8">
                @if (session('status'))
                    <p class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:border-emerald-900/50 dark:bg-emerald-950/40 dark:text-emerald-200" role="status">
                        {{ session('status') }}
                    </p>
                @endif

                <form method="post" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            autocomplete="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            class="mt-1.5 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/30 dark:border-slate-600 dark:bg-slate-950 dark:text-white dark:focus:border-sky-400 dark:focus:ring-sky-400/30 @error('email') border-red-500 focus:border-red-500 focus:ring-red-500/30 dark:border-red-500 @enderror"
                            placeholder="you@example.com"
                        />
                        @error('email')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="current-password"
                            required
                            class="mt-1.5 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 shadow-sm outline-none transition focus:border-sky-500 focus:ring-2 focus:ring-sky-500/30 dark:border-slate-600 dark:bg-slate-950 dark:text-white dark:focus:border-sky-400 dark:focus:ring-sky-400/30 @error('password') border-red-500 focus:border-red-500 focus:ring-red-500/30 dark:border-red-500 @enderror"
                        />
                        @error('password')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between gap-4">
                        <label class="flex cursor-pointer items-center gap-2">
                            <input type="checkbox" name="remember" value="1" class="size-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500 dark:border-slate-600 dark:bg-slate-950 dark:focus:ring-sky-400" @checked(old('remember')) />
                            <span class="text-sm text-slate-600 dark:text-slate-400">Remember me</span>
                        </label>
                    </div>

                    <button type="submit" class="flex w-full justify-center rounded-lg bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-500 focus-visible:ring-offset-2 dark:bg-sky-500 dark:hover:bg-sky-400 dark:focus-visible:ring-offset-slate-950">
                        Sign in
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-slate-600 dark:text-slate-400">
                    No account?
                    <a href="{{ route('register') }}" class="font-medium text-sky-600 underline-offset-2 hover:underline dark:text-sky-400">Create one</a>
                </p>
            </div>
        </div>
    </main>
@endsection
