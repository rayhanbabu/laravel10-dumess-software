<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Univer extends Model
{
      use HasFactory;
      protected $fillable = [
        'university',
        'image',
      ];


    public function hall(){
        return $this->hasMany(Hall::class);
    }


}
