<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
             <div>
                 <p class="text-sm font-medium text-slate-600">Workspace</p>
                 <div class="flex items-center gap-3 mt-1">
                     <h1 class="text-2xl font-bold text-slate-950">Teams</h1>
                     @if($projects->count() > 0)
                         <form method="GET" action="{{ route('team.index') }}" class="inline-block">
                             <select name="project_id" onchange="this.form.submit()" class="rounded-lg border-slate-300 shadow-sm focus:border-[#7FA8BA] focus:ring-[#7FA8BA] text-sm p-1.5 border bg-white">
                                 @foreach($projects as $proj)
                                     <option value="{{ $proj->id }}" @selected($project && $project->id === $proj->id)>
                                         {{ $proj->name }}
                                     </option>
                                 @endforeach
                             </select>
                         </form>
                     @else
                         <span class="text-slate-500 text-sm">(No projects created yet)</span>
                     @endif
                 </div>
             </div>
        </div>
    </x-slot>

    <div class="grid gap-6 xl:grid-cols-[1fr_360px]">
        <section class="overflow-hidden rounded-lg border border-[#D6E5EC] bg-white shadow-sm">
            <div class="border-b border-[#D6E5EC] px-5 py-4 flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-slate-950">Team Members</h2>
                    <p class="mt-1 text-sm text-slate-500">Manage team members access and roles for this project.</p>
                </div>
                <div class="text-sm text-slate-500">
                    Total: <span class="font-semibold text-slate-950">{{ $members->count() }}</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-[#EEF6FA] text-left text-xs font-semibold uppercase text-slate-500">
                        <tr>
                            <th class="px-5 py-3">Member</th>
                            <th class="px-5 py-3">Role</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($members as $member)
                            <tr>
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($member->user->profile_picture)
                                            <img src="{{ asset('storage/' . $member->user->profile_picture) }}" alt="{{ $member->user->name }} profile picture" class="h-10 w-10 rounded-lg object-cover">
                                        @else
                                            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#C4D8E2] text-sm font-bold text-slate-800">
                                                {{ strtoupper(substr($member->user->name, 0, 1)) }}
                                            </span>
                                        @endif
                                        <div>
                                            <p class="font-semibold text-slate-950">{{ $member->user->name }}</p>
                                            <p class="text-slate-500 text-xs">{{ $member->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-slate-700">{{ $member->member_role }}</td>
                                <td class="px-5 py-4">
                                    <span class="rounded-full bg-green-50 px-2 py-0.5 text-xs font-semibold text-green-700 ring-1 ring-inset ring-green-600/20">Active</span>
                                </td>
                                <td class="px-5 py-4">
                                    @if(auth()->user()->role === 1)
                                        <div class="flex justify-end gap-2">
                                            <form method="POST" action="/project-members/{{ $member->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-lg border border-red-200 px-3 py-2 font-semibold text-red-600 hover:bg-red-50 text-xs">Remove</button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        @if($project && auth()->user()->role === 1)
            <aside class="rounded-lg border border-[#D6E5EC] bg-white p-5 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-950">Add Member</h2>
                <form method="POST" action="/projects/{{ $project->id }}/members" class="mt-5 space-y-4">
                    @csrf
                    <div>
                        <label for="user_id" class="block text-sm font-semibold text-slate-700">Choose User</label>
                        <select id="user_id" name="user_id" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-[#7FA8BA] focus:ring-[#7FA8BA] text-sm p-2 border">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="member_role" class="block text-sm font-semibold text-slate-700">Role</label>
                        <select id="member_role" name="member_role" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-[#7FA8BA] focus:ring-[#7FA8BA] text-sm p-2 border">
                            <option value="Admin">Admin</option>
                            <option value="Developer">Developer</option>
                            <option value="Designer">Designer</option>
                            <option value="Tester">Tester</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full rounded-lg bg-[#2F5F73] px-4 py-2 text-sm font-semibold text-white hover:bg-[#244B5C]">Add to Project</button>
                </form>
            </aside>
        @endif
    </div>
</x-app-layout>
