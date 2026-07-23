<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    // Show all projects
    public function index()
    {
        $query = Project::query();
        if (auth()->user()->role === 1) {
            $query->where('created_by', auth()->id());
        } else {
            $query->whereHas('members', function ($q) {
                $q->where('user_id', auth()->id());
            });
        }
        $projects = $query->with('milestones.tasks')->get();

        return view('projects.index', compact('projects'));
    }

    // Show create project form
    public function create()
    {
        if (auth()->user()->role !== 1) {
            abort(403, 'Unauthorized action.');
        }

        return view('projects.create');
    }

    // Create project
    public function store(Request $request)
    {
        if (auth()->user()->role !== 1) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status ?? 'Active',
            'created_by' => auth()->id(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];

        if ($request->hasFile('cover_image')) {
            // Stores in storage/app/public/covers and returns the path
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        Project::create($data);

        return redirect('/projects');
    }

    // Show one project
    public function show(Project $project)
    {
        // Scope project access: members can only see projects they belong to.
        if (auth()->user()->role !== 1) {
            $isMember = $project->members()->where('user_id', auth()->id())->exists();
            if (!$isMember) {
                abort(403, 'Unauthorized action.');
            }
        }

        $project->load(['milestones.tasks', 'members.user']);
    return view('projects.show', compact('project'));
    }

    // Show edit project form
    public function edit(Project $project)
    {
        if (auth()->user()->role !== 1) {
            abort(403, 'Unauthorized action.');
        }

        return view('projects.edit', compact('project'));
    }

    // Update project
    public function update(Request $request, Project $project)
    {
        if (auth()->user()->role !== 1) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'string|max:255',
            'description' => 'nullable|string',
            'status' => 'string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->only(['name', 'description', 'status', 'start_date', 'end_date']);

        if ($request->hasFile('cover_image')) {
            // Delete old cover image if it exists
            if ($project->cover_image && \Storage::disk('public')->exists($project->cover_image)) {
                \Storage::disk('public')->delete($project->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $project->update($data);

        return redirect('/projects');
    }

    // Delete project
    public function destroy(Project $project)
    {
        if (auth()->user()->role !== 1) {
            abort(403, 'Unauthorized action.');
        }

        $project->delete();

        return redirect('/projects');
    }
}