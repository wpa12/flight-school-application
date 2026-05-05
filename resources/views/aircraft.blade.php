@extends('welcome')

@section('content')
    <main class="w-full">
        <section class="border-b border-slate-200/80 bg-linear-to-b from-sky-50 via-white to-white py-10 dark:border-slate-800 dark:from-slate-900 dark:via-slate-950 dark:to-slate-950 sm:py-12">
            <div class="mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
                <p class="text-sm font-semibold uppercase tracking-wider text-sky-600 dark:text-sky-400">Our fleet</p>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl dark:text-white">
                    Aircraft for training &amp; rental
                </h1>
                <p class="mx-auto mt-4 max-w-xl text-base leading-relaxed text-slate-600 dark:text-slate-400">
                    These are the aircraft we have in our fleet—each one maintained to our standards and available for dual instruction or qualified rental where applicable.
                </p>
            </div>
        </section>

        <section class="bg-white py-12 dark:bg-slate-950 sm:py-16" aria-label="Fleet listing">
            <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
                @if ($aircraft->isEmpty())
                    <p class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 py-12 text-center text-slate-600 dark:border-slate-700 dark:bg-slate-900/50 dark:text-slate-400">
                        No aircraft are listed in service yet. Check back soon.
                    </p>
                @else
                    <div class="flex flex-col gap-10 sm:gap-12 lg:gap-14">
                        @foreach ($aircraft as $plane)
                            <div class="flex {{ $loop->even ? 'lg:justify-end' : 'lg:justify-start' }}">
                                <article class="w-full max-w-xl overflow-hidden rounded-2xl border border-slate-200 bg-slate-50/80 shadow-sm ring-1 ring-slate-200/60 dark:border-slate-800 dark:bg-slate-900/60 dark:ring-slate-800/80 lg:max-w-2xl {{ $loop->even ? 'lg:translate-x-4 xl:translate-x-8' : 'lg:-translate-x-4 xl:-translate-x-8' }}">
                                    <div class="sm:flex sm:min-h-[220px] {{ $loop->even ? 'sm:flex-row-reverse' : '' }}">
                                        <div class="relative aspect-4/3 shrink-0 sm:w-2/5 sm:aspect-auto sm:min-h-[220px]">
                                            @if ($plane->image_url)
                                                <img src="{{ $plane->image_url }}" alt="{{ $plane->make }} {{ $plane->model }}" class="h-full w-full object-cover" loading="lazy" />
                                            @else
                                                <div class="flex h-full min-h-48 flex-col items-center justify-center bg-linear-to-br from-sky-600 to-slate-800 p-6 text-center sm:min-h-0 dark:from-sky-500 dark:to-slate-900">
                                                    <span class="text-xs font-medium uppercase tracking-widest text-sky-100/90">Registration</span>
                                                    <span class="mt-2 font-mono text-2xl font-bold tracking-tight text-white sm:text-3xl">{{ $plane->registration }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex flex-1 flex-col justify-center p-6 sm:p-7">
                                            <div class="flex flex-wrap items-baseline gap-x-2 gap-y-1">
                                                <h2 class="text-xl font-semibold text-slate-900 dark:text-white">
                                                    {{ $plane->make }} {{ $plane->model }}
                                                </h2>
                                                <span class="font-mono text-sm font-medium text-sky-600 dark:text-sky-400">{{ $plane->registration }}</span>
                                            </div>
                                            @if ($plane->type)
                                                <p class="mt-1 text-xs font-medium uppercase tracking-wide text-slate-500 dark:text-slate-500">
                                                    {{ \Illuminate\Support\Str::headline((string) $plane->type) }}
                                                </p>
                                            @endif
                                            @if ($plane->description)
                                                <p class="mt-3 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                                                    {{ $plane->description }}
                                                </p>
                                            @endif
                                            <dl class="mt-4 flex flex-wrap gap-x-6 gap-y-2 border-t border-slate-200 pt-4 text-sm dark:border-slate-700">
                                                <div>
                                                    <dt class="text-slate-500 dark:text-slate-500">Rental rate</dt>
                                                    <dd class="font-semibold text-slate-900 dark:text-white">
                                                        ${{ number_format((float) $plane->rental_price_per_hour, 2) }}<span class="font-normal text-slate-500 dark:text-slate-400">/hr</span>
                                                    </dd>
                                                </div>
                                                <div>
                                                    <dt class="text-slate-500 dark:text-slate-500">Hobbs / tach</dt>
                                                    <dd class="font-semibold text-slate-900 dark:text-white">
                                                        {{ number_format($plane->current_hours) }} hrs
                                                    </dd>
                                                </div>
                                            </dl>
                                            <a href="{{ route('aircraft.show', $plane) }}" class="mt-5 inline-flex items-center text-sm font-semibold text-sky-600 transition hover:text-sky-700 dark:text-sky-400 dark:hover:text-sky-300">
                                                View details
                                                <span class="ml-1" aria-hidden="true">→</span>
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection
