<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;
    protected $fillable = ['type', 'date', 'title', 'description', 'percentage', 'fee', 'status', 'deleted_at'];

    public function readys(){
        return $this->hasMany(Ready::class, 'day_id');
    }
}
