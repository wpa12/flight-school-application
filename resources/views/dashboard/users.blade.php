<section id="users" class="mt-10 scroll-mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Users</h2>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Add or update accounts manually (password resets, roles, etc.).</p>
        </div>
        <a href="{{ route('dashboard.users.create') }}" class="inline-flex shrink-0 items-center justify-center rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700 dark:bg-sky-500 dark:hover:bg-sky-400">
            Add user
        </a>
    </div>

    <div class="mt-6 overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-800">
        <table class="min-w-full divide-y divide-slate-200 text-left text-sm dark:divide-slate-800">
            <thead class="bg-slate-50 dark:bg-slate-800/80">
                <tr>
                    <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Name</th>
                    <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Email</th>
                    <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Role</th>
                    <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold text-slate-700 dark:text-slate-200">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                @foreach ($users as $u)
                    <tr>
                        <td class="whitespace-nowrap px-4 py-3 text-slate-800 dark:text-slate-200">{{ $u->name }}</td>
                        <td class="whitespace-nowrap px-4 py-3 text-slate-600 dark:text-slate-400">{{ $u->email }}</td>
                        <td class="whitespace-nowrap px-4 py-3">
                            @if ($u->is_admin)
                                <span class="text-xs font-semibold text-sky-700 dark:text-sky-300">Admin</span>
                            @else
                                <span class="text-xs text-slate-600 dark:text-slate-400">Student</span>
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-4 py-3">
                            <a href="{{ route('dashboard.users.edit', $u) }}" class="rounded-md bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-800 transition hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">Update</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
