<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-slate-900">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-[#EEF6FA]">
        <div x-cloak x-show="sidebarOpen" class="fixed inset-0 z-40 bg-slate-950/40 lg:hidden"
            @click="sidebarOpen = false"></div>

        <x-sidebar />

        <div class="min-h-screen lg:pl-72">
            <header class="sticky top-0 z-30 border-b border-[#D6E5EC] bg-[#F8FBFD]/95 backdrop-blur">
                <div class="flex h-20 items-center gap-4 px-4 sm:px-6 lg:px-8">
                    <button type="button"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-[#D6E5EC] text-slate-600 transition hover:bg-[#E5F0F5] lg:hidden"
                        @click="sidebarOpen = true" aria-label="Open sidebar">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            aria-hidden="true">
                            <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" />
                        </svg>
                    </button>

                    <div class="min-w-0 flex-1">
                        @isset($header)
                            {{ $header }}
                        @else
                            <h1 class="text-xl font-semibold text-slate-950">Dashboard</h1>
                        @endisset
                    </div>

                    <div
                        class="hidden w-full max-w-xs items-center rounded-lg border border-[#D6E5EC] bg-[#EEF6FA] px-3 py-2 text-sm text-slate-500 md:flex">
                        <svg class="mr-2 h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" aria-hidden="true">
                            <circle cx="11" cy="11" r="7" />
                            <path stroke-linecap="round" d="m20 20-3.5-3.5" />
                        </svg>
                        <span>Search tasks, projects...</span>
                    </div>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center gap-3 rounded-lg border border-[#D6E5EC] bg-white px-2 py-2 text-left transition hover:bg-[#EEF6FA]">
                                @if (Auth::user()->profile_picture)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                                        alt="{{ Auth::user()->name }}" class="h-9 w-9 rounded-lg object-cover">
                                @else
                                    <span
                                        class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#2F5F73] text-sm font-semibold text-white">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </span>
                                @endif
                                <span class="hidden leading-tight sm:block">
                                    <span
                                        class="block text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</span>
                                    <span class="block text-xs text-slate-500">{{ Auth::user()->email }}</span>
                                </span>
                                <svg class="hidden h-4 w-4 text-slate-400 sm:block" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </header>

            <main class="px-4 py-6 sm:px-6 lg:px-8">
                {{ $slot }}
            </main>

            <footer class="border-t border-[#D6E5EC] bg-[#F8FBFD]/70 px-4 py-6 text-sm text-slate-500 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <p>&copy; {{ date('Y') }} {{ config('app.name', 'TaskFlow') }}. All rights reserved.</p>
                    <div class="flex gap-4">
                        <a href="{{ route('dashboard') }}" class="transition hover:text-slate-900">Dashboard</a>
                        <a href="{{ route('profile.edit') }}" class="transition hover:text-slate-900">Account</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</body>

</html>