<?php

namespace App\Models;

use App\Models\Departments;
use Illuminate\Database\Eloquent\Model;

class Colleges extends Model
{
    protected $fillable = [
        'name'
    ];

    public function departments()
    {
        return $this->hasMany(Departments::class);
    }
}
