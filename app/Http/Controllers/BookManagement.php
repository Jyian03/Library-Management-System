<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookManagement extends Controller
{
    public function index()
    {
        $books = Book::paginate(10);
        return view('librarian.bookManagement', compact('books'));
    }

    public function create()
    {
        return view('librarian.bookManagement.addBook');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|max:255|unique:books',
            'category' => 'nullable|string|max:255',
            'quantity_total' => 'required|integer|min:0',
        ]);

        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'isbn' => $request->isbn,
            'category' => $request->category,
            'quantity_total' => $request->quantity_total,
            'quantity_available' => $request->quantity_total,
        ]);

        return redirect()->route('books.index')->with('success', 'Book added successfully.');
    }

    public function edit($book_id)
    {
        $book = Book::findOrFail($book_id);
        return view('librarian.bookManagement.editBook', compact('book'));
    }

    public function update(Request $request, $book_id)
    {
        $book = Book::findOrFail($book_id);

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|max:255|unique:books,isbn,' . $book->book_id . ',book_id',
            'category' => 'nullable|string|max:255',
            'quantity_total' => 'required|integer|min:0',
        ]);

        // Adjust available quantity if total is changed
        $diff = $request->quantity_total - $book->quantity_total;
        $book->quantity_total = $request->quantity_total;
        $book->quantity_available += $diff;

        $book->title = $request->title;
        $book->author = $request->author;
        $book->isbn = $request->isbn;
        $book->category = $request->category;
        $book->save();

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy($book_id)
    {
        $book = Book::findOrFail($book_id);
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }

    public function availableBooks()
    {
        $books = \App\Models\Book::where('quantity_available', '>', 0)->paginate(10);
        return view('member.availableBooks', compact('books'));
    }
}