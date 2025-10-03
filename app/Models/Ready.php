<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ready extends Model
{
    use HasFactory;
    
    protected $fillable = ['day_id', 'category_id', 'lote', 'quantity', 'price', 'price_add', 'total_weight', 'defending', 'description', 'status', 'deleted_at'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function day()
    {
        return $this->belongsTo(Day::class, 'day_id');
    }
}
