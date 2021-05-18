<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $primaryKey = 'tra_id';
    use HasFactory;
    protected $guarded = [];
}
