@include('librarian.navbar')

<div class="container">
    <h2>Edit Book</h2>
    <form method="POST" class="crudForm" action="{{ route('books.update', $book->book_id) }}">
        @csrf
        @method('PUT')
        <input type="text" name="title" value="{{ old('title', $book->title) }}" placeholder="Title" required>
        <input type="text" name="author" value="{{ old('author', $book->author) }}" placeholder="Author" required>
        <input type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}" placeholder="ISBN" required>
        <input type="text" name="category" value="{{ old('category', $book->category) }}" placeholder="Category">
        <input type="number" name="quantity_total" value="{{ old('quantity_total', $book->quantity_total) }}" placeholder="Total Quantity" min="0" required>
        <button type="submit">Update Book</button>
    </form>
</div>