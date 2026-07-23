<div class="space-y-5">

    <div>
        <label for="name" class="block text-sm font-semibold text-slate-700">
            Project name
        </label>

        <input
            id="name"
            name="name"
            type="text"
            value="{{ old('name', $project?->name) }}"
            required
            class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-[#7FA8BA] focus:ring-[#7FA8BA] text-sm p-2 border"
        >

        <x-input-error :messages="$errors->get('name')" class="mt-2" />
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
        >{{ old('description', $project?->description) }}</textarea>

        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>


    <div class="grid gap-4 sm:grid-cols-3">

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
                @foreach(['Planning', 'In progress', 'On hold', 'Completed'] as $status)

                    <option
                        value="{{ $status }}"
                        @selected(old('status', $project?->status ?? 'Planning') === $status)
                    >
                        {{ $status }}
                    </option>

                @endforeach
            </select>

            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>


        <div>
            <label for="start_date" class="block text-sm font-semibold text-slate-700">
                Start date
            </label>

            <input
                id="start_date"
                name="start_date"
                type="date"
                value="{{ old('start_date', $project?->start_date ? \Carbon\Carbon::parse($project->start_date)->format('Y-m-d') : '') }}"
                class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm text-sm p-2 border"
            >

            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
        </div>


        <div>
            <label for="end_date" class="block text-sm font-semibold text-slate-700">
                Due date
            </label>

            <input
                id="end_date"
                name="end_date"
                type="date"
                value="{{ old('end_date', $project?->end_date ? \Carbon\Carbon::parse($project->end_date)->format('Y-m-d') : '') }}"
                class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm text-sm p-2 border"
            >

            <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
        </div>

    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700">Project cover image</label>
        
        <div x-data="{ photoName: null, photoPreview: null }" class="mt-1">
            <!-- Hidden File Input -->
            <input type="file" id="cover_image" name="cover_image" class="hidden"
                   accept="image/*"
                   x-ref="photo"
                   x-on:change="
                       photoName = $refs.photo.files[0].name;
                       const reader = new FileReader();
                       reader.onload = (e) => { photoPreview = e.target.result; };
                       reader.readAsDataURL($refs.photo.files[0]);
                   ">

            <div class="flex items-center gap-4">
                <!-- Current Cover Image (when editing an existing project) -->
                <div x-show="!photoPreview" class="relative flex h-24 w-40 items-center justify-center overflow-hidden rounded-lg border border-slate-300 bg-slate-50">
                    @if ($project?->cover_image)
                        <img src="{{ asset('storage/' . $project->cover_image) }}" alt="Cover preview" class="h-full w-full object-cover">
                    @else
                        <svg class="h-8 w-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    @endif
                </div>

                <!-- New Image Live Preview -->
                <div x-show="photoPreview" style="display: none;" class="relative h-24 w-40 overflow-hidden rounded-lg border border-slate-300">
                    <span class="block h-full w-full bg-cover bg-center"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <!-- Trigger Button -->
                <button type="button" x-on:click="$refs.photo.click()" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-[#7FA8BA]">
                    Select Cover Image
                </button>
            </div>

            <x-input-error :messages="$errors->get('cover_image')" class="mt-2" />
        </div>
    </div>

    <div class="flex items-center gap-3 pt-2">

        <button
            type="submit"
            class="rounded-lg bg-[#2F5F73] px-4 py-2 text-sm font-semibold text-white hover:bg-[#244B5C]"
        >
            Save Project
        </button>


        <a
            href="{{ route('projects.index') }}"
            class="rounded-lg border border-[#D6E5EC] px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-[#EEF6FA]"
        >
            Cancel
        </a>

    </div>
    
</div>
