<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notif extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'komentar', 'read_at'];
    protected $table='notifs';
}
