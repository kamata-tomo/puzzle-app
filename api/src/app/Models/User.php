<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;

    protected $guarded = [
        'id',
    ];

    public function friend()
    {
        return $this->hasOne(Friend::class, 'user_id','id');
    }

    public function progres(){
        return $this->hasOne(StageProgress::class,'user_id','id');
    }

    public function AcquisitionStatus(){
        return $this->hasMany(AcquisitionStatus::class);
    }
}
