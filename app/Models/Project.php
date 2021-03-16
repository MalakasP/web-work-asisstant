<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'author_id',
        'team_id'
    ];

    /**
     * Get the team that works on the project.
     */
    public function team()
    {
        if ($this->attributes['team_id'] === null) {
            return null;
        }

        return $this->belongsTo(Team::class, 'team_id');
    }

    /**
     * Get the tasks for the project.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class, 'project_id')->orderBy('created_at');
    }
}
