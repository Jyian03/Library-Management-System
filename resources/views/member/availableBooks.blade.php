@include('member.navbar')

<div class="container container-wide">
    <h2>Available Books</h2>
    <table class="book-mgmt-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Category</th>
                <th>Total</th>
                <th>Available</th>
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