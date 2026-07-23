<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-slate-600">Tasks</p>
                <h1 class="text-2xl font-bold text-slate-950">Create Task</h1>
            </div>
            <a href="{{ route('tasks.index') }}" class="inline-flex items-center justify-center rounded-lg border border-[#D6E5EC] bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-[#EEF6FA] transition">
                Back to Tasks
            </a>
        </div>
    </x-slot>

    <div class="max-w-xl mx-auto rounded-lg border border-[#D6E5EC] bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('tasks.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="milestone_id" class="block text-sm font-semibold text-slate-700">Milestone</label>
                <select id="milestone_id" name="milestone_id" required class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-[#7FA8BA] focus:ring-[#7FA8BA] text-sm p-2 border bg-white">
                    <option value="">-- Select Milestone --</option>
                    @foreach($milestones as $milestone)
                        <option value="{{ $milestone->id }}" @selected(old('milestone_id') == $milestone->id)>
                            {{ $milestone->project->name }} - {{ $milestone->title }}
                        </option>
                    @endforeach
                </select>
                @error('milestone_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="title" class="block text-sm font-semibold text-slate-700">Task Title</label>
                <input id="title" type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. Design database schema" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-[#7FA8BA] focus:ring-[#7FA8BA] text-sm p-2 border">
                @error('title') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="desc" class="block text-sm font-semibold text-slate-700">Description</label>

                <textarea
    id="desc"
    name="desc"
    class="rich-editor mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-[#7FA8BA] focus:ring-[#7FA8BA] text-sm p-2 border"
    rows="4"
    placeholder="Briefly describe the task goals..."
>{{ old('desc') }}</textarea>

                @error('desc') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="priority" class="block text-sm font-semibold text-slate-700">Priority</label>
                <select id="priority" name="priority" required class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-[#7FA8BA] focus:ring-[#7FA8BA] text-sm p-2 border bg-white">
                    <option value="Low" @selected(old('priority') == 'Low')>Low</option>
                    <option value="Medium" @selected(old('priority', 'Medium') == 'Medium')>Medium</option>
                    <option value="High" @selected(old('priority') == 'High')>High</option>
                </select>
                @error('priority') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="due_date" class="block text-sm font-semibold text-slate-700">Due Date</label>
                <input id="due_date" type="date" name="due_date" value="{{ old('due_date') }}" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-[#7FA8BA] focus:ring-[#7FA8BA] text-sm p-2 border">
                @error('due_date') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="pt-2">
                <button type="submit" class="rounded-lg bg-[#2F5F73] px-4 py-2 text-sm font-semibold text-white hover:bg-[#244B5C] transition">
                    Create Task
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
