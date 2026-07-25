<x-app-layout>
    @php
        $stats = [
            [
                'label' => 'Active Projects',
                'value' => $projectsActive,
                'helper' => 'Projects you created',
                'helper2' => 'Total Projects: ' . $projectsCount,
                'icon' => 'P',
                'progress' => $progress['projects'],
            ],
            [
                'label' => 'Open Tasks',
                'value' => $tasksCount,
                'helper' => 'Pending in your projects',
                'helper2' => 'Total tasks: ' . $tasksTotal,
                'icon' => 'T',
                'progress' => $progress['tasks'],
            ],
            [
                'label' => 'Milestones',                                                                     
                'value' => $milestonesCount,
                'helper' => 'Milestones tracking',
                'helper2' => 'In progress: ' . $milestonesInProgress,
                'icon' => 'M',
                'progress' => $progress['milestones'],
            ],
            [
                'label' => 'Hours Logged',
                'value' => $hoursLogged,
                'helper' => 'Total team hours spent',
                'helper2' => '',
                'icon' => 'H',
                'progress' => $progress['hours'] ?? 0,
            ],         
        ];

        $activities = [
            ['title' => 'Website Redesign updated', 'meta' => 'Project status moved to In progress'],
            ['title' => 'Wireframe Approval created', 'meta' => 'Milestone due July 20'],      
            ['title' => 'Project screen layout logged', 'meta' => '2.5 hours added to Time Logs'],
        ];
    @endphp

    <x-slot name="header">                     
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-slate-600">Overview</p>
                <h1 class="text-2xl font-bold text-slate-950">Admin Dashboard</h1>
            </div>
            <a href="{{ route('projects.create') }}" class="inline-flex items-center justify-center rounded-lg bg-[#2F5F73] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#244B5C]">
                New Project
            </a>
        </div>
    </x-slot>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        @foreach ($stats as $stat)
            <section class="rounded-lg border border-[#D6E5EC] bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold text-slate-500">{{ $stat['label'] }}</p>
                        <p class="mt-3 text-3xl font-bold text-slate-950">{{ $stat['value'] }}</p>
                    </div>
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#C4D8E2] text-sm font-bold text-[#2F5F73]">
                        {{ $stat['icon'] }}
                    </span>
                </div>
                <p class="mt-3 text-sm text-slate-500">{{ $stat['helper'] }}</p>
                <div id="myProgress" class="mt-4 h-1.5 overflow-hidden rounded-full bg-[#EEF6FA]">
                    <div id="myBar" class="h-full rounded-full bg-[#2F5F73]" style="width: {{ $stat['progress'] }}%;">
                    </div>
                </div>
                <p class="mt-3 text-sm font-bold text-slate-500">{{ $stat['helper2'] }}</p>
            </section>
        @endforeach
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-[1fr_360px]">
        <div class="space-y-6">
            <!-- Quick Access Section -->
            <section class="rounded-lg border border-[#D6E5EC] bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-950">Quick Access</h2>
                        <p class="mt-1 text-sm text-slate-500">Jump into the main project management screens.</p>
                    </div>
                </div>

                <div class="mt-5 grid gap-3 sm:grid-cols-2">
                    <a href="{{ route('projects.index') }}" class="rounded-lg border border-[#D6E5EC] bg-[#F8FBFD] p-4 transition hover:border-[#9BBCCA] hover:bg-[#EEF6FA]">
                        <p class="font-semibold text-[#2F5F73]">Projects</p>
                        <p class="mt-1 text-sm text-slate-500">View, create, edit, and delete projects.</p>
                    </a>
                    <a href="{{ route('milestones.index') }}" class="rounded-lg border border-[#D6E5EC] bg-[#F8FBFD] p-4 transition hover:border-[#9BBCCA] hover:bg-[#EEF6FA]">
                        <p class="font-semibold text-[#2F5F73]">Milestones</p>
                        <p class="mt-1 text-sm text-slate-500">Track project checkpoints and due dates.</p>
                    </a>
                    <a href="{{ route('timelogs.index') }}" class="rounded-lg border border-[#D6E5EC] bg-[#F8FBFD] p-4 transition hover:border-[#9BBCCA] hover:bg-[#EEF6FA]">
                        <p class="font-semibold text-[#2F5F73]">Time Logs</p>
                        <p class="mt-1 text-sm text-slate-500">Review and add work hours.</p>
                    </a>
                    <a href="{{ route('team.index') }}" class="rounded-lg border border-[#D6E5EC] bg-[#F8FBFD] p-4 transition hover:border-[#9BBCCA] hover:bg-[#EEF6FA]">
                        <p class="font-semibold text-[#2F5F73]">Teams</p>
                        <p class="mt-1 text-sm text-slate-500">Manage members and roles.</p>
                    </a>
                </div>
            </section>

            <!-- Workspace Tasks Section -->
            <section class="rounded-lg border border-[#D6E5EC] bg-white p-5 shadow-sm">
                <div class="mb-4">
                    <h2 class="text-lg font-semibold text-slate-950">Workspace Tasks</h2>
                    <p class="mt-1 text-sm text-slate-500">Active tasks across all your projects.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse ($tasks as $task)
                        <x-task-card :task="$task" />
                    @empty
                        <div class="col-span-full text-center text-sm py-6 text-slate-500">
                            No active tasks in your projects.
                        </div>
                    @endforelse
                </div>
            </section>
        </div>

        <aside class="rounded-lg border border-[#D6E5EC] bg-[#F8FBFD] p-5 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-950">Recent Activity</h2>
            <div class="mt-4 space-y-4">
                @foreach ($activities as $activity)
                    <div class="rounded-lg border border-[#D6E5EC] bg-white p-4">
                        <p class="font-semibold text-slate-950">{{ $activity['title'] }}</p>
                        <p class="mt-1 text-sm text-slate-500">{{ $activity['meta'] }}</p>
                    </div>
                @endforeach
            </div>
        </aside>
    </div>
</x-app-layout>
