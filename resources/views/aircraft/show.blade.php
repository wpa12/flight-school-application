@extends('welcome')

@section('content')
    <main class="w-full">
        <section class="border-b border-slate-200/80 bg-linear-to-b from-sky-50 via-white to-white py-8 dark:border-slate-800 dark:from-slate-900 dark:via-slate-950 dark:to-slate-950 sm:py-10">
            <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
                <nav class="text-sm text-slate-600 dark:text-slate-400" aria-label="Breadcrumb">
                    <a href="{{ route('dashboard.index') . '#aircraft' }}" class="font-medium text-sky-600 transition hover:text-sky-700 dark:text-sky-400 dark:hover:text-sky-300">Fleet</a>
                    <span class="mx-2 text-slate-400" aria-hidden="true">/</span>
                    <span class="font-mono text-slate-900 dark:text-white">{{ $aircraft->registration }}</span>
                </nav>
                <h1 class="mt-3 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl dark:text-white">
                    {{ $aircraft->make }} {{ $aircraft->model }}
                </h1>
                @if (session('status'))
                    <p class="mt-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 dark:border-emerald-900/60 dark:bg-emerald-950/40 dark:text-emerald-200" role="status">
                        {{ session('status') }}
                    </p>
                @endif
            </div>
        </section>

        <section class="bg-white py-10 dark:bg-slate-950 sm:py-14" aria-label="Aircraft details">
            <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
                <article class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50/80 shadow-sm ring-1 ring-slate-200/60 dark:border-slate-800 dark:bg-slate-900/60 dark:ring-slate-800/80">
                    <div class="lg:flex lg:min-h-[320px]">
                        <div class="relative aspect-4/3 shrink-0 lg:w-2/5 lg:aspect-auto lg:min-h-[320px]">
                            @if ($aircraft->image_url)
                                <img src="{{ $aircraft->image_url }}" alt="{{ $aircraft->make }} {{ $aircraft->model }}" class="h-full w-full object-cover" loading="lazy" />
                            @else
                                <div class="flex h-full min-h-56 flex-col items-center justify-center bg-linear-to-br from-sky-600 to-slate-800 p-8 text-center lg:min-h-0 dark:from-sky-500 dark:to-slate-900">
                                    <span class="text-xs font-medium uppercase tracking-widest text-sky-100/90">Registration</span>
                                    <span class="mt-2 font-mono text-3xl font-bold tracking-tight text-white sm:text-4xl">{{ $aircraft->registration }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-1 flex-col p-6 sm:p-8 lg:justify-center">
                            <div class="flex flex-wrap items-baseline gap-x-2 gap-y-1">
                                <h2 class="text-xl font-semibold text-slate-900 dark:text-white">
                                    {{ $aircraft->make }} {{ $aircraft->model }}
                                </h2>
                                <span class="font-mono text-sm font-medium text-sky-600 dark:text-sky-400">{{ $aircraft->registration }}</span>
                            </div>
                            @if ($aircraft->type)
                                <p class="mt-1 text-xs font-medium uppercase tracking-wide text-slate-500 dark:text-slate-500">
                                    {{ \Illuminate\Support\Str::headline((string) $aircraft->type) }}
                                </p>
                            @endif
                            @if ($aircraft->description)
                                <p class="mt-4 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                                    {{ $aircraft->description }}
                                </p>
                            @endif
                            <dl class="mt-6 grid gap-4 border-t border-slate-200 pt-6 text-sm dark:border-slate-700 sm:grid-cols-2">
                                <div>
                                    <dt class="text-slate-500 dark:text-slate-500">Rental rate</dt>
                                    <dd class="mt-0.5 font-semibold text-slate-900 dark:text-white">
                                        £{{ number_format((float) $aircraft->rental_price_per_hour, 2) }}<span class="font-normal text-slate-500 dark:text-slate-400">/hr</span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-slate-500 dark:text-slate-500">Hobbs / tach</dt>
                                    <dd class="mt-0.5 font-semibold text-slate-900 dark:text-white">
                                        {{ number_format($aircraft->current_hours) }} hrs
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-slate-500 dark:text-slate-500">In service</dt>
                                    <dd class="mt-0.5 font-semibold text-slate-900 dark:text-white">
                                        {{ $aircraft->in_service ? 'Yes' : 'No' }}
                                    </dd>
                                </div>
                                @if ($aircraft->engineType)
                                    <div>
                                        <dt class="text-slate-500 dark:text-slate-500">Engine</dt>
                                        <dd class="mt-0.5 font-semibold text-slate-900 dark:text-white">
                                            {{ \Illuminate\Support\Str::headline((string) $aircraft->engineType->type) }}
                                        </dd>
                                    </div>
                                @endif
                                @if ($aircraft->fuelType)
                                    <div class="sm:col-span-2">
                                        <dt class="text-slate-500 dark:text-slate-500">Fuel</dt>
                                        <dd class="mt-0.5 font-semibold text-slate-900 dark:text-white">
                                            {{ \Illuminate\Support\Str::headline((string) $aircraft->fuelType->type) }}
                                        </dd>
                                    </div>
                                @endif
                            </dl>

                            @auth
                                @if (auth()->user()->is_admin)
                                    <div class="mt-8 flex flex-wrap items-center gap-3 border-t border-slate-200 pt-6 dark:border-slate-700">
                                        <a href="{{ route('dashboard.aircraft.edit', $aircraft) }}" class="inline-flex items-center justify-center rounded-lg bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700 dark:bg-sky-500 dark:hover:bg-sky-400">
                                            Edit aircraft
                                        </a>
                                        <form method="post" action="{{ route('dashboard.aircraft.delete', $aircraft) }}" class="inline" onsubmit="return confirm('Remove this aircraft from the fleet? This cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center rounded-lg border border-red-200 bg-white px-4 py-2.5 text-sm font-semibold text-red-700 shadow-sm transition hover:bg-red-50 dark:border-red-900/50 dark:bg-slate-900 dark:text-red-300 dark:hover:bg-red-950/40">
                                                Delete aircraft
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </article>
            </div>
        </section>
    </main>
@endsection
