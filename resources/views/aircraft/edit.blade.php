@extends('welcome')

@section('content')
    <main class="w-full">
        <section class="border-b border-slate-200/80 bg-linear-to-b from-sky-50 via-white to-white py-8 dark:border-slate-800 dark:from-slate-900 dark:via-slate-950 dark:to-slate-950 sm:py-10">
            <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                <nav class="text-sm text-slate-600 dark:text-slate-400" aria-label="Breadcrumb">
                    <a href="{{ route('dashboard.index') . '#aircraft' }}" class="font-medium text-sky-600 transition hover:text-sky-700 dark:text-sky-400 dark:hover:text-sky-300">Fleet</a>
                    <span class="mx-2 text-slate-400" aria-hidden="true">/</span>
                    <a href="{{ route('dashboard.aircraft.show', $aircraft) }}" class="font-medium text-sky-600 transition hover:text-sky-700 dark:text-sky-400 dark:hover:text-sky-300">{{ $aircraft->registration }}</a>
                    <span class="mx-2 text-slate-400" aria-hidden="true">/</span>
                    <span class="text-slate-900 dark:text-white">Edit</span>
                </nav>
                <h1 class="mt-3 text-2xl font-semibold tracking-tight text-slate-900 dark:text-white">Edit aircraft</h1>
            </div>
        </section>

        <section class="bg-white py-10 dark:bg-slate-950 sm:py-12">
            <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                <form method="post" action="{{ route('dashboard.aircraft.update', $aircraft) }}" class="space-y-5 rounded-2xl border border-slate-200 bg-slate-50/80 p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900/60 sm:p-8">
                    @csrf
                    @method('PUT')

                    @if ($errors->any())
                        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 dark:border-red-900/50 dark:bg-red-950/40 dark:text-red-200" role="alert">
                            <ul class="list-inside list-disc space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <label for="type" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Type</label>
                        <select id="type" name="type" required class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 dark:border-slate-600 dark:bg-slate-900 dark:text-white">
                            @foreach ($aircraftTypes as $type)
                                <option value="{{ $type->value }}" @selected(old('type', $aircraft->type) == $type->value)>
                                    {{ $type->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="make" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Make</label>
                            <input id="make" name="make" type="text" value="{{ old('make', $aircraft->make) }}" required class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 dark:border-slate-600 dark:bg-slate-900 dark:text-white" />
                        </div>
                        <div>
                            <label for="model" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Model</label>
                            <input id="model" name="model" type="text" value="{{ old('model', $aircraft->model) }}" required class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 dark:border-slate-600 dark:bg-slate-900 dark:text-white" />
                        </div>
                    </div>
                    <div>
                        <label for="registration" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Registration</label>
                        <input id="registration" name="registration" type="text" value="{{ old('registration', $aircraft->registration) }}" required class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 font-mono text-sm text-slate-900 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 dark:border-slate-600 dark:bg-slate-900 dark:text-white" />
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Description</label>
                        <textarea id="description" name="description" rows="3" required class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 dark:border-slate-600 dark:bg-slate-900 dark:text-white">{{ old('description', $aircraft->description) }}</textarea>
                    </div>
                    {{-- <div>
                        <label for="engine_type_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Engine type</label>
                        <select id="engine_type_id" name="engine_type_id" required class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 dark:border-slate-600 dark:bg-slate-900 dark:text-white">
                            @foreach ($engineTypes as $et)
                                <option value="{{ $et->id }}" @selected((string) old('engine_type_id', $aircraft->engine_type_id) === (string) $et->id)>
                                    {{ \Illuminate\Support\Str::headline((string) $et->type) }}
                                </option>
                            @endforeach
                        </select>
                    </div> --}}
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="rental_price_per_hour" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Rental price / hour</label>
                            <input id="rental_price_per_hour" name="rental_price_per_hour" type="number" step="0.01" min="0" max="1000" value="{{ old('rental_price_per_hour', $aircraft->rental_price_per_hour) }}" required class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 dark:border-slate-600 dark:bg-slate-900 dark:text-white" />
                        </div>
                        <div>
                            <label for="current_hours" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Current hours</label>
                            <input id="current_hours" name="current_hours" type="number" min="0" max="20000" value="{{ old('current_hours', $aircraft->current_hours) }}" required class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 dark:border-slate-600 dark:bg-slate-900 dark:text-white" />
                        </div>
                    </div>
                    <div>
                        <label for="image_url" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Image URL</label>
                        <input id="image_url" name="image_url" type="url" value="{{ old('image_url', $aircraft->image_url) }}" class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 dark:border-slate-600 dark:bg-slate-900 dark:text-white" placeholder="https://…" />
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="hidden" name="in_service" value="0" />
                        <input id="in_service" name="in_service" type="checkbox" value="1" class="size-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500 dark:border-slate-600 dark:bg-slate-900" @checked((string) old('in_service', $aircraft->in_service ? '1' : '0') === '1') />
                        <label for="in_service" class="text-sm font-medium text-slate-700 dark:text-slate-300">In service</label>
                    </div>
                    <div class="flex flex-wrap gap-3 pt-2">
                        <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700 dark:bg-sky-500 dark:hover:bg-sky-400">
                            Save changes
                        </button>
                        <a href="{{ route('dashboard.aircraft.show', $aircraft) }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </section>
    </main>
@endsection
