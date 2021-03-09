<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worktime extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'duration',
        'end_time',
        'user_id',
    ];

    /**
     * Get the user that owns the worktime.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
