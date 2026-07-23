<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\Milestone;

class TaskController extends Controller
{
    // Display all tasks
    public function index()
    {
        $tasks = Task::whereHas('milestone.project', function ($query) {
            $query->where('created_by', auth()->id())
                ->orWhereHas('members', function ($q) {
                    $q->where('user_id', auth()->id());
                });
        })
            ->with([
                'assignments.user',
                'creator',
                'milestone.project',
                'timeLogs',
            ])
            ->get();

        return view('tasks.index', compact('tasks'));
    }
    // Create task
    public function store(Request $request)
    {
        $request->validate([
            'milestone_id' => 'required|exists:milestones,id',
            'title' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'priority' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $milestone = Milestone::findOrFail($request->milestone_id);
        $project = $milestone->project;
        if ((int) auth()->user()->role !== 1) {
            $isMember = $project->members()->where('user_id', auth()->id())->exists();
            $isOwner = (int) $project->created_by == (int) auth()->id();
            if (!$isMember && !$isOwner) {
                abort(403, 'Unauthorized action.');
            }
        }

        Task::create([
            'milestone_id' => $request->milestone_id,
            'title' => $request->title,
            'desc' => $request->desc,
            'status' => 'To do',
            'priority' => $request->priority ?? 'Medium',
            'due_date' => $request->due_date,
            'created_by' => auth()->id(),
        ]);

        return redirect('/tasks');
    }

    // Show single task
    public function show(Task $task)
    {
        if ((int) auth()->user()->role !== 1) {
            $project = $task->milestone->project;
            $isMember = $project->members()->where('user_id', auth()->id())->exists();
            $isAssignee = $task->assignments()->where('user_id', auth()->id())->exists();
            $isCreator = (int) $task->created_by == (int) auth()->id();

            if (!$isMember && !$isAssignee && !$isCreator) {
                abort(403, 'Unauthorized action.');
            }
        }

        $task->load([
            'assignments.user',
            'milestone.project',
            'timeLogs',
        ]);

        return view('tasks.show', compact('task'));
    }


    // Update task
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'milestone_id' => 'sometimes|required|exists:milestones,id',
            'title' => 'sometimes|required|string|max:255',
            'desc' => 'nullable|string',
            'status' => 'sometimes|required|in:To do,In progress,Done',
            'priority' => 'sometimes|required|string',
            'due_date' => 'nullable|date',
        ]);

        if ($request->has('milestone_id')) {
            $milestone = Milestone::findOrFail($request->milestone_id);
            if ((int) auth()->user()->role !== 1) {
                $isMember = $milestone->project->members()->where('user_id', auth()->id())->exists();
                $isOwner = (int) $milestone->project->created_by == (int) auth()->id();
                if (!$isMember && !$isOwner) {
                    abort(403, 'Unauthorized action.');
                }
            }
        }

        $task->update($request->only([
            'milestone_id',
            'title',
            'desc',
            'status',
            'priority',
            'due_date',
        ]));

        return redirect()->route('tasks.index')->with('status', 'Task updated successfully!');
    }

    // Delete task
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect('/tasks');
    }

    public function create()
    {
        $milestones = Milestone::whereHas('project', function ($query) {
            $query->where('created_by', auth()->id())
                ->orWhereHas('members', function ($q) {
                    $q->where('user_id', auth()->id());
                });
        })->get();

        return view('tasks.create', compact('milestones'));
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        $milestones = Milestone::whereHas('project', function ($query) {
            $query->where('created_by', auth()->id())
                ->orWhereHas('members', function ($q) {
                    $q->where('user_id', auth()->id());
                });
        })->get();

        return view('tasks.edit', compact('task', 'milestones'));
    }
}