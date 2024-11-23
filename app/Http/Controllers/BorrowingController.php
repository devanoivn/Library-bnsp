<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Member;
use Illuminate\Http\Request;

// app/Http/Controllers/BorrowingController.php
class BorrowingController extends Controller
{
    public function showBooksBorrowedByMember($memberId)
    {
        $member = Member::with('books')->findOrFail($memberId);
        return view('borrowed_books', compact('member'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
        ]);

        Borrowing::create([
            'member_id' => $request->member_id,
            'book_id' => $request->book_id,
        ]);

        return redirect()->route('members.show', $request->member_id);
    }
    
    public function listBorrowedBooks($memberId)
    {
        $member = Member::with('borrowedBooks')->find($memberId);

        if (!$member) {
            return back()->with('error', 'Anggota tidak ditemukan.');
        }

        $borrowedBooks = $member->borrowedBooks;

        return view('borrowed_books_list', compact('member', 'borrowedBooks'));
    }

}

