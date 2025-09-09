<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendRequest extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $fillable = ['requesting_user_id', 'recipient_id', 'is_reaction'];

    public function requestingUser()
    {
        return $this->belongsTo(User::class, 'requesting_user_id');
    }
}
