<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Departments;

class Students extends Model
{
    protected $fillable = [
        'department_id',
        'name',
        'email',
        'gender',
    ];

    public function department()
    {
        return $this->belongsTo(Departments::class);
    }
}
