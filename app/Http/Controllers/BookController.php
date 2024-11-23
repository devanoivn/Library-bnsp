<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Member;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['categories', 'borrower'])->get();
        $members = Member::all();
        return view('books.listbooks', compact('books', 'members'));
    }


    // Menampilkan form tambah buku
    public function create()
    {
        $categories = Category::all();
        $members = Member::all();
        return view('books.addbooks', compact('categories', 'members'));
    }


        // Menyimpan buku baru
    public function store(Request $request)
    {
            $request->validate([
                'name' => 'required',
                'author' => 'required',
                'categories' => 'required|array',
                'categories.*' => 'exists:categories,id',
            ]);
        
            $book = Book::create([
                'name' => $request->name,
                'author' => $request->author,
                'status' => 'Tersedia',
            ]);
        
            $book->categories()->attach($request->categories);
        
            return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    // Menampilkan form edit buku
    public function edit(Book $book)
    {
        $categories = Category::all();
        $selectedCategories = $book->categories->pluck('id')->toArray();
        return view('books.editbooks', compact('book', 'categories', 'selectedCategories'));
    }

    // Memperbarui buku
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'name' => 'required',
            'author' => 'required',
            'categories' => 'required|array',
        ]);

        $book->update([
            'name' => $request->name,
            'author' => $request->author,
        ]);

        $book->categories()->sync($request->categories);

        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui!');
    }

    
    public function borrowBook(Request $request, $bookId)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
        ]);

        $book = Book::findOrFail($bookId);
        
        if ($book->status !== 'Tersedia') {
            return redirect()->back()->with('error', 'Buku ini sudah dipinjam.');
        }

        try {
            $book->update([
                'borrowed_by' => $request->member_id,
                'status' => 'Dipinjam',
            ]);

            return redirect()->back()->with('success', 'Buku berhasil dipinjam.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat meminjam buku: ' . $e->getMessage());
        }
    }


    public function returnBook($bookId)
    {
        $book = Book::findOrFail($bookId);

        if ($book->status !== 'Dipinjam') {
            return redirect()->back()->with('error', 'Buku ini tidak sedang dipinjam.');
        }

        $book->update([
            'borrowed_by' => null,
            'status' => 'Tersedia',
        ]);

        return redirect()->route('books.index')->with('success', 'Buku berhasil dikembalikan.');
    }
    public function destroy(Book $book)
    {
        $book->categories()->detach(); // Hapus relasi dengan kategori
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus!');
    }

}
