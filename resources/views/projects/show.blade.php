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

    @if ($project->cover_image)
        <div class="mb-6 overflow-hidden rounded-lg border border-[#D6E5EC] shadow-sm">
            <img src="{{ asset('storage/' . $project->cover_image) }}" alt="{{ $project->name }} cover image" class="h-64 w-full object-cover">
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-3">
        <section class="rounded-lg border border-[#D6E5EC] bg-white p-6 shadow-sm lg:col-span-2">
            <h2 class="text-lg font-semibold text-slate-950">Overview</h2>

           <div class="rte-content mt-3 text-sm leading-6 text-slate-600">
    @if($project->description)
        {!! $project->description !!}
    @else
        No description yet.
    @endif
</div>

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

                        <div>
                <h3 class="text-md font-semibold text-slate-950 mt-6 mb-3">Milestones</h3>
                <div class="space-y-3">
                    @forelse ($project->milestones as $milestone)
                        @php
                            $total = $milestone->tasks->count();
                            $done = $milestone->tasks->where('status', 'Done')->count();
                            $pct = $total > 0 ? round(($done / $total) * 100) : 0;
                        @endphp
                        <div class="rounded-lg border border-slate-100 p-4">
                            <div class="flex items-center justify-between">
                                <p class="font-medium text-slate-900">{{ $milestone->title }}</p>
                                <span class="text-xs text-slate-500">
                                    {{ $milestone->due_date ? \Carbon\Carbon::parse($milestone->due_date)->format('M j') : 'No due date' }}
                                </span>
                            </div>
                            <div class="mt-2 flex items-center gap-3">
                                <div class="h-1.5 flex-1 rounded-full bg-slate-100">
                                    <div class="h-1.5 rounded-full bg-[#2F5F73]" style="width: {{ $pct }}%"></div>
                                </div>
                                <span class="text-xs text-slate-500 whitespace-nowrap">{{ $done }}/{{ $total }} tasks</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-400">No milestones yet.</p>
                    @endforelse
                </div>
            </div>

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

                <div class="rounded-lg border border-[#D6E5EC] bg-white p-5 shadow-sm">
                <h3 class="text-sm font-bold text-slate-950">Team</h3>
                <div class="mt-4 space-y-3">
                    @forelse ($project->members as $member)
                        <div class="flex items-center gap-3 text-sm">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#C4D8E2] text-xs font-bold text-slate-800">
                                {{ strtoupper(substr($member->user->name, 0, 1)) }}
                            </span>
                            <div class="flex-1">
                                <p class="font-medium text-slate-900">{{ $member->user->name }}</p>
                                <p class="text-xs text-slate-500">{{ $member->member_role ?? 'Member' }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400">No team members added.</p>
                    @endforelse
                </div>
            </div>
            </dl>
        </aside>
    </div>
</x-app-layout>