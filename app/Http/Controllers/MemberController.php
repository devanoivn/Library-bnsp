<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::all(); // Ambil semua anggota dari database
        return view('members.listmember', compact('members')); // Kirim ke view listmember
    }

    // Menampilkan form untuk menambah anggota
    public function create()
    {
        return view('members.addmember'); // Menampilkan view addmember
    }

    // Menyimpan data anggota yang baru ditambahkan
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:members,email',  // Pastikan validasi email ada
        ]);

        Member::create([
            'name' => $request->name,
            'email' => $request->email,  // Menyediakan nilai email
        ]);

        return redirect()->route('members.index')->with('success', 'Member berhasil ditambahkan.');
    }


    // Menampilkan form untuk mengedit anggota
    public function edit(Member $member)
    {
        return view('members.editmember', compact('member')); // Kirim data anggota ke view editmember
    }

    // Memperbarui data anggota
    public function update(Request $request, Member $member)
    {
        // Validasi data yang diterima
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:members,email,' . $member->id,
        ]);

        // Memperbarui data anggota di database
        $member->update($request->all());

        return redirect()->route('members.index')->with('success', 'Anggota berhasil diperbarui.');
    }

    // Menghapus anggota
    public function destroy($id)
{
    try {
        $member = Member::findOrFail($id);
        $member->delete();
        
        return redirect()
            ->route('members.index')
            ->with('success', 'Member berhasil dihapus');
            
    } catch (\Illuminate\Database\QueryException $e) {
        // Cek code 23000 yang merupakan foreign key constraint error
        if($e->getCode() === '23000') {
            return redirect()
                ->back()
                ->with('error', 'Tidak bisa hapus member yang sedang meminjam buku');
        }
        
        return redirect()->back()->with('error', 'Gagal menghapus member');
    }
}
}
