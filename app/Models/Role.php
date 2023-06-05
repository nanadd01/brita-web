<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    public function User()
    {
        return $this->hasMany(User::class);
    }
    public function aturan()
    {
        return $this->hasMany(Aturan::class,'name','id');
    }
}
