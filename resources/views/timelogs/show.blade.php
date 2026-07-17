<section class="rounded-lg border border-[#D6E5EC] bg-white p-6 shadow-sm">
    <h2 class="mb-3 font-semibold text-slate-950">Log time</h2>
    <form method="POST" action="{{ route('timelogs.store', $task) }}" class="flex flex-wrap items-end gap-3">
        @csrf
        <div>
            <label class="text-xs font-medium text-slate-600">Date</label>
            <input type="date" name="log_date" required value="{{ old('log_date', date('Y-m-d')) }}"
                   class="mt-1 block rounded-lg border-slate-300 text-sm">
        </div>
        <div>
            <label class="text-xs font-medium text-slate-600">Hours</label>
            <input type="number" step="0.25" min="0.25" name="hours_spent" required value="{{ old('hours_spent') }}"
                   class="mt-1 block w-24 rounded-lg border-slate-300 text-sm">
        </div>
        <div class="flex-1 min-w-[160px]">
            <label class="text-xs font-medium text-slate-600">Notes</label>
            <input type="text" name="notes" value="{{ old('notes') }}"
                   class="mt-1 block w-full rounded-lg border-slate-300 text-sm">
        </div>
        <button type="submit"
                class="rounded-lg bg-[#2F5F73] px-4 py-2 text-sm font-semibold text-white hover:bg-[#244B5C]">
            Log time
        </button>
    </form>

    @error('hours_spent') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    @error('log_date') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror

    @if($task->timeLogs->isNotEmpty())
        <ul class="mt-4 space-y-1 border-t border-slate-100 pt-3 text-sm">
            @foreach($task->timeLogs as $log)
                <li class="flex justify-between text-slate-600">
                    <span>{{ $log->user->name }} — {{ $log->log_date->format('M j') }}</span>
                    <span>{{ $log->hours_spent }}h</span>
                </li>
            @endforeach
        </ul>
    @endif
</section>