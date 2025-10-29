<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionsManagement extends Controller
{
    public function create()
    {
        $members = User::where('role_id', 2)->get();
        $books = Book::where('quantity_available', '>', 0)->get();
        // Get all unreturned transactions (status = 'borrowed')
        $unreturned = Transaction::with(['user', 'book'])
            ->where('status', 'borrowed')
            ->orderBy('borrow_date', 'desc')
            ->paginate(5);

        return view('librarian.transactions', compact('members', 'books', 'unreturned'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'book_id' => 'required|exists:books,book_id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:borrow_date',
            'quantity' => 'required|integer|min:1',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->quantity_available < $request->quantity) {
            return back()->withErrors(['quantity' => 'Not enough copies available.']);
        }

        $book->quantity_available -= $request->quantity;
        $book->save();

        Transaction::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'borrow_date' => $request->borrow_date,
            'due_date' => $request->due_date,
            'status' => 'borrowed',
            'quantity' => $request->quantity, // Make sure your transactions table has a 'quantity' column
        ]);

        return redirect()->route('transactions.create')->with('success', 'Transaction saved!');
    }

    public function report()
    {
        $transactions = \App\Models\Transaction::with(['user', 'book'])->orderBy('borrow_date', 'desc')->paginate(10);
        return view('librarian.report', compact('transactions'));
    }

    public function returnBook($transaction_id)
    {
        $transaction = Transaction::findOrFail($transaction_id);
        $transaction->status = 'returned';
        $transaction->return_date = now();
        $transaction->save();

        // Increase the book's available quantity
        $book = Book::find($transaction->book_id);
        if ($book) {
            $book->quantity_available += $transaction->quantity;
            $book->save();
        }

        return redirect()->route('transactions.create')->with('success', 'Book returned successfully!');
    }

    public function memberTransactions()
    {
        $user = Auth::user();

        // Unreturned books
        $unreturned = Transaction::with('book')
            ->where('user_id', $user->user_id)
            ->where('status', 'borrowed')
            ->orderBy('borrow_date', 'desc')
            ->paginate(5, ['*'], 'unreturned_page');

        // History (returned books)
        $history = Transaction::with('book')
            ->where('user_id', $user->user_id)
            ->where('status', 'returned')
            ->orderBy('borrow_date', 'desc')
            ->paginate(5, ['*'], 'history_page');

        return view('member.transactions', compact('unreturned', 'history'));
    }
}