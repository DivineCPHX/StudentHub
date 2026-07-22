<?php

namespace App\Models;

use App\Models\Students;
use App\Models\Colleges;
use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    protected $fillable = [
        'college_id',
        'name',
    ];

    public function students()
    {
        return $this->hasMany(Students::class);
    }

    public function college()
    {
        return $this->belongsTo(Colleges::class);
    }
}
