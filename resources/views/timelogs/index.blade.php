<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-medium text-slate-600">Tracking</p>
            <h1 class="text-2xl font-bold text-slate-950">Time Logs</h1>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4 rounded-lg border border-[#D6E5EC] bg-white p-4 shadow-sm w-fit">
        <p class="text-sm text-slate-500">Hours logged this week</p>
        <p class="mt-1 text-2xl font-bold text-slate-950">{{ number_format($thisWeek, 2) }}h</p>
    </div>

    <section class="overflow-hidden rounded-lg border border-[#D6E5EC] bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-[#EEF6FA] text-left text-xs font-semibold uppercase text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Task</th>
                        <th class="px-4 py-3">Notes</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Hours</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($logs as $log)
                        <tr>
                            <td class="px-4 py-4">
                                <a href="{{ route('tasks.show', $log->task) }}" class="font-semibold text-slate-950 hover:text-[#2F5F73]">
                                    {{ $log->task->title }}
                                </a>
                            </td>
                            <td class="px-4 py-4 max-w-md text-slate-500">{{ $log->notes ?: 'No notes.' }}</td>
                            <td class="px-4 py-4 text-slate-700">{{ $log->log_date->format('M j, Y') }}</td>
                            <td class="px-4 py-4 font-semibold text-slate-900">{{ number_format($log->hours_spent, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-slate-400">No time logged yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-app-layout>