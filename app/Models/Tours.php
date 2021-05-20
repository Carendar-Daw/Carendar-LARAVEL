<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tours extends Model
{
    protected $primaryKey = 'tour_id';
    use HasFactory;
    protected $guarded = [];
}
