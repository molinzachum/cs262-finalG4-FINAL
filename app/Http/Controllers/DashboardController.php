<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\Milestone;
use App\Models\TimeLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 1) {
            return $this->adminDashboard();
        }

        return $this->memberDashboard();
    }

    private function adminDashboard()
    {
        $projectsCount = Project::where('created_by', auth()->id())->count();

        $tasksCount = Task::whereHas('milestone.project', function ($q) {
            $q->where('created_by', auth()->id());
        })->where('status', '!=', 'Done')->count();

        $milestonesCount = Milestone::whereHas('project', function ($q) {
            $q->where('created_by', auth()->id());
        })->count();

        $hoursLogged = TimeLog::whereHas('task.milestone.project', function ($q) {
            $q->where('created_by', auth()->id());
        })->sum('hours_spent');

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

        $tasksTotal = $tasks->count();
        $projectsActive = Project::where('created_by', auth()->id())
            ->where('status', 'In progress')
            ->count();
        $milestonesInProgress = Milestone::whereHas('project', function ($q) {
            $q->where('created_by', auth()->id());
        })->where('status', 'In progress')->count();

        $progress = $this->adminProgress();

        return view('dashboard.admin', compact(
            'projectsCount',
            'tasksCount',
            'milestonesCount',
            'hoursLogged',
            'tasks',
            'progress',
            'tasksTotal',
            'projectsActive',
            'milestonesInProgress'
        ));
    }

    private function memberDashboard()
    {

        $projectsCount = Project::whereHas('members', function ($q) {
            $q->where('user_id', auth()->id());
        })->count();

        $tasksCount = Task::whereHas('assignments', function ($q) {
            $q->where('user_id', auth()->id());
        })->count();

        $milestonesCount = Milestone::whereHas('project.members', function ($q) {
            $q->where('user_id', auth()->id());
        })->count();

        $hoursLogged = TimeLog::where('user_id', auth()->id())->sum('hours_spent');

        $tasks = Task::whereHas('assignments', function ($q) {
            $q->where('user_id', auth()->id());
        })
            ->with([
                'assignments.user',
                'creator',
                'milestone.project',
                'timeLogs',
            ])
            ->get();
        $tasksDone = $tasks->where('status', 'Done')->count();
        $projectsDone = Project::whereHas('members', function ($q) {
            $q->where('user_id', auth()->id());
        })
            ->where('status', 'Completed')
            ->count();
        $progress = $this->memberProgress();
        $milestonesDone = Milestone::whereHas('project.members', function ($q) {
            $q->where('user_id', auth()->id());
        })->where('status', 'Completed')->count();

        return view('dashboard.member', compact(
            'projectsCount',
            'tasksCount',
            'milestonesCount',
            'hoursLogged',
            'tasks',
            'progress',
            'tasksDone',
            'projectsDone',
            'milestonesDone'
        ));
    }

    private function percentage($completed, $total)
    {
        return $total > 0
            ? round(($completed / $total) * 100)
            : 0;
    }

    private function memberProgress()
    {
        $totalTasks = Task::whereHas('assignments', function ($q) {
            $q->where('user_id', auth()->id());
        })->count();

        $openTasks = Task::whereHas('assignments', function ($q) {
            $q->where('user_id', auth()->id());
        })->where('status', 'Done')->count();

        $totalProjects = Project::whereHas('members', function ($q) {
            $q->where('user_id', auth()->id());
        })->count();

        $openProjects = Project::whereHas('members', function ($q) {
            $q->where('user_id', auth()->id());
        })->where('status', 'Completed')->count();

        $totalMilestones = Milestone::whereHas('project.members', function ($q) {
            $q->where('user_id', auth()->id());
        })->count();

        $openMilestones = Milestone::whereHas('project.members', function ($q) {
            $q->where('user_id', auth()->id());
        })
            ->where('status', 'Completed')
            ->count();

        return [
            'tasks' => $this->percentage($openTasks, $totalTasks),
            'projects' => $this->percentage($openProjects, $totalProjects),
            'milestones' => $this->percentage($openMilestones, $totalMilestones),
            'hours' => 100
        ];
    }

    private function adminProgress()
    {
        $totalTasks = Task::whereHas('milestone.project', function ($q) {
            $q->where('created_by', auth()->id());
        })->count();


        $openTasks = Task::whereHas('milestone.project', function ($q) {
            $q->where('created_by', auth()->id());
        })->where('status', '!=' ,'Done')->count();


        $totalProjects = Project::where('created_by', auth()->id())
            ->count();


        $openProjects = Project::where('created_by', auth()->id())
            ->where('status', 'In progress')
            ->count();

        $totalMilestones = Milestone::whereHas('project', function ($q) {
            $q->where('created_by', auth()->id());
        })->count();

        $openMilestones = Milestone::whereHas('project', function ($q) {
            $q->where('created_by', auth()->id());
        })
            ->where('status', '!=', 'Completed')
            ->count();

        return [
            'tasks' => $this->percentage($openTasks, $totalTasks),
            'projects' => $this->percentage($openProjects, $totalProjects),
            'milestones' => $this->percentage($openMilestones, $totalMilestones),
            'hours' => 100
        ];
    }
}