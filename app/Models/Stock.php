<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $primaryKey = 'sto_id';
    use HasFactory;
    protected $guarded = [];
}
