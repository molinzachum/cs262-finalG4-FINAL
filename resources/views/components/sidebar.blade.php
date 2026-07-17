@php
    $role = auth()->user()->role;
    
    $items = [
        [
            'label' => 'Dashboard',
            'href' => route('dashboard'),
            'active' => request()->routeIs('dashboard'),
            'icon' => 'dashboard',
        ],
        [
            'label' => 'Projects',
            'href' => route('projects.index'),
            'active' => request()->routeIs('projects.*'),
            'icon' => 'projects',
        ],
        [
            'label' => 'Milestones',
            'href' => route('milestones.index'),
            'active' => request()->routeIs('milestones.*'),
            'icon' => 'milestones',
        ],
        [
            'label' => 'Tasks',
            'href' => route('tasks.index'),
            'active' => request()->routeIs('tasks.*'),
            'icon' => 'tasks',
        ],
        [
            'label' => 'Time Logs',
            'href' => route('timelogs.index'),
            'active' => request()->routeIs('timelogs.*'),
            'icon' => 'time',
        ],
        [
            'label' => 'Teams',
            'href' => route('team.index'),
            'active' => request()->routeIs('team.*'),
            'icon' => 'teams',
        ],
    ];

    // Only Admins see the system users management link
    if ($role === 1) {
        $items[] = [
            'label' => 'System Users',
            'href' => route('admin.users.index'),
            'active' => request()->routeIs('admin.users.*'),
            'icon' => 'account',
        ];
    }

    $items[] = [
        'label' => 'Account',
        'href' => route('profile.edit'),
        'active' => request()->routeIs('profile.*'),
        'icon' => 'account',
    ];
@endphp

<aside
    class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-[#D6E5EC] bg-[#F8FBFD] shadow-xl shadow-slate-950/5 transition-transform duration-200 lg:translate-x-0"
    :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': ! sidebarOpen }"
>
    <div class="flex h-20 items-center justify-between border-b border-[#D6E5EC] px-6">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <span class="flex h-11 w-11 items-center justify-center rounded-lg bg-[#2F5F73] text-lg font-bold text-white">T</span>
            <span>
                <span class="block text-lg font-bold text-slate-950">TaskFlow</span>
                <span class="block text-xs font-medium text-slate-500">
                    {{ $role === 1 ? 'Admin workspace' : 'Member workspace' }}
                </span>
            </span>
        </a>

        <button
            type="button"
            class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 transition hover:bg-[#E5F0F5] lg:hidden"
            @click="sidebarOpen = false"
            aria-label="Close sidebar"
        >
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <path stroke-linecap="round" d="M6 6l12 12M18 6 6 18" />
            </svg>
        </button>
    </div>

    <nav class="flex-1 space-y-1 overflow-y-auto px-4 py-6">
        @foreach ($items as $item)
            <a
                href="{{ $item['href'] }}"
                class="{{ $item['active'] ? 'bg-[#C4D8E2] text-slate-950 ring-1 ring-[#9BBCCA]' : 'text-slate-600 hover:bg-[#E5F0F5] hover:text-slate-950' }} flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition"
                @click="sidebarOpen = false"
            >
                <span class="{{ $item['active'] ? 'text-[#2F5F73]' : 'text-slate-400' }} flex h-5 w-5 items-center justify-center">
                    @switch($item['icon'])
                        @case('dashboard')
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <rect x="4" y="4" width="7" height="7" rx="1.5" />
                                <rect x="13" y="4" width="7" height="7" rx="1.5" />
                                <rect x="4" y="13" width="7" height="7" rx="1.5" />
                                <rect x="13" y="13" width="7" height="7" rx="1.5" />
                            </svg>
                            @break
                        @case('teams')
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <circle cx="9" cy="8" r="3" />
                                <path stroke-linecap="round" d="M3.5 20a5.5 5.5 0 0 1 11 0" />
                                <path stroke-linecap="round" d="M16 11a2.5 2.5 0 1 0 0-5" />
                                <path stroke-linecap="round" d="M17.5 15.5A4.5 4.5 0 0 1 21 20" />
                            </svg>
                            @break
                        @case('tasks')
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h11M8 12h11M8 17h11" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4 7 .7.7L6 6.4M4 12l.7.7L6 11.4M4 17l.7.7L6 16.4" />
                            </svg>
                            @break
                        @case('projects')
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7.5A2.5 2.5 0 0 1 6.5 5H10l2 2h5.5A2.5 2.5 0 0 1 20 9.5v7A2.5 2.5 0 0 1 17.5 19h-11A2.5 2.5 0 0 1 4 16.5v-9Z" />
                            </svg>
                            @break
                        @case('milestones')
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 20V5m0 0h11l-2 4 2 4H5" />
                            </svg>
                            @break
                        @case('time')
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <circle cx="12" cy="12" r="8" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2" />
                            </svg>
                            @break
                        @case('account')
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <circle cx="12" cy="8" r="4" />
                                <path stroke-linecap="round" d="M4.5 20a7.5 7.5 0 0 1 15 0" />
                            </svg>
                            @break
                    @endswitch
                </span>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="border-t border-[#D6E5EC] p-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-[#E5F0F5] hover:text-slate-950"
            >
                <span class="flex h-5 w-5 items-center justify-center text-slate-400">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H6a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h3" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 17l5-5-5-5M21 12H9" />
                    </svg>
                </span>
                <span>Log Out</span>
            </button>
        </form>
    </div>
</aside>
</aside>