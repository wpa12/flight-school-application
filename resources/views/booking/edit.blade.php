@extends('welcome')
@section('content')
    <main class="w-full">
        <section class="border-b border-slate-200/80 bg-linear-to-b from-sky-50 via-white to-white py-10 dark:border-slate-800 dark:from-slate-900 dark:via-slate-950 dark:to-slate-950 sm:py-12">
            <div class="mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
                <p class="text-sm font-semibold uppercase tracking-wider text-sky-600 dark:text-sky-400">Manage</p>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl dark:text-white">
                    Edit Booking
                </h1>
                <p class="mx-auto mt-4 max-w-xl text-base leading-relaxed text-slate-600 dark:text-slate-400">
                    Update your booking details below.
                </p>
            </div>
        </section>

        <section class="bg-white py-12 dark:bg-slate-950 sm:py-16">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <form
                    x-data="{
                        bookableType: '{{ $bookableType }}',
                        aircraftId: '{{ $bookableType === 'aircraft' ? $booking->bookable_id : ($bookableType === 'lesson' ? $booking->bookable?->aircraft_id : '') }}',
                        instructorId: '{{ $booking->instructor_id ?? '' }}',
                        examType: '{{ $bookableType === 'exam' ? $booking->bookable_id : '' }}',
                        startDate: '{{ $booking->booking_date_time_start?->format('Y-m-d') }}',
                        startTime: '{{ $booking->booking_date_time_start?->format('H:i') }}',
                        endDate: '{{ $booking->booking_date_time_end?->format('Y-m-d') }}',
                        endTime: '{{ $booking->booking_date_time_end?->format('H:i') }}',
                        notes: '{{ addslashes($booking->notes ?? '') }}',

                        get isAircraft() { return this.bookableType === 'aircraft' },
                        get isLesson() { return this.bookableType === 'lesson' },
                        get isExam() { return this.bookableType === 'exam' },
                        get hasTypeSelected() { return this.bookableType !== '' },

                        resetTypeFields() {
                            this.aircraftId = '';
                            this.instructorId = '';
                            this.examType = '';
                        }
                    }"
                    action="{{ route('dashboard.bookings.update', $booking) }}"
                    method="POST"
                    class="space-y-8"
                >
                    @csrf
                    @method('PUT')

                    {{-- Booking Status Banner --}}
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/80 p-6 shadow-sm ring-1 ring-slate-200/60 dark:border-slate-800 dark:bg-slate-900/60 dark:ring-slate-800/80">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Booking Status</h2>
                                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                                    Reference: #{{ $booking->id }} &bull; Created {{ $booking->created_at->format('M j, Y') }}
                                </p>
                            </div>
                            <div>
                                @php
                                    $statusColors = match ($booking->booking_status) {
                                        'confirmed' => 'bg-green-100 text-green-800 ring-green-600/20 dark:bg-green-900/30 dark:text-green-400 dark:ring-green-400/30',
                                        'pending' => 'bg-yellow-100 text-yellow-800 ring-yellow-600/20 dark:bg-yellow-900/30 dark:text-yellow-400 dark:ring-yellow-400/30',
                                        'cancelled' => 'bg-red-100 text-red-800 ring-red-600/20 dark:bg-red-900/30 dark:text-red-400 dark:ring-red-400/30',
                                        'completed' => 'bg-slate-100 text-slate-800 ring-slate-600/20 dark:bg-slate-800 dark:text-slate-400 dark:ring-slate-400/30',
                                        default => 'bg-slate-100 text-slate-800 ring-slate-600/20 dark:bg-slate-800 dark:text-slate-400 dark:ring-slate-400/30',
                                    };
                                @endphp
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium ring-1 ring-inset {{ $statusColors }}">
                                    {{ ucfirst($booking->booking_status ?? 'Unknown') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Current Booking Summary --}}
                    <div class="rounded-2xl border border-sky-200 bg-sky-50/80 p-6 shadow-sm ring-1 ring-sky-200/60 dark:border-sky-800 dark:bg-sky-900/20 dark:ring-sky-800/80">
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Current Booking</h2>
                        <div class="mt-3 grid gap-3 sm:grid-cols-2">
                            <div>
                                <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Type</p>
                                <p class="mt-0.5 text-slate-900 dark:text-white">{{ ucfirst($bookableType) }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Details</p>
                                <p class="mt-0.5 text-slate-900 dark:text-white">{{ $booking->bookableSummary() }}</p>
                            </div>
                            @if($booking->instructor)
                                <div>
                                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Instructor</p>
                                    <p class="mt-0.5 text-slate-900 dark:text-white">{{ $booking->instructorDisplayName() }}</p>
                                </div>
                            @endif
                            <div>
                                <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Total Price</p>
                                <p class="mt-0.5 text-slate-900 dark:text-white">£{{ number_format($booking->total_price, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Bookable Type Selection --}}
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/80 p-6 shadow-sm ring-1 ring-slate-200/60 dark:border-slate-800 dark:bg-slate-900/60 dark:ring-slate-800/80">
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Booking Type</h2>
                        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Change what you'd like to book</p>

                        <div class="mt-4">
                            <label for="bookable_type" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Type</label>
                            <select
                                x-model="bookableType"
                                @change="resetTypeFields()"
                                name="bookable_type"
                                id="bookable_type"
                                required
                                class="mt-1.5 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-sky-400"
                            >
                                <option value="">Select a booking type...</option>
                                @foreach($bookableTypeCases as $type)
                                    <option value="{{ $type->value }}" {{ $bookableType === $type->value ? 'selected' : '' }}>{{ $type->label() }}</option>
                                @endforeach
                            </select>
                            <p class="mt-4 text-sm text-green-600 dark:text-green-400" x-show="isAircraft || isLesson">Landing fees and fuel costs are not included and will be made payable at each airport</p>
                        </div>
                    </div>

                    <template x-if="hasTypeSelected">
                        <div class="space-y-8">
                            {{-- Aircraft Selection --}}
                            <div
                                x-show="isAircraft || isLesson"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="rounded-2xl border border-slate-200 bg-slate-50/80 p-6 shadow-sm ring-1 ring-slate-200/60 dark:border-slate-800 dark:bg-slate-900/60 dark:ring-slate-800/80"
                            >
                                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Aircraft Selection</h2>
                                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                                    <span x-show="isAircraft">Choose the aircraft you want to rent</span>
                                    <span x-show="isLesson">Choose the aircraft for your lesson</span>
                                </p>

                                <div class="mt-4">
                                    <label for="aircraft_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Aircraft</label>
                                    <select
                                        x-model="aircraftId"
                                        name="aircraft_id"
                                        id="aircraft_id"
                                        :required="isAircraft || isLesson"
                                        class="mt-1.5 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-sky-400"
                                    >
                                        <option value="">Select an aircraft...</option>
                                        @foreach($aircraftFleet as $aircraft)
                                            <option value="{{ $aircraft->id }}">
                                                {{ $aircraft->registration }} - {{ $aircraft->make }} {{ $aircraft->model }} (£{{ number_format($aircraft->rental_price_per_hour, 2) }}/hr)
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="mt-4 text-sm text-green-600 dark:text-green-400" x-show="isAircraft || isLesson">Ensure you hold the correct certification for the aircraft you are booking.</p>
                                </div>
                            </div>

                            {{-- Instructor Selection --}}
                            <div
                                x-show="isLesson"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="rounded-2xl border border-slate-200 bg-slate-50/80 p-6 shadow-sm ring-1 ring-slate-200/60 dark:border-slate-800 dark:bg-slate-900/60 dark:ring-slate-800/80"
                            >
                                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Instructor Selection</h2>
                                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Choose your instructor for this lesson</p>

                                <div class="mt-4">
                                    <label for="instructor_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Instructor</label>
                                    <select
                                        x-model="instructorId"
                                        name="instructor_id"
                                        id="instructor_id"
                                        :required="isLesson"
                                        class="mt-1.5 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-sky-400"
                                    >
                                        <option value="">Select an instructor...</option>
                                        @foreach($instructors as $instructor)
                                            <option value="{{ $instructor->id }}">
                                                {{ $instructor->first_name }} {{ $instructor->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Exam Selection --}}
                            <div
                                x-show="isExam"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="rounded-2xl border border-slate-200 bg-slate-50/80 p-6 shadow-sm ring-1 ring-slate-200/60 dark:border-slate-800 dark:bg-slate-900/60 dark:ring-slate-800/80"
                            >
                                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Exam Details</h2>
                                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Select the type of exam you're registering for</p>

                                <div class="mt-4">
                                    <label for="exam_type" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Exam Type</label>
                                    <select
                                        x-model="examType"
                                        name="exam_type"
                                        id="exam_type"
                                        :required="isExam"
                                        class="mt-1.5 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-sky-400"
                                    >
                                        <option value="">Select an exam type...</option>
                                        @foreach($exams as $exam)
                                            <option value="{{ $exam->id }}">{{ $exam->type }} (£{{ number_format($exam->total_price, 2) }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Schedule --}}
                            <div
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="rounded-2xl border border-slate-200 bg-slate-50/80 p-6 shadow-sm ring-1 ring-slate-200/60 dark:border-slate-800 dark:bg-slate-900/60 dark:ring-slate-800/80"
                            >
                                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Schedule</h2>
                                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                                    <span x-show="isAircraft">When would you like to rent this aircraft?</span>
                                    <span x-show="isLesson">When would you like to schedule your lesson?</span>
                                    <span x-show="isExam">When would you like to take your exam?</span>
                                </p>

                                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <label for="start_date" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Start Date</label>
                                        <input
                                            x-model="startDate"
                                            type="date"
                                            name="start_date"
                                            id="start_date"
                                            required
                                            class="mt-1.5 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-sky-400"
                                        >
                                    </div>

                                    <div>
                                        <label for="start_time" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Start Time</label>
                                        <input
                                            x-model="startTime"
                                            type="time"
                                            name="start_time"
                                            id="start_time"
                                            required
                                            min="06:00"
                                            max="20:00"
                                            step="1800"
                                            class="mt-1.5 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-sky-400"
                                        >
                                    </div>

                                    <div x-show="isAircraft || isLesson">
                                        <label for="end_date" class="block text-sm font-medium text-slate-700 dark:text-slate-300">End Date</label>
                                        <input
                                            x-model="endDate"
                                            type="date"
                                            name="end_date"
                                            id="end_date"
                                            required
                                            :min="startDate"
                                            class="mt-1.5 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-sky-400"
                                        >
                                    </div>

                                    <div x-show="isAircraft || isLesson">
                                        <label for="end_time" class="block text-sm font-medium text-slate-700 dark:text-slate-300">End Time</label>
                                        <input
                                            x-model="endTime"
                                            type="time"
                                            name="end_time"
                                            id="end_time"
                                            required
                                            min="06:00"
                                            max="21:00"
                                            step="1800"
                                            class="mt-1.5 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-sky-400"
                                        >
                                    </div>
                                </div>
                            </div>

                            {{-- Additional Notes --}}
                            <div
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="rounded-2xl border border-slate-200 bg-slate-50/80 p-6 shadow-sm ring-1 ring-slate-200/60 dark:border-slate-800 dark:bg-slate-900/60 dark:ring-slate-800/80"
                            >
                                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Additional Information</h2>
                                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Any special requests or notes for this booking</p>

                                <div class="mt-4">
                                    <label for="notes" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Notes <span class="text-slate-500">(optional)</span></label>
                                    <textarea
                                        x-model="notes"
                                        name="notes"
                                        id="notes"
                                        rows="3"
                                        placeholder="E.g., specific maneuvers to practice, cross-country destination, special accommodations..."
                                        class="mt-1.5 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-500 dark:focus:border-sky-400"
                                    >{{ $booking->notes }}</textarea>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                {{-- Cancel Booking Form --}}
                                <form
                                    action="{{ route('dashboard.bookings.cancel', $booking) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to cancel this booking? This action cannot be undone.')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="inline-flex items-center justify-center gap-2 rounded-lg border border-red-300 bg-white px-4 py-2.5 text-sm font-medium text-red-600 shadow-sm transition hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500/20 dark:border-red-700 dark:bg-slate-800 dark:text-red-400 dark:hover:bg-red-900/20"
                                    >
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Cancel Booking
                                    </button>
                                </form>

                                <div class="flex items-center gap-4">
                                    <a
                                        href="{{ route('dashboard.index') }}"
                                        class="rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-sky-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700"
                                    >
                                        Back
                                    </a>
                                    <button
                                        type="submit"
                                        class="rounded-lg bg-sky-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500/50 dark:bg-sky-500 dark:hover:bg-sky-600"
                                    >
                                        Update Booking
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </form>
            </div>
        </section>
    </main>
@endsection
