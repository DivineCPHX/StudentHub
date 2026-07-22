<?php

namespace App\Models;

use App\Models\Students;
use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    protected $fillable = [
        'name'
    ];

    public function students()
    {
        return $this->hasMany(Students::class);
    }
}
