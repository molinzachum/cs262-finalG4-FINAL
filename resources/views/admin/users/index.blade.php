<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-slate-600">Administration</p>
                <h1 class="text-2xl font-bold text-slate-950">System Users</h1>
            </div>
        </div>
    </x-slot>

    <section class="overflow-hidden rounded-lg border border-[#D6E5EC] bg-white shadow-sm">
        <div class="border-b border-[#D6E5EC] px-5 py-4">
            <h2 class="text-lg font-semibold text-slate-950">System Accounts</h2>
            <p class="mt-1 text-sm text-slate-500">Manage all registered user accounts and roles in the platform.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-[#EEF6FA] text-left text-xs font-semibold uppercase text-slate-500">
                    <tr>
                        <th class="px-5 py-3">User</th>
                        <th class="px-5 py-3">Role</th>
                        <th class="px-5 py-3">Joined Date</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    @if($user->profile_picture)
                                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }} profile picture" class="h-10 w-10 rounded-lg object-cover">
                                    @else
                                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#C4D8E2] text-sm font-bold text-slate-800">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-slate-950">{{ $user->name }}</p>
                                        <p class="text-slate-500 text-xs">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold ring-1 ring-inset {{
                                    $user->role === 1 ? 'bg-purple-50 text-purple-700 ring-purple-600/20' : 'bg-slate-50 text-slate-700 ring-slate-600/20'
                                }}">
                                    {{ $user->role === 1 ? 'Admin' : 'Member' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-slate-500 font-medium">
                                {{ $user->created_at ? $user->created_at->format('Y-m-d') : 'N/A' }}
                            </td>
                            <td class="px-5 py-4 font-semibold text-right">
                                <a href="{{ route('admin.users.show', $user) }}" class="rounded-lg border border-[#D6E5EC] px-3 py-2 text-slate-700 hover:bg-[#EEF6FA] text-xs">Edit Settings</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</x-app-layout>
