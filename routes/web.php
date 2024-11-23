<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BorrowingController;

Route::get('/', function () {
    return view('home');
});

Route::get('/members/{id}/books', [MemberController::class, 'showMemberBooks'])->name('members.books');

Route::get('/members', [MemberController::class, 'index'])->name('members.index');

// Rute untuk menambah anggota
Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');
Route::post('/members', [MemberController::class, 'store'])->name('members.store');

// Rute untuk mengedit anggota
Route::get('/members/{member}/edit', [MemberController::class, 'edit'])->name('members.edit');
Route::put('/members/{member}', [MemberController::class, 'update'])->name('members.update');

// Rute untuk menghapus anggota
Route::delete('/members/{member}', [MemberController::class, 'destroy'])->name('members.destroy');
// Menampilkan form tambah kategori

// Route untuk daftar kategori dengan nama 'listcategory'
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.listcategory');

// Resource route untuk CRUD kategori
Route::resource('categories', CategoryController::class)->except(['index']);

Route::get('/members/{memberId}/borrowed-books', [BorrowingController::class, 'showBooksBorrowedByMember']);

Route::resource('books', BookController::class);
Route::post('/books/{book}/borrow', [BookController::class, 'borrowBook'])->name('books.borrow');
Route::post('/books/{book}/return', [BookController::class, 'returnBook'])->name('books.return');