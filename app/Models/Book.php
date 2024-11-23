<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'name', 
        'author', 
        'status', 
        'borrowed_by'
    ];

    // Relasi dengan Category
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_category');
    }

    // Relasi dengan Member
    public function borrower()
    {
        return $this->belongsTo(Member::class, 'borrowed_by');
    }
}