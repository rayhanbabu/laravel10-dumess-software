<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    use HasFactory;
    protected $fillable = [
        'university_id',
        'hall',
    ];

    public function univer(){
        return $this->belongsTo(Univer::class);
    }
}
