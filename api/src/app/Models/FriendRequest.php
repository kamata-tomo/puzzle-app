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

    public function user()
    {
        return $this->hasOne(User::class, 'id','recipient_id');
    }
}
