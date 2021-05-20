<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cash_Register extends Model
{
    protected $primaryKey = 'sal_id';
    use HasFactory;
    protected $guarded = [];
}
