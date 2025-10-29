@include('librarian.navbar')

<div class="container">
    <h2>Add New Book</h2>
    <form method="POST" class="crudForm" action="{{ route('books.store') }}">
        @csrf
        <input type="text" name="title" placeholder="Title" required>
        <input type="text" name="author" placeholder="Author" required>
        <input type="text" name="isbn" placeholder="ISBN" required>
        <input type="text" name="category" placeholder="Category">
        <input type="number" name="quantity_total" placeholder="Total Quantity" min="0" required>
        <button type="submit">Add Book</button>
    </form>
</div>