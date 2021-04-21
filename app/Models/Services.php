<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
     protected $primaryKey = 'ser_id';
    use HasFactory;
    protected $guarded = [];
}
