<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table='categories';

    protected $fillable = [
        'photo',
        'title',
        'details'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'cat_id'); // Use 'cat_id' as the foreign key
    }

}
