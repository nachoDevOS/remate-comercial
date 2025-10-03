<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $fillable = ['ready_id', 'lote', 'quantity', 'price', 'category', 'created_at', 'updated_at'];
}
