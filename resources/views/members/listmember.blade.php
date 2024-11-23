@extends('layouts.app')

@section('content')
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="container">
    <a href="{{ route('members.create') }}" class="btn btn-primary btn btn-warning btn-sm mt-3 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Tambah Anggota</a>
    
    <table class="table mt-3">
        <thead class="bg-gray-200">
            <tr>
                <th scope="col" class="text-left px-4 py-2">No</th>
                <th scope="col" class="text-left px-4 py-2">Nama</th>
                <th scope="col" class="text-left px-4 py-2">Email</th>
                <th scope="col" class="text-left px-4 py-2">Setting</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $member)
            <tr class="border-b">
                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                <td class="px-4 py-2">{{ $member->name }}</td>
                <td class="px-4 py-2">{{ $member->email }}</td>
                <td class="px-4 py-2">
                    <a href="{{ route('members.edit', $member) }}" class="btn btn-warning btn-sm rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Edit</a>
                    
                    <form action="{{ route('members.destroy', $member) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmAction(this)" class="btn btn-sm mt-3 rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                            Delete
                        </button>
                     </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
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
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
