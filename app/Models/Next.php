<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Next extends Model
{
    use HasFactory;

    protected $fillable = ['ready_id', 'lote', 'quantity', 'price', 'category', 'position', 'total_weight', 'total'];
}
