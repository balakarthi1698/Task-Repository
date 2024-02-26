<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'image', 'description', 'price', 'quantity', 'created_by', 'updated_by'];

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
