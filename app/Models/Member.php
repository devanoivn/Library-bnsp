<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = ['name', 'email'];

    public function books()
    {
        return $this->hasMany(Book::class, 'borrowed_by');
    }
    public function borrower()
    {
        return $this->belongsTo(Member::class, 'borrowed_by');
    }
    public function borrowedBooks()
    {
        return $this->hasManyThrough(
            Book::class,       // Model buku
            Borrowing::class,  // Model tabel pivot (borrowings)
            'member_id',       // Foreign key di tabel borrowings
            'id',              // Primary key di tabel books
            'id',              // Primary key di tabel members
            'book_id'          // Foreign key di tabel borrowings
        );
    }

}
