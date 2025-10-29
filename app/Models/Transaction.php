<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'transaction_id';
    protected $fillable = [
        'user_id',
        'book_id',
        'borrow_date',
        'due_date',
        'return_date',
        'status'
    ];

    // Each transaction belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Each transaction belongs to a book
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'book_id');
    }

    // Each transaction may have one fine
    public function fine()
    {
        return $this->hasOne(Fine::class, 'transaction_id', 'transaction_id');
    }
}
