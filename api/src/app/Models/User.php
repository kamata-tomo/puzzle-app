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
/** Friendモデルとの紐付け */
    public function friend()
    {
        return $this->hasOne(Friend::class, 'user_id','id');
    }

    public function progres(){
        return $this->hasOne(StageProgress::class,'user_id','id');
    }

    public function FriendRequest(){
        return $this->hasOne(Friend::class, 'requesting_user_id','id');
    }

    public function stamina()
    {
        return $this->hasOne(StaminaStatus::class, 'user_id','id');
    }

    public function acquisitions()
    {
        return $this->hasMany(AcquisitionStatus::class, 'user_id');
    }
    protected function StaminaLog(){
        return $this->hasOne(StaminaStatus::class, 'user_id','id');
    }
}
