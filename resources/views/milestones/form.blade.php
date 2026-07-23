<div class="space-y-5">

    <div>
        <label for="project_id" class="block text-sm font-semibold text-slate-700">
            Project
        </label>

        <select
            id="project_id"
            name="project_id"
            required
            class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-[#7FA8BA] focus:ring-[#7FA8BA] text-sm p-2 border"
        >
            <option value="">Select a project</option>

            @foreach ($projects as $project)
                <option
                    value="{{ $project->id }}"
                    @selected((string) old('project_id', $milestone?->project_id) === (string) $project->id)
                >
                    {{ $project->name }}
                </option>
            @endforeach

        </select>

        <x-input-error :messages="$errors->get('project_id')" class="mt-2" />
    </div>


    <div>
        <label for="title" class="block text-sm font-semibold text-slate-700">
            Milestone Title
        </label>

        <input
            id="title"
            name="title"
            type="text"
            value="{{ old('title', $milestone?->title) }}"
            required
            class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-[#7FA8BA] focus:ring-[#7FA8BA] text-sm p-2 border"
        >

        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>


    <div>
        <label for="description" class="block text-sm font-semibold text-slate-700">
            Description
        </label>

        <textarea
            id="description"
            name="description"
            rows="6"
            class="rich-editor mt-1 block w-full rounded-lg border-slate-300 shadow-sm text-sm p-2 border"
        >{{ old('description', $milestone?->description) }}</textarea>

        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>


    <div class="grid gap-4 sm:grid-cols-2">

        <div>
            <label for="status" class="block text-sm font-semibold text-slate-700">
                Status
            </label>

            <select
                id="status"
                name="status"
                required
                class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-[#7FA8BA] focus:ring-[#7FA8BA] text-sm p-2 border"
            >
                @foreach (['Not started', 'In progress', 'Completed'] as $status)
                    <option
                        value="{{ $status }}"
                        @selected(old('status', $milestone?->status ?? 'Not started') === $status)
                    >
                        {{ $status }}
                    </option>
                @endforeach
            </select>

            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>


        <div>
            <label for="due_date" class="block text-sm font-semibold text-slate-700">
                Due Date
            </label>

            <input
                id="due_date"
                name="due_date"
                type="date"
                value="{{ old('due_date', $milestone?->due_date ? \Carbon\Carbon::parse($milestone->due_date)->format('Y-m-d') : '') }}"
                class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-[#7FA8BA] focus:ring-[#7FA8BA] text-sm p-2 border"
            >

            <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
        </div>

    </div>


    <div class="flex items-center gap-3 pt-2">

        <button
            type="submit"
            class="rounded-lg bg-[#2F5F73] px-4 py-2 text-sm font-semibold text-white hover:bg-[#244B5C]"
        >
            Save Milestone
        </button>

        <a
            href="{{ route('milestones.index') }}"
            class="rounded-lg border border-[#D6E5EC] px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-[#EEF6FA]"
        >
            Cancel
        </a>

    </div>

</div>