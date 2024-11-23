@extends('layouts.app') 

@section('content')

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <div class="container">
        <form action="{{ route('books.update', $book->id) }}" method="POST">
            @csrf
            @csrf 
        @method('PUT')

            <div class="sm:col-span-4">
                <label for="name" class="block text-sm/6 font-medium text-gray-900">Nama Buku</label>
                <div class="mt-2">
                  <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                    <input value="{{ $book->name }}" name="name" id="name" autocomplete="name" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm/6" placeholder="Nama" required>
                  </div>
                </div>
            </div>
            <label for="author" class="mt-3 block text-sm/6 font-medium text-gray-900">Kategori</label>
            <select name="categories[]" multiple>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ in_array($category->id, $selectedCategories) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <div class="sm:col-span-4">
                <label for="username" class="block text-sm/6 font-medium text-gray-900">Penulis</label>
                <div class="mt-2">
                  <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                    <input value="{{ $book->author }}" type="text" name="author" id="author" autocomplete="author" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm/6" placeholder="Author" required>
                  </div>
                </div>
                <button type="submit" class="mt-3 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Simpan</button>
            </div>
        
@endsection