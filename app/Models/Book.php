<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $primaryKey = 'book_id';
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'category',
        'quantity_total',
        'quantity_available'
    ];

    // A book can have many transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'book_id', 'book_id');
    }
}
