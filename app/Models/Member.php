<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $fillable = [
         'name',
         'phone',
         'hall_id',
         'card',
         'registration',
         'email',
         'email2',
         'password',
         'profile_image',
         'father',
         'mother',
         'dept',
    ];
}
