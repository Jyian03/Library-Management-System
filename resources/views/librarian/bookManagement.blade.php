@include('librarian.navbar')

<div class="container container-wide">
    <h2>Book Management</h2>
    <a href="{{ route('books.create') }}" class="user-mgmt-btn add" style="margin-bottom:16px;">+ Add New Book</a>
    <table class="book-mgmt-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Category</th>
                <th>Total</th>
                <th>Available</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($books as $book)
            <tr>
                <td>{{ $book->title }}</td>
                <td>{{ $book->author }}</td>
                <td>{{ $book->isbn }}</td>
                <td>{{ $book->category }}</td>
                <td>{{ $book->quantity_total }}</td>
                <td>{{ $book->quantity_available }}</td>
                <td>
                    <a href="{{ route('books.edit', $book->book_id) }}" class="user-mgmt-action edit" title="Edit">&#9998;</a>
                    <form action="{{ route('books.destroy', $book->book_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="user-mgmt-action delete" title="Delete" style="background:none;border:none;padding:0;cursor:pointer;">
                            &#128465;
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;">No books found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="book-mgmt-pagination">
        {{ $books->links() }}
    </div>
</div>