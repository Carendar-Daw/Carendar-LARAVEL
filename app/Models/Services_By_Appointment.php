<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services_By_Appointment extends Model
{
    protected $primaryKey = 'sba_id';
    use HasFactory;
    protected $guarded = [];
}
