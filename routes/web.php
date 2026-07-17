<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OAuthController; 
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskAssignmentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectMemberController;
use App\Http\Controllers\Admin\UserController;
use App\Models\Task;
use App\Http\Controllers\TimeLogController;


Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role === 1) {
        // Admin Dashboard
        $projectsCount = \App\Models\Project::where('created_by', auth()->id())->count();
        $tasksCount = Task::whereHas('milestone.project', function ($q) {
            $q->where('created_by', auth()->id());
        })->where('status', '!=', 'Completed')->count();
        $milestonesCount = \App\Models\Milestone::whereHas('project', function ($q) {
            $q->where('created_by', auth()->id());
        })->count();
        $hoursLogged = \App\Models\TimeLog::whereHas('task.milestone.project', function ($q) {
            $q->where('created_by', auth()->id());
        })->sum('hours_spent') ?: 0;

        $tasks = Task::whereHas('milestone.project', function ($q) {
    $q->where('created_by', auth()->id());
})->with(['project', 'timeLogs'])->get();

        return view('dashboard.admin', compact('projectsCount', 'tasksCount', 'milestonesCount', 'hoursLogged', 'tasks'));
    } else {
        // Member Dashboard
        $projectsCount = \App\Models\Project::whereHas('members', function ($q) {
            $q->where('user_id', auth()->id());
        })->count();
        $tasksCount = Task::whereHas('assignments', function ($q) {
            $q->where('user_id', auth()->id());
        })->where('status', '!=', 'Completed')->count();
        $milestonesCount = \App\Models\Milestone::whereHas('project.members', function ($q) {
            $q->where('user_id', auth()->id());
        })->count();
        $hoursLogged = \App\Models\TimeLog::where('user_id', auth()->id())->sum('hours_spent') ?: 0;

        // Fetch tasks assigned to the member
        $tasks = Task::whereHas('assignments', function ($q) {
    $q->where('user_id', auth()->id());
})->with(['project', 'timeLogs'])->get();
        return view('dashboard.member', compact('projectsCount', 'tasksCount', 'milestonesCount', 'hoursLogged', 'tasks'));
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Task Routes
    Route::resource('tasks', TaskController::class);

    Route::get('/teams', [ProjectMemberController::class, 'index'])->name('team.index');
    Route::resource('milestones', \App\Http\Controllers\WebMilestoneController::class);

    Route::post('/tasks/{task}/assign',
        [TaskAssignmentController::class, 'store']
    );

    Route::delete('/task-assignment/{assignment}',
        [TaskAssignmentController::class, 'destroy']
    );

    // Project Routes
    Route::resource('projects', ProjectController::class);

    // Project Member (Teams) Routes
    Route::get('/projects/{project}/members',
        [ProjectMemberController::class, 'index']
    );

    Route::post('/projects/{project}/members',
        [ProjectMemberController::class, 'store']
    );

    Route::patch('/project-members/{member}',
        [ProjectMemberController::class, 'update']
    );

    Route::delete('/project-members/{member}',
        [ProjectMemberController::class, 'destroy']
    );

    // Profile Routes
    Route::get('/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch('/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete('/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');

    // Time Log Routes
    Route::get('/time-logs', [TimeLogController::class, 'index'])->name('timelogs.index');
    Route::post('/tasks/{task}/time-logs', [TimeLogController::class, 'store'])->name('timelogs.store');

});
    
// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        return redirect()->route('dashboard');
    })->name('dashboard');

    Route::resource('users', UserController::class)
    ->only([
        'index',
        'show',
        'update',
        'destroy'
    ]);
});

require __DIR__.'/auth.php';