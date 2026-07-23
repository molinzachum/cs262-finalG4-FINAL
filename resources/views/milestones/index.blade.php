
@php
    use Illuminate\Support\Str;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-slate-600">Milestones</p>
                <h1 class="text-2xl font-bold text-slate-950">Milestone Screen</h1>
            </div>
            <a href="{{ route('milestones.create') }}" class="inline-flex items-center justify-center rounded-lg bg-[#2F5F73] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#244B5C]">
                Create Milestone
            </a>
        </div>
    </x-slot>

    @if (session('status'))
        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 shadow-sm">{{ session('status') }}</div>
    @endif

    <section class="overflow-hidden rounded-lg border border-[#D6E5EC] bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-[#EEF6FA] text-left text-xs font-semibold uppercase text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Milestone</th>
                        <th class="px-4 py-3">Project</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Due date</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($milestones as $milestone)
                        <tr>
                            <td class="px-4 py-4">
                                <p class="font-semibold text-slate-950">{{ $milestone->title }}</p>
                                <p class="mt-1 max-w-md text-xs text-slate-500">
    {{
        $milestone->description
            ? Str::limit(
                html_entity_decode(strip_tags($milestone->description)),
                100
            )
            : 'No description.'
    }}
</p>
                            </td>
                            <td class="px-4 py-4 text-slate-700 font-medium">{{ $milestone->project?->name ?: 'No project' }}</td>
                            <td class="px-4 py-4">
                                <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold ring-1 ring-inset {{
                                    $milestone->status === 'Completed' ? 'bg-green-50 text-green-700 ring-green-600/20' :
                                    ($milestone->status === 'In progress' ? 'bg-blue-50 text-blue-700 ring-blue-600/20' :
                                    'bg-slate-50 text-slate-700 ring-slate-600/20')
                                }}">{{ $milestone->status }}</span>
                            </td>
                            <td class="px-4 py-4 text-slate-500">
                                {{ $milestone->due_date ? \Carbon\Carbon::parse($milestone->due_date)->format('Y-m-d') : 'Not set' }}
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex justify-end gap-2 items-center">
                                    <a href="{{ route('milestones.edit', $milestone) }}" class="rounded-lg border border-[#D6E5EC] px-3 py-2 font-semibold text-slate-700 hover:bg-[#EEF6FA]">Edit</a>
                                    <form method="POST" action="{{ route('milestones.destroy', $milestone) }}" onsubmit="return confirm('Are you sure you want to delete this milestone?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-red-200 px-3 py-2 font-semibold text-red-600 hover:bg-red-50">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-slate-500">
                                No milestones found. Click "Create Milestone" to add one!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-app-layout>
