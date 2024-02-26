<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'category_item_id', 'quantity'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function categoryItem() {
        return $this->belongsTo(CategoryItem::class);
    }
}
