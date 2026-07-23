<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-slate-600">Workspace Tasks</p>
                <h1 class="text-2xl font-bold text-slate-950">Tasks</h1>
            </div>
            <a href="{{ route('tasks.create') }}" class="inline-flex items-center justify-center rounded-lg bg-[#2F5F73] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#244B5C]">
               Create Task
            </a>
        </div>
    </x-slot>

    @if (session('status'))
        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 shadow-sm">{{ session('status') }}</div>
    @endif

    <div class="grid gap-6 md:grid-cols-3">
        <!-- To-do Column -->
        <section class="rounded-lg border border-[#D6E5EC] bg-slate-50/50 p-4 flex flex-col min-h-[400px]">
            <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <span class="h-2.5 w-2.5 rounded-full bg-slate-400"></span>
                    <h2 class="font-bold text-slate-900 text-sm">To-do</h2>
                </div>
                <span class="rounded-full bg-slate-200/60 px-2 py-0.5 text-xs font-semibold text-slate-600">
                    {{ $tasks->where('status', 'To do')->count() }}
                </span>
            </div>
            <div class="space-y-3 flex-1">
                @forelse ($tasks->where('status', 'To do') as $task)
                    <x-task-card :task="$task" />
                @empty
                    <div class="rounded-lg border border-dashed border-[#D6E5EC] bg-white p-6 text-center text-xs text-slate-400">
                        No tasks in To-do.
                    </div>
                @endforelse
            </div>
        </section>

        <!-- In-progress Column -->
        <section class="rounded-lg border border-[#D6E5EC] bg-slate-50/50 p-4 flex flex-col min-h-[400px]">
            <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <span class="h-2.5 w-2.5 rounded-full bg-blue-500"></span>
                    <h2 class="font-bold text-slate-900 text-sm">In-progress</h2>
                </div>
                <span class="rounded-full bg-blue-100/60 px-2 py-0.5 text-xs font-semibold text-blue-600">
                    {{ $tasks->where('status', 'In progress')->count() }}
                </span>
            </div>
            <div class="space-y-3 flex-1">
                @forelse ($tasks->where('status', 'In progress') as $task)
                    <x-task-card :task="$task"/>
                @empty
                    <div class="rounded-lg border border-dashed border-[#D6E5EC] bg-white p-6 text-center text-xs text-slate-400">
                        No tasks in In-progress.
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Done Column -->
        <section class="rounded-lg border border-[#D6E5EC] bg-slate-50/50 p-4 flex flex-col min-h-[400px]">
            <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <span class="h-2.5 w-2.5 rounded-full bg-green-500"></span>
                    <h2 class="font-bold text-slate-900 text-sm">Done</h2>
                </div>
                <span class="rounded-full bg-green-100/60 px-2 py-0.5 text-xs font-semibold text-green-600">
                    {{ $tasks->where('status', 'Done')->count() }}
                </span>
            </div>
            <div class="space-y-3 flex-1">
                @forelse ($tasks->where('status', 'Done') as $task)
                    <x-task-card :task="$task" />
                @empty
                    <div class="rounded-lg border border-dashed border-[#D6E5EC] bg-white p-6 text-center text-xs text-slate-400">
                        No completed tasks.
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
