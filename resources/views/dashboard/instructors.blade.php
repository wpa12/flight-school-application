<section id="instructors" class="mt-10 scroll-mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Instructors</h2>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Directory used for bookings and the public instructors page.</p>
        </div>
        @if ($isAdmin)
            <a href="{{ route('dashboard.instructors.create') }}" class="inline-flex shrink-0 items-center justify-center rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700 dark:bg-sky-500 dark:hover:bg-sky-400">
                Add instructor
            </a>
        @endif
    </div>

    @if ($instructors->isEmpty())
        <p class="mt-6 text-sm text-slate-600 dark:text-slate-400">No instructors in the database.</p>
    @else
        <div class="mt-6 overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-800">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm dark:divide-slate-800">
                <thead class="bg-slate-50 dark:bg-slate-800/80">
                    <tr>
                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Name</th>
                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Email</th>
                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Phone</th>
                        @if ($isAdmin)
                            <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                    @foreach ($instructors as $instructor)
                        <tr>
                            <td class="whitespace-nowrap px-4 py-3 text-slate-800 dark:text-slate-200">{{ trim($instructor->first_name.' '.$instructor->last_name) }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-slate-600 dark:text-slate-400">{{ $instructor->email ?? '—' }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-slate-600 dark:text-slate-400">{{ $instructor->phone ?? '—' }}</td>
                            @if ($isAdmin)
                                <td class="whitespace-nowrap px-4 py-3">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <a href="{{ route('dashboard.instructors.edit', $instructor) }}" class="rounded-md bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-800 transition hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">Update</a>
                                        <form method="post" action="{{ route('dashboard.instructors.destroy', $instructor) }}" class="inline" onsubmit="return confirm('Remove this instructor?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-md bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700 transition hover:bg-red-100 dark:bg-red-950/50 dark:text-red-300 dark:hover:bg-red-950">Remove</button>
                                        </form>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</section>
