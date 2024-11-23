@extends('layouts.app')

@section('content')

<form action="{{ route('books.index') }}" method="GET" class="d-flex gap-2 mb-3">
    <select name="category" class="form-select">
        <option value="">Semua Kategori</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-primary">Filter</button>
</form>


<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <a href="{{ route('books.create') }}" class="btn btn-primary btn btn-warning btn-sm mt-3 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Tambah Buku</a>
    
    <table class="table mt-3">
        <thead class="bg-gray-200">
            <tr>
                <th scope="col" class="text-left px-4 py-2">No</th>
                <th scope="col" class="text-left px-4 py-2">Nama</th>
                <th scope="col" class="text-left px-4 py-2">Penulis</th>
                <th scope="col" class="text-left px-4 py-2">Category</th>
                <th scope="col" class="text-left px-4 py-2">Status</th>
                <th scope="col" class="text-left px-4 py-2">Peminjam</th>
                <th scope="col" class="text-left px-4 py-2">Setting</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
            <tr class="border-b">
                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                <td class="px-4 py-2">{{ $book->name }}</td>
                <td class="px-4 py-2">{{ $book->author }}</td>
                <td>
                    @foreach($book->categories as $category)
                        <span class="badge bg-primary">{{ $category->name }}</span>
                    @endforeach
                </td>
                <td class="px-4 py-2">{{ $book->status }}</td>
                <td>
                    <div class="button-group">
                        @if($book->status === 'Tersedia')
                            <form action="{{ route('books.borrow', $book->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <select name="member_id" required>
                                    <option value="">Pilih Peminjam</option>
                                    @foreach($members as $member)
                                        <option value="{{ $member->id }}">{{ $member->name }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-warning btn-sm rounded-md bg-green-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" type="submit">Pinjam</button>
                            </form>
                            <td class="px-4 py-2">
                                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning btn-sm rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Edit</a>
                                
                                <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')   
                                    <button type="button" onclick="confirmAction(this)" class="btn btn-sm mt-3 rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                                        Delete
                                    </button> 
                                </form>
                            </td>
                        @else
                            <form action="{{ route('books.return', $book->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-warning btn-sm rounded-md bg-red-300 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" type="submit">Kembalikan</button>
                            </form>
                            <div>
                                Dipinjam oleh: {{ optional($book->borrower)->name ?? 'Unknown' }}
                            </div>
                        @endif
                        
                    </div>
                </td>

                
            </tr>
            @endforeach
        </tbody>
    </table>

    
    <table class="table mt-10">
        <h5>List buku yang di pinjam</h5>
        <thead class="bg-gray-200">
            <tr>
                <th scope="col" class="text-left px-4 py-2">No</th>
                <th scope="col" class="text-left px-4 py-2">Nama</th>
                <th scope="col" class="text-left px-4 py-2">Buku Pinjam</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $member)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                <td class="px-4 py-2">{{ $member->name }}</td>
                <td class="px-4 py-2">
                    @if($member->borrowedBooks && $member->borrowedBooks->isNotEmpty())
                        <div class="d-flex flex-column gap-1">
                            @foreach($member->borrowedBooks as $book)
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-info">{{ $book->name }}</span>
                                    <small class="text-muted">oleh {{ $book->author }}</small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <span class="text-muted">Tidak ada buku yang dipinjam</span>
                    @endif
                </td>
                <td class="px-4 py-2">
                    @if($member->borrowedBooks && $member->borrowedBooks->isNotEmpty())
                        <a href="{{ route('members.books', $member->id) }}" class="btn btn-sm bg-blue-500 text-white hover:bg-blue-600">
                            Detail Peminjaman
                        </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmAction(button) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Tindakan ini tidak dapat dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }
    function confirmPinjam(form) {
    Swal.fire({
        title: 'Konfirmasi Pinjaman',
        text: "Anda yakin ingin meminjam buku ini?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Pinjam',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}
</script>
@endsection