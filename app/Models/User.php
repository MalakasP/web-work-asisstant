<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use \App\Models\Worktime;
use \App\Models\Task;
use \App\Models\Project;
use \App\Models\Team;
use \App\Models\Request;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'manager'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the tasks created by the user.
     */
    public function createdTasks()
    {
        return $this->hasMany(Task::class, 'reporter_id')->whereNull('project_id')->orderBy('created_at');
    }

    /**
     * Get the teams that user is in.
     */
    public function onlyTeamsId()
    {
        return $this->belongsToMany(Team::class, 'team_user', 'user_id', 'team_id')->select(['team_id']);
    }

    /**
     * Get the worktimes for the user.
     */
    public function worktimes()
    {
        return $this->hasMany(Worktime::class, 'user_id')->orderBy('created_at');
    }

    /**
     * Get the tasks assigned for the user.
     */
    public function assignedTasks()
    {
        return $this->hasMany(Task::class, 'assignee_id')->whereNull('project_id')->orderBy('created_at');
    }

    /**
     * Get all the projects user is envolved with.
     */
    public function projects()
    {
        $projects = Project::where('author_id', $this->id)->get();

        foreach ($this->teams as $team) {
            foreach ($team->projects as $project) {
                if (!$projects->contains('id', $project->id)) {
                    $projects->push($project);
                }
            }
        }
        return $projects;
    }

    /**
     * Get all the assigned tasks that user has.
     */
    public function assignedTasksByProject()
    {
        $projects = collect([$this->assignedTasks]);

        $teamsIds = $this->onlyTeamsId->pluck('team_id')->toArray();
 
        $projectsWithTasks = Project::whereIn('team_id', $teamsIds)
            ->orWhere('author_id', $this->id)
            ->with(['tasks' => function ($query) {
                $query->where('assignee_id', $this->id);
            }])->get();
 
        foreach ($projectsWithTasks as $project) {
            if (!$project->tasks->isEmpty()) {
                $projects->push($project);
            }   
        }

        return $projects;
    }

    /**
     * Get all the created tasks that user.
     */
    public function createdTasksByProject()
    {
        $projects = collect([$this->createdTasks]);

        $teamsIds = $this->onlyTeamsId->pluck('team_id')->toArray();
 
        $projectsWithTasks = Project::whereIn('team_id', $teamsIds)
            ->orWhere('author_id', $this->id)
            ->with(['tasks' => function ($query) {
                $query->where('reporter_id', $this->id);
            }])->get();
 
        foreach ($projectsWithTasks as $project) {
            if (!$project->tasks->isEmpty()) {
                $projects->push($project);
            }   
        }

        return $projects;
    }

    /**
     * Get the projects that the user created.
     */
    public function createdProjects()
    {
        return $this->hasMany(Project::class, 'author_id')->orderBy('created_at');
    }

    /**
     * Get the requests that the user created.
     */
    public function createdRequests()
    {
        return $this->hasMany(Request::class, 'requester_id')->orderBy('created_at');
    }

    /**
     * Get the requests that the user has gotten.
     */
    public function gottenRequests()
    {
        return $this->hasMany(Request::class, 'responser_id')->orderBy('created_at');
    }

    /**
     * Get the teams that the user is in with the role and name in team.
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_user', 'user_id', 'team_id')
            ->withPivot('is_admin', 'name_in_team')
            ->withTimestamps();
    }

    /**
     * Get users of all the teams the user is in.
     */
    public function teamsUsers()
    {
        $users = collect();

        foreach ($this->teams as $team) {
            foreach($team->users as $user) {
                $users->push($user);
            }
        }

        return $users;
    }

    /**
     * Check if the second user is in the same team.
     * 
     * @param Integer $user_id
     * @return Boolean 
     */
    public function usersInTeam($user_id)
    {
        $teams = $this->teams;
        if ($teams) {
            foreach ($teams as $team) {
                if ($team->pivot->where('user_id', '=', $user_id)) {
                    return true;
                }
            }
        }

        return false;
    }
}
