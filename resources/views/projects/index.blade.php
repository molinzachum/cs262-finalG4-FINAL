<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-slate-600">Projects</p>
                <h1 class="text-2xl font-bold text-slate-950">Project Screen</h1>
            </div>
            @if(auth()->user()->role === 1)
                <a href="{{ route('projects.create') }}" class="inline-flex items-center justify-center rounded-lg bg-[#2F5F73] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#244B5C]">
                    Create Project
                </a>
            @endif
        </div>
    </x-slot>

    @if (session('status'))
        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 shadow-sm">{{ session('status') }}</div>
    @endif

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($projects as $project)
            <article class="rounded-lg border border-[#D6E5EC] bg-white shadow-sm flex flex-col justify-between overflow-hidden">
                @if ($project->cover_image)
                    <img src="{{ asset('storage/' . $project->cover_image) }}" alt="{{ $project->name }} cover" class="h-40 w-full object-cover">
                @endif
                <div class="p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-950">{{ $project->name }}</h2>
                            <p class="mt-1 text-sm text-slate-500">{{ $project->status }}</p>
                        </div>
                        <span class="rounded-full bg-[#C4D8E2] px-3 py-1 text-xs font-semibold text-slate-800">Project</span>
                    </div>
                    <p class="mt-4 min-h-12 text-sm leading-6 text-slate-600">{{ $project->description ?: 'No description yet.' }}</p>
                    <dl class="mt-4 grid grid-cols-2 gap-3 text-sm border-t border-slate-100 pt-3">
                        <div>
                            <dt class="text-slate-500">Start</dt>
                            <dd class="font-medium text-slate-900">{{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('Y-m-d') : 'Not set' }}</dd>
                        </div>
                        <div>
                            <dt class="text-slate-500">Due</dt>
                            <dd class="font-medium text-slate-900">{{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('Y-m-d') : 'Not set' }}</dd>
                        </div>
                    </dl>
                </div>
                <div class="flex items-center gap-2 border-t border-slate-100 pt-3 px-5 pb-5">
                    <a href="{{ route('projects.show', $project) }}" class="rounded-lg border border-[#D6E5EC] px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-[#EEF6FA]">View</a>
                    @if(auth()->user()->role === 1)
                        <a href="{{ route('projects.edit', $project) }}" class="rounded-lg border border-[#D6E5EC] px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-[#EEF6FA]">Edit</a>
                        <form method="POST" action="{{ route('projects.destroy', $project) }}" onsubmit="return confirm('Are you sure you want to delete this project?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg border border-red-200 px-3 py-2 text-sm font-semibold text-red-600 hover:bg-red-50">Delete</button>
                        </form>
                    @endif
                </div>
            </article>
        @empty
            <div class="col-span-full rounded-lg border border-[#D6E5EC] bg-white p-8 text-center text-slate-500">
                No projects found. Click "Create Project" to get started!
            </div>
        @endforelse
    </div>
</x-app-layout>
