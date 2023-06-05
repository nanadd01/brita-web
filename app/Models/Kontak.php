<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    use HasFactory;
    protected $table = 'kontak';
    protected $fillable = ['name', 'email', 'judul', 'pesan', 'foto'];

    public function profiluser()
    {
        return $this->hasOne(User::class);
    }
}
