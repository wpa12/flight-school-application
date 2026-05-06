@extends('welcome')
@section('content')
    <main class="w-full">
        <section class="border-b border-slate-200/80 bg-linear-to-b from-sky-50 via-white to-white py-10 dark:border-slate-800 dark:from-slate-900 dark:via-slate-950 dark:to-slate-950 sm:py-12">
            <div class="mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
                <p class="text-sm font-semibold uppercase tracking-wider text-sky-600 dark:text-sky-400">Schedule</p>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl dark:text-white">
                    Create a Booking
                </h1>
                <p class="mx-auto mt-4 max-w-xl text-base leading-relaxed text-slate-600 dark:text-slate-400">
                    Book an aircraft rental, schedule a lesson with an instructor, or register for an exam.
                </p>
            </div>
        </section>

        <section class="bg-white py-12 dark:bg-slate-950 sm:py-16">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <form
                    x-data="{
                        bookableType: '{{ old('bookable_type', '') }}',
                        bookableId: '{{ old('bookable_id', '') }}',
                        aircraftId: '{{ old('bookable_id', '') }}',
                        userId: '{{ old('user_id', '') }}',
                        instructorId: '{{ old('instructor_id', '') }}',
                        examType: '{{ old('exam_type', '') }}',
                        startDate: '{{ old('start_date', '') }}',
                        startTime: '{{ old('start_time', '') }}',
                        durationHours: '{{ old('duration_hours', '') }}',
                        totalPrice: 0,
                        notes: '{{ old('notes', '') }}',

                        aircraftHourlyRates: {{ Js::from($aircraftFleet->pluck('rental_price_per_hour', 'id')) }},
                        examTotalPrices: {{ Js::from($exams->pluck('total_price', 'id')) }},

                        cardNumber: '',
                        cardExpiry: '',
                        cardCvv: '',
                        cardName: '',
                        cardType: null,

                        get isAircraft() { return this.bookableType === 'aircraft' },
                        get isLesson() { return this.bookableType === 'lesson' },
                        get isExam() { return this.bookableType === 'exam' },
                        get hasTypeSelected() { return this.bookableType !== '' },

                        get formattedTotalPrice() {
                            return this.totalPrice.toFixed(2);
                        },

                        resetTypeFields() {
                            this.aircraftId = '';
                            this.instructorId = '';
                            this.examType = '';
                            this.durationHours = '';
                            this.calculateTotalPrice();
                        },

                        calculateTotalPrice() {
                            if (this.isExam && this.examType) {
                                this.totalPrice = parseFloat(this.examTotalPrices[this.examType]) || 0;
                            } else if ((this.isAircraft || this.isLesson) && this.aircraftId && this.durationHours) {
                                const hourlyRate = parseFloat(this.aircraftHourlyRates[this.aircraftId]) || 0;
                                const hours = parseFloat(this.durationHours) || 0;
                                this.totalPrice = hourlyRate * hours;
                            } else {
                                this.totalPrice = 0;
                            }
                        },

                        init() {
                            this.$watch('durationHours', () => this.calculateTotalPrice())
                            this.$watch('examType', () => this.calculateTotalPrice())
                            this.$watch('aircraftId', () => this.calculateTotalPrice())
                            this.$watch('bookableType', () => this.calculateTotalPrice())
                            this.calculateTotalPrice();
                        },

                        formatCardNumber(e) {
                            let value = e.target.value.replace(/\D/g, '');
                            value = value.substring(0, 16);
                            let formatted = value.replace(/(\d{4})(?=\d)/g, '$1 ');
                            this.cardNumber = formatted;

                            if (value.startsWith('4')) {
                                this.cardType = 'visa';
                            } else if (/^5[1-5]/.test(value) || /^2[2-7]/.test(value)) {
                                this.cardType = 'mastercard';
                            } else if (/^3[47]/.test(value)) {
                                this.cardType = 'amex';
                            } else {
                                this.cardType = null;
                            }
                        },

                        formatExpiry(e) {
                            let value = e.target.value.replace(/\D/g, '');
                            value = value.substring(0, 4);
                            if (value.length >= 2) {
                                value = value.substring(0, 2) + '/' + value.substring(2);
                            }
                            this.cardExpiry = value;
                        },

                        formatCvv(e) {
                            let value = e.target.value.replace(/\D/g, '');
                            this.cardCvv = value.substring(0, this.cardType === 'amex' ? 4 : 3);
                        }
                    }"
                    action="{{ route('dashboard.bookings.store') }}"
                    method="POST"
                    class="grid gap-8 lg:grid-cols-3"
                >
                    @csrf

                    {{-- Left Column: Booking Details --}}
                    <div class="space-y-8 lg:col-span-2">
                    {{-- Bookable Type Selection --}}
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/80 p-6 shadow-sm ring-1 ring-slate-200/60 dark:border-slate-800 dark:bg-slate-900/60 dark:ring-slate-800/80">
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Booking Type</h2>
                        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Select what you'd like to book</p>

                        <div class="mt-4">
                            <label for="bookable_type" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Type</label>
                            <select
                                x-model="bookableType"
                                @change="resetTypeFields()"
                                name="bookable_type"
                                id="bookable_type"
                                required
                                class="mt-1.5 block w-full rounded-lg border bg-white px-3 py-2.5 text-slate-900 shadow-sm transition focus:outline-none focus:ring-2 dark:bg-slate-800 dark:text-white {{ $errors->has('bookable_type') ? 'border-red-500 focus:border-red-500 focus:ring-red-500/20 dark:border-red-500' : 'border-slate-300 focus:border-sky-500 focus:ring-sky-500/20 dark:border-slate-700 dark:focus:border-sky-400' }}"
                            >
                                <option value="">Select a booking type...</option>
                                @foreach($bookableTypeCases as $type)
                                    <option value="{{ $type->value }}" {{ old('bookable_type') === $type->value ? 'selected' : '' }}>{{ $type->label() }}</option>
                                @endforeach
                            </select>
                            @error('bookable_type')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-4 text-sm text-green-600 dark:text-green-400" x-show="isAircraft || isLesson">Landing fees and fuel costs are not included and will be made payable at each airport</p>
                        </div>
                    </div>

                    <template x-if="hasTypeSelected">
                        <div class="space-y-8">
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
                                        name="bookable_id"
                                        id="aircraft_id"
                                        :disabled="isExam"
                                        :required="isAircraft || isLesson"
                                        class="mt-1.5 block w-full rounded-lg border bg-white px-3 py-2.5 text-slate-900 shadow-sm transition focus:outline-none focus:ring-2 dark:bg-slate-800 dark:text-white {{ $errors->has('bookable_id') ? 'border-red-500 focus:border-red-500 focus:ring-red-500/20 dark:border-red-500' : 'border-slate-300 focus:border-sky-500 focus:ring-sky-500/20 dark:border-slate-700 dark:focus:border-sky-400' }}"
                                    >
                                        <option value="">Select an aircraft...</option>
                                        @foreach($aircraftFleet as $aircraft)
                                            <option value="{{ $aircraft->id }}" {{ old('bookable_id') == $aircraft->id ? 'selected' : '' }}>
                                                {{ $aircraft->registration }} - {{ $aircraft->make }} {{ $aircraft->model }} (£{{ number_format($aircraft->rental_price_per_hour, 2) }}/hr)
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('bookable_id')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-4 text-sm text-green-600 dark:text-green-400" x-show="isAircraft || isLesson">Ensure you hold the correct certification for the aircraft you are booking.</p>
                                </div>
                            </div>

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
                                        class="mt-1.5 block w-full rounded-lg border bg-white px-3 py-2.5 text-slate-900 shadow-sm transition focus:outline-none focus:ring-2 dark:bg-slate-800 dark:text-white {{ $errors->has('instructor_id') ? 'border-red-500 focus:border-red-500 focus:ring-red-500/20 dark:border-red-500' : 'border-slate-300 focus:border-sky-500 focus:ring-sky-500/20 dark:border-slate-700 dark:focus:border-sky-400' }}"
                                    >
                                        <option value="">Select an instructor...</option>
                                        @foreach($instructors as $instructor)
                                            <option value="{{ $instructor->id }}" {{ old('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                                {{ $instructor->first_name }} {{ $instructor->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('instructor_id')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

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
                                        name="bookable_id"
                                        id="exam_type"
                                        :disabled="!isExam"
                                        :required="isExam"
                                        class="mt-1.5 block w-full rounded-lg border bg-white px-3 py-2.5 text-slate-900 shadow-sm transition focus:outline-none focus:ring-2 dark:bg-slate-800 dark:text-white {{ $errors->has('exam_type') ? 'border-red-500 focus:border-red-500 focus:ring-red-500/20 dark:border-red-500' : 'border-slate-300 focus:border-sky-500 focus:ring-sky-500/20 dark:border-slate-700 dark:focus:border-sky-400' }}"
                                    >
                                        <option value="">Select an exam type...</option>
                                        @foreach($exams as $exam)
                                            <option value="{{ $exam->id }}" {{ old('exam_type') == $exam->id ? 'selected' : '' }}>{{ $exam->type }} (£{{ number_format($exam->total_price, 2) }}) - {{ $exam->duration_minutes }} minute(s)</option>
                                        @endforeach
                                    </select>
                                    @error('exam_type')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            @if(Auth::user()->is_admin)
                            <div
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="rounded-2xl border border-slate-200 bg-slate-50/80 p-6 shadow-sm ring-1 ring-slate-200/60 dark:border-slate-800 dark:bg-slate-900/60 dark:ring-slate-800/80"
                            >
                                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">User</h2>
                                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Select the user for this booking</p>

                                <div class="mt-4">
                                    <label for="user_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300">User</label>
                                    <select
                                        name="user_id"
                                        id="user_id"
                                        required
                                        class="mt-1.5 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:focus:border-sky-400"
                                    >
                                        <option value="">Select a user...</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @else
                            <input type="hidden" name="user_id" id="user_id" value="{{ request()->user()->id }}"/>
                            @endif

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
                                            value="{{ old('start_date') }}"
                                            :min="new Date().toISOString().split('T')[0]"
                                            class="mt-1.5 block w-full rounded-lg border bg-white px-3 py-2.5 text-slate-900 shadow-sm transition focus:outline-none focus:ring-2 dark:bg-slate-800 dark:text-white {{ $errors->has('start_date') ? 'border-red-500 focus:border-red-500 focus:ring-red-500/20 dark:border-red-500' : 'border-slate-300 focus:border-sky-500 focus:ring-sky-500/20 dark:border-slate-700 dark:focus:border-sky-400' }}"
                                            autocomplete="off"
                                        >
                                        @error('start_date')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="start_time" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Start Time</label>
                                        <input
                                            x-model="startTime"
                                            type="time"
                                            name="start_time"
                                            id="start_time"
                                            required
                                            value="{{ old('start_time') }}"
                                            min="06:00"
                                            max="20:00"
                                            step="1800"
                                            class="mt-1.5 block w-full rounded-lg border bg-white px-3 py-2.5 text-slate-900 shadow-sm transition focus:outline-none focus:ring-2 dark:bg-slate-800 dark:text-white {{ $errors->has('start_time') ? 'border-red-500 focus:border-red-500 focus:ring-red-500/20 dark:border-red-500' : 'border-slate-300 focus:border-sky-500 focus:ring-sky-500/20 dark:border-slate-700 dark:focus:border-sky-400' }}"
                                            autocomplete="off"
                                        >
                                        @error('start_time')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div x-show="isAircraft || isLesson" class="sm:col-span-2">
                                        <label for="duration_hours" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Duration (hours)</label>
                                        <input
                                            x-model="durationHours"
                                            type="number"
                                            name="duration_hours"
                                            id="duration_hours"
                                            value="{{ old('duration_hours') }}"
                                            min="0.25"
                                            max="24"
                                            step="0.25"
                                            @change="calculateTotalPrice()"
                                            :required="isAircraft || isLesson"
                                            :disabled="isExam"
                                            class="mt-1.5 block w-full max-w-xs rounded-lg border bg-white px-3 py-2.5 text-slate-900 shadow-sm transition focus:outline-none focus:ring-2 dark:bg-slate-800 dark:text-white {{ $errors->has('duration_hours') ? 'border-red-500 focus:border-red-500 focus:ring-red-500/20 dark:border-red-500' : 'border-slate-300 focus:border-sky-500 focus:ring-sky-500/20 dark:border-slate-700 dark:focus:border-sky-400' }}"
                                        >
                                        <p class="mt-1 text-xs text-green-500 dark:text-green-400">Enter rental or lesson length (e.g. 1.5 for one and a half hours).</p>
                                        @error('duration_hours')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Additional Notes (optional) --}}
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
                                    ></textarea>
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div class="flex items-center justify-end gap-4">
                                <a
                                    href="{{ url()->previous() }}"
                                    class="rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-sky-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700"
                                >
                                    Cancel
                                </a>
                                <button
                                    type="submit"
                                    class="rounded-lg bg-sky-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500/50 dark:bg-sky-500 dark:hover:bg-sky-600"
                                >
                                    <span x-show="isAircraft">Book Aircraft</span>
                                    <span x-show="isLesson">Schedule Lesson</span>
                                    <span x-show="isExam">Register for Exam</span>
                                </button>
                            </div>
                        </div>
                    </template>

                    {{-- Placeholder when no type selected --}}
                    <div
                        x-show="!hasTypeSelected"
                        class="rounded-2xl border border-dashed border-slate-300 bg-slate-50/50 py-12 text-center dark:border-slate-700 dark:bg-slate-900/30"
                    >
                        <svg class="mx-auto h-12 w-12 text-slate-400 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        <p class="mt-4 text-sm text-slate-600 dark:text-slate-400">Select a booking type above to continue</p>
                    </div>

                    </div>{{-- End Left Column --}}

                    {{-- Right Column: Payment Details --}}
                    <div class="lg:col-span-1">
                        <div class="sticky top-8 space-y-6">
                            {{-- Payment Card Section --}}
                            <div class="rounded-2xl border border-slate-200 bg-slate-50/80 p-6 shadow-sm ring-1 ring-slate-200/60 dark:border-slate-800 dark:bg-slate-900/60 dark:ring-slate-800/80">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Payment Details</h2>
                                        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Enter your card information</p>
                                    </div>
                                    {{-- Card Type Icons --}}
                                    <div class="flex items-center gap-2">
                                        <svg x-show="cardType === 'visa'" class="h-8 w-auto" viewBox="0 0 50 16" fill="none">
                                            <rect width="50" height="16" rx="2" fill="#1A1F71"/>
                                            <path d="M19.5 11.5L21.5 4.5H24L22 11.5H19.5Z" fill="white"/>
                                            <path d="M31 4.5L28.5 11.5H26L24.5 6C24.4 5.6 24.2 5.4 23.8 5.2C23.2 4.9 22.3 4.6 21.5 4.5L21.6 4.5H25.5C26.1 4.5 26.5 4.9 26.6 5.5L27.5 9.5L30 4.5H31Z" fill="white"/>
                                            <path d="M32 4.5L34.5 11.5H32L31.7 10.5H29.2L28.8 11.5H26.5L29.5 5C29.7 4.6 30.1 4.5 30.5 4.5H32ZM30 7L29.5 9H31L30 7Z" fill="white"/>
                                            <path d="M38 7C38 7 36.5 6.5 36.5 6C36.5 5.6 37 5.5 37.5 5.5C38.2 5.5 38.8 5.7 39 5.8L39.3 4.6C39 4.5 38.3 4.3 37.5 4.3C35.8 4.3 34.5 5.2 34.5 6.5C34.5 7.5 35.5 8 36 8.3C36.5 8.5 37 8.8 37 9C37 9.4 36.5 9.6 36 9.6C35.2 9.6 34.5 9.3 34 9L33.7 10.3C34.3 10.6 35.2 10.8 36 10.8C37.8 10.8 39 9.9 39 8.5C39 7.8 38.5 7.3 38 7Z" fill="white"/>
                                        </svg>
                                        <svg x-show="cardType === 'mastercard'" class="h-8 w-auto" viewBox="0 0 50 16" fill="none">
                                            <rect width="50" height="16" rx="2" fill="#000"/>
                                            <circle cx="20" cy="8" r="5" fill="#EB001B"/>
                                            <circle cx="30" cy="8" r="5" fill="#F79E1B"/>
                                            <path d="M25 4.5C26.5 5.5 27.5 7 27.5 8C27.5 9 26.5 10.5 25 11.5C23.5 10.5 22.5 9 22.5 8C22.5 7 23.5 5.5 25 4.5Z" fill="#FF5F00"/>
                                        </svg>
                                        <svg x-show="cardType === 'amex'" class="h-8 w-auto" viewBox="0 0 50 16" fill="none">
                                            <rect width="50" height="16" rx="2" fill="#006FCF"/>
                                            <path d="M10 5L8 11H10L10.3 10H12.7L13 11H15L13 5H10ZM11.5 6.5L12.3 8.5H10.7L11.5 6.5Z" fill="white"/>
                                            <path d="M15 5V11H17V9H18L19 11H21L19.8 8.8C20.5 8.5 21 7.8 21 7C21 5.9 20.1 5 19 5H15ZM17 6.5H18.5C19 6.5 19 7 19 7C19 7.5 18.5 7.5 18.5 7.5H17V6.5Z" fill="white"/>
                                            <path d="M22 5V11H27V9.5H24V8.5H27V7H24V6.5H27V5H22Z" fill="white"/>
                                            <path d="M28 5L30 8L28 11H30.5L31.5 9L32.5 11H35L33 8L35 5H32.5L31.5 7L30.5 5H28Z" fill="white"/>
                                        </svg>
                                        <div x-show="!cardType" class="flex items-center gap-1 opacity-40">
                                            <svg class="h-6 w-auto" viewBox="0 0 24 16" fill="none">
                                                <rect width="24" height="16" rx="2" fill="#E5E7EB"/>
                                                <rect x="2" y="4" width="8" height="2" rx="1" fill="#9CA3AF"/>
                                                <rect x="2" y="8" width="12" height="2" rx="1" fill="#9CA3AF"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6 space-y-4">
                                    {{-- Cardholder Name --}}
                                    <div>
                                        <label for="card_name" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Cardholder Name</label>
                                        <input
                                            x-model="cardName"
                                            type="text"
                                            name="card_name"
                                            id="card_name"
                                            autocomplete="cc-name"
                                            placeholder="Name on card"
                                            required
                                            class="mt-1.5 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-500 dark:focus:border-sky-400"
                                        >
                                    </div>

                                    {{-- Card Number --}}
                                    <div>
                                        <label for="card_number" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Card Number</label>
                                        <div class="relative">
                                            <input
                                                x-model="cardNumber"
                                                @input="formatCardNumber($event)"
                                                type="text"
                                                name="card_number"
                                                id="card_number"
                                                inputmode="numeric"
                                                autocomplete="cc-number"
                                                placeholder="1234 5678 9012 3456"
                                                maxlength="19"
                                                required
                                                class="mt-1.5 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 pr-12 text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-500 dark:focus:border-sky-400"
                                            >
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Expiry & CVV --}}
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="card_expiry" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Expiry Date</label>
                                            <input
                                                x-model="cardExpiry"
                                                @input="formatExpiry($event)"
                                                type="text"
                                                name="card_expiry"
                                                id="card_expiry"
                                                inputmode="numeric"
                                                autocomplete="cc-exp"
                                                placeholder="MM/YY"
                                                maxlength="5"
                                                required
                                                class="mt-1.5 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-500 dark:focus:border-sky-400"
                                            >
                                        </div>

                                        <div>
                                            <label for="card_cvv" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                                                <span x-text="cardType === 'amex' ? 'CID' : 'CVV'">CVV</span>
                                            </label>
                                            <div class="relative">
                                                <input
                                                    x-model="cardCvv"
                                                    @input="formatCvv($event)"
                                                    type="text"
                                                    name="card_cvv"
                                                    id="card_cvv"
                                                    inputmode="numeric"
                                                    autocomplete="cc-csc"
                                                    :placeholder="cardType === 'amex' ? '1234' : '123'"
                                                    :maxlength="cardType === 'amex' ? 4 : 3"
                                                    required
                                                    class="mt-1.5 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 pr-10 text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-500 dark:focus:border-sky-400"
                                                >
                                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-6 text-xl flex justify-center text-green-500 dark:text-green-400">
                                    Total: £<span x-text="formattedTotalPrice"></span>
                                    <input type="hidden" name="total_price" x-model="totalPrice">
                                </div>
                            </div>

                            {{-- Security Notice --}}
                            <div class="flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 p-4 dark:border-green-800/50 dark:bg-green-900/20">
                                <svg class="mt-0.5 h-5 w-5 shrink-0 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-green-800 dark:text-green-300">Secure Payment</p>
                                    <p class="mt-0.5 text-xs text-green-700 dark:text-green-400">Your payment information is encrypted and securely processed.</p>
                                </div>
                            </div>

                            {{-- Accepted Cards --}}
                            <div class="text-center">
                                <p class="text-xs text-slate-500 dark:text-slate-500">We accept</p>
                                <div class="mt-2 flex items-center justify-center gap-3">
                                    <svg class="h-6 w-auto opacity-60 grayscale" viewBox="0 0 50 16" fill="none">
                                        <rect width="50" height="16" rx="2" fill="#1A1F71"/>
                                        <path d="M19.5 11.5L21.5 4.5H24L22 11.5H19.5Z" fill="white"/>
                                        <path d="M31 4.5L28.5 11.5H26L24.5 6C24.4 5.6 24.2 5.4 23.8 5.2C23.2 4.9 22.3 4.6 21.5 4.5L21.6 4.5H25.5C26.1 4.5 26.5 4.9 26.6 5.5L27.5 9.5L30 4.5H31Z" fill="white"/>
                                        <path d="M32 4.5L34.5 11.5H32L31.7 10.5H29.2L28.8 11.5H26.5L29.5 5C29.7 4.6 30.1 4.5 30.5 4.5H32ZM30 7L29.5 9H31L30 7Z" fill="white"/>
                                        <path d="M38 7C38 7 36.5 6.5 36.5 6C36.5 5.6 37 5.5 37.5 5.5C38.2 5.5 38.8 5.7 39 5.8L39.3 4.6C39 4.5 38.3 4.3 37.5 4.3C35.8 4.3 34.5 5.2 34.5 6.5C34.5 7.5 35.5 8 36 8.3C36.5 8.5 37 8.8 37 9C37 9.4 36.5 9.6 36 9.6C35.2 9.6 34.5 9.3 34 9L33.7 10.3C34.3 10.6 35.2 10.8 36 10.8C37.8 10.8 39 9.9 39 8.5C39 7.8 38.5 7.3 38 7Z" fill="white"/>
                                    </svg>
                                    <svg class="h-6 w-auto opacity-60 grayscale" viewBox="0 0 50 16" fill="none">
                                        <rect width="50" height="16" rx="2" fill="#000"/>
                                        <circle cx="20" cy="8" r="5" fill="#EB001B"/>
                                        <circle cx="30" cy="8" r="5" fill="#F79E1B"/>
                                        <path d="M25 4.5C26.5 5.5 27.5 7 27.5 8C27.5 9 26.5 10.5 25 11.5C23.5 10.5 22.5 9 22.5 8C22.5 7 23.5 5.5 25 4.5Z" fill="#FF5F00"/>
                                    </svg>
                                    <svg class="h-6 w-auto opacity-60 grayscale" viewBox="0 0 50 16" fill="none">
                                        <rect width="50" height="16" rx="2" fill="#006FCF"/>
                                        <path d="M10 5L8 11H10L10.3 10H12.7L13 11H15L13 5H10ZM11.5 6.5L12.3 8.5H10.7L11.5 6.5Z" fill="white"/>
                                        <path d="M15 5V11H17V9H18L19 11H21L19.8 8.8C20.5 8.5 21 7.8 21 7C21 5.9 20.1 5 19 5H15ZM17 6.5H18.5C19 6.5 19 7 19 7C19 7.5 18.5 7.5 18.5 7.5H17V6.5Z" fill="white"/>
                                        <path d="M22 5V11H27V9.5H24V8.5H27V7H24V6.5H27V5H22Z" fill="white"/>
                                        <path d="M28 5L30 8L28 11H30.5L31.5 9L32.5 11H35L33 8L35 5H32.5L31.5 7L30.5 5H28Z" fill="white"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>{{-- End Right Column --}}

                </form>
            </div>
        </section>
    </main>
@endsection
