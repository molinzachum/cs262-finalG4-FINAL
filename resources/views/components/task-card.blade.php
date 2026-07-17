@props(['task'])
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex flex-col hover:shadow-md transition duration-150 ease-in-out gap-3">
    <a href="{{ route('tasks.show', $task) }}" class="flex-1">
        <div class="flex items-start justify-between gap-2">
            <span class="text-xs font-semibold text-[#2F5F73] uppercase tracking-wide">
                {{ $task->milestone?->project?->name ?? 'No Project' }}
            </span>
            @if($task->due_date)
                <span class="text-xs text-slate-500">
                    Due {{ \Carbon\Carbon::parse($task->due_date)->format('M d') }}
                </span>
            @endif
        </div>
        <div class="mt-2">
            <h3 class="font-semibold text-slate-900 leading-snug line-clamp-1">
                {{ $task->title }}
            </h3>
            <p class="mt-1 text-sm text-slate-500 line-clamp-2">
                {{ $task->desc ?? 'No description provided.' }}
            </p>
        </div>
        <p class="mt-2 text-xs font-medium text-slate-400">
            {{ number_format($task->timeLogs->sum('hours_spent'), 2) }} hrs logged
        </p>
    </a>
    <div class="flex items-center justify-between pt-3 border-t border-slate-100 text-xs">
        <span class="inline-flex items-center rounded-md px-2 py-1 font-medium ring-1 ring-inset {{
            $task->priority === 'High' ? 'bg-red-50 text-red-700 ring-red-600/10' :
            ($task->priority === 'Medium' ? 'bg-amber-50 text-amber-700 ring-amber-600/10' :
            'bg-slate-50 text-slate-700 ring-slate-600/10')
        }}">
            {{ $task->priority ?? 'Medium' }}
        </span>

       <form method="POST" action="{{ route('tasks.update', $task) }}">
    @csrf
    @method('PATCH')
    @if ($task->status === 'To-do')
        <input type="hidden" name="status" value="In-progress">
        <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-[#2F5F73] px-4 py-2 text-sm font-semibold text-white hover:bg-[#244B5C] transition">
            Start
        </button>
    @elseif ($task->status === 'In-progress')
        <input type="hidden" name="status" value="Done">
        <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700 transition">
            Complete
        </button>
    @elseif ($task->status === 'Done')
        <input type="hidden" name="status" value="To-do">
        <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-slate-500 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-600 transition">
            Reopen
        </button>
    @endif
</form>
    </div>
</div>