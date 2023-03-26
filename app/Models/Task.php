<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  // the $fillable property is used to specify which fields can be mass assigned
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'completed',
    ];
}
