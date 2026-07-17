<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-slate-600">Project Details</p>
                <h1 class="text-2xl font-bold text-slate-950">{{ $project->name }}</h1>
            </div>
            <a href="{{ route('projects.edit', $project) }}" class="inline-flex items-center justify-center rounded-lg bg-[#2F5F73] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#244B5C]">Edit Project</a>
        </div>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-3">
        <section class="rounded-lg border border-[#D6E5EC] bg-white p-6 shadow-sm lg:col-span-2">
            <h2 class="text-lg font-semibold text-slate-950">Overview</h2>
            <p class="mt-3 text-sm leading-6 text-slate-600">{{ $project->description ?: 'No description yet.' }}</p>

            @if($project->tasks && $project->tasks->count() > 0)
                <h3 class="text-md font-semibold text-slate-950 mt-6 mb-3">Tasks</h3>
                <div class="space-y-2">
                    @foreach ($project->tasks as $task)
                        <div class="flex items-center justify-between border-b border-slate-100 py-2">
                            <span class="text-sm text-slate-800">{{ $task->title }}</span>
                            <span class="text-xs px-2 py-0.5 rounded {{ $task->status === 'Completed' || $task->status === 'Done' ? 'bg-green-50 text-green-700' : 'bg-slate-50 text-slate-700' }}">
                                {{ $task->status }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
        <aside class="rounded-lg border border-[#D6E5EC] bg-white p-6 shadow-sm">
            <dl class="space-y-4 text-sm">
                <div>
                    <dt class="text-slate-500">Status</dt>
                    <dd class="font-semibold text-slate-900">{{ $project->status }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Start date</dt>
                    <dd class="font-semibold text-slate-900">
                        {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('Y-m-d') : 'Not set' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-slate-500">Due date</dt>
                    <dd class="font-semibold text-slate-900">
                        {{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('Y-m-d') : 'Not set' }}
                    </dd>
                </div>
            </dl>
        </aside>
    </div>
</x-app-layout>
