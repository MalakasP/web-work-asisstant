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
        'remember_token',
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
        return $this->hasMany(Task::class, 'assignee_id')->orderBy('created_at');
    }

    /**
     * Get the tasks created by the user.
     */
    public function createdTasks()
    {
        return $this->hasMany(Task::class, 'reporter_id')->orderBy('created_at');
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
     * The teams that the user is in.
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_user', 'user_id', 'team_id')
            ->withPivot('is_admin', 'name_in_team')
            ->withTimestamps();
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
        foreach ($teams as $team) {
            if ($team->pivot->where('user_id', '=', $user_id)) {
                return true;
            }
        }
        return false;
    }
}
