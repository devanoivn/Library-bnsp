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

}
