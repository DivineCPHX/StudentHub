<?php

namespace App\Models;

use App\Models\Users;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'timestamps',
    ];

    public function users()
    {
        return $this->hasMany(Users::class);
    }
}
