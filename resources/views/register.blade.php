@extends('welcome')

@section('content')
    <main class="flex w-full flex-1 justify-center px-4 py-12 sm:px-6 sm:py-16 lg:px-8">
        <div class="w-full max-w-md">
            <div class="text-center">
                <h1 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-white">Create an account</h1>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                    Join {{ config('app.name', 'the school') }} to book lessons and manage your training.
                </p>
            </div>

            <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-8">
                <form method="post" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Full name</label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            autocomplete="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            maxlength="40"
                            class="mt-1.5 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 shadow-sm outline-none transition focus:border-sky-500 focus:ring-2 focus:ring-sky-500/30 dark:border-slate-600 dark:bg-slate-950 dark:text-white dark:focus:border-sky-400 dark:focus:ring-sky-400/30 @error('name') border-red-500 focus:border-red-500 focus:ring-red-500/30 dark:border-red-500 @enderror"
                            placeholder="Jane Pilot"
                        />
                        @error('name')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            autocomplete="email"
                            value="{{ old('email') }}"
                            required
                            class="mt-1.5 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 shadow-sm outline-none transition focus:border-sky-500 focus:ring-2 focus:ring-sky-500/30 dark:border-slate-600 dark:bg-slate-950 dark:text-white dark:focus:border-sky-400 dark:focus:ring-sky-400/30 @error('email') border-red-500 focus:border-red-500 focus:ring-red-500/30 dark:border-red-500 @enderror"
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
                            autocomplete="new-password"
                            required
                            class="mt-1.5 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 shadow-sm outline-none transition focus:border-sky-500 focus:ring-2 focus:ring-sky-500/30 dark:border-slate-600 dark:bg-slate-950 dark:text-white dark:focus:border-sky-400 dark:focus:ring-sky-400/30 @error('password') border-red-500 focus:border-red-500 focus:ring-red-500/30 dark:border-red-500 @enderror"
                        />
                        @error('password')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-500">At least 5 characters.</p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Confirm password</label>
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            autocomplete="new-password"
                            required
                            class="mt-1.5 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 shadow-sm outline-none transition focus:border-sky-500 focus:ring-2 focus:ring-sky-500/30 dark:border-slate-600 dark:bg-slate-950 dark:text-white dark:focus:border-sky-400 dark:focus:ring-sky-400/30"
                        />
                    </div>

                    <button type="submit" class="flex w-full justify-center rounded-lg bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-500 focus-visible:ring-offset-2 dark:bg-sky-500 dark:hover:bg-sky-400 dark:focus-visible:ring-offset-slate-950">
                        Register
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-slate-600 dark:text-slate-400">
                    Already registered?
                    <a href="{{ route('login') }}" class="font-medium text-sky-600 underline-offset-2 hover:underline dark:text-sky-400">Sign in</a>
                </p>
            </div>
        </div>
    </main>
@endsection
