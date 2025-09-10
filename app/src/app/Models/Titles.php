<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Titles extends Model
{
    protected $guarded = ['id'];

    public function acquisitions()
    {
        return $this->hasMany(AcquisitionStatus::class);
    }
}
