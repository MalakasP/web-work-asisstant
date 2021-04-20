<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date_from',
        'date_to',
        'description',
        'type',
        'is_confirmed',
        'confirmed_at',
        'requester_id',
        'responser_id',
        'team_id'
    ];

    /**
     * Get the user that created the request.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    /**
     * Get the addressee of the request.
     */
    public function responser()
    {
        return $this->belongsTo(User::class, 'responser_id');
    }
}
