<!-- resources/views/borrowed_books.blade.php -->
<h3>Books Borrowed by {{ $member->name }}</h3>
<ul>
    @foreach ($member->books as $book)
        <li>{{ $book->title }}</li>
    @endforeach
</ul>
