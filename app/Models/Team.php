<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\User;

class Team extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * The users that are in the team.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'team_user', 'team_id', 'user_id')
            ->withPivot('is_admin', 'name_in_team')
            ->withTimestamps();
    }

    /**
     * Check if user by given user_id is admin of the team.
     * 
     * @param Integer $user_id
     * @return Boolean
     */
    public function isUserAdmin($user_id)
    {
        return $this->users()->where('user_id', '=', $user_id)
            ? $this->users()->where('user_id', '=', $user_id)->first()->pivot->is_admin
            : false;
    }

     /**
     * Check if user by given user_id is in the team.
     * 
     * @param Integer $user_id
     * @return Boolean
     */
    public function isTeamMember($user_id)
    {
        return $this->users()->where('user_id', '=', $user_id)
            ? true
            : false;
    }
}
