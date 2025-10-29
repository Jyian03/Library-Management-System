# LibrarySys Documentation

## Overview

**LibrarySys** is a web-based library management system built with Laravel. It provides features for librarians and members to manage books, users, and transactions efficiently.

---

## Objectives

- To provide an efficient and user-friendly platform for managing library resources.
- To automate book borrowing, returning, and inventory tracking.
- To enable role-based access for librarians and members.
- To generate reports and track user transactions.
- To enhance learning in system integration and architecture using Laravel.

---

## Features / Functionality

### Authentication & Roles
- **Login/Register:** Members can register and login. Librarians are added by administrators.
- **Roles:** Supports `librarian` and `member` roles.

### Librarian Dashboard
- **User Management:** Add, edit, or delete members and librarians.
- **Book Management:** Add, edit, or delete books. Track inventory and availability.
- **Transactions:** Record book borrow/return transactions.
- **Reports:** View all transactions and generate usage reports.

### Member Dashboard
- **Available Books:** View all books available for borrowing.
- **Transactions:** View current borrowings and transaction history.

---

## Installation Instructions

1. **Clone the repository:**
   ```sh
   git clone <repo-url>
   cd LibrarySys
   ```

2. **Install dependencies:**
   ```sh
   composer install
   npm install
   ```

3. **Environment setup:**
   - Copy `.env.example` to `.env` and configure database credentials.
   - Generate application key:
     ```sh
     php artisan key:generate
     ```

4. **Database setup:**
   - Create your database and update `.env`.
   - Run migrations and seeders:
     ```sh
     php artisan migrate --seed
     ```

5. **Run the application:**
   ```sh
   php artisan serve
   npm run dev
   ```

---

## Usage

### Librarian
- Access dashboard at `/librarian/dashboard`.
- Manage users and books via sidebar links.
- Record transactions and view reports.

### Member
- Access dashboard at `/member/dashboard`.
- View available books and transaction history.

---

## Code Snippets

### Authentication Controller (Login & Register)
````php
// filepath: [AuthController.php](http://_vscodecontentref_/0)
public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($request->only('email', 'password'))) {
        $request->session()->regenerate();
        $user = Auth::user();
        if ($user->role_id == 1){
            return redirect()->route('librarian.dashboard');
        } elseif ($user->role_id == 2){
            return redirect()->route('member.dashboard');
        }
    }
    throw ValidationException::withMessages([
        'email' => ['The provided credentials do not match our records.'],
    ]);
}

````

### Book Management
#### List All Books
````php
public function index()
{
    $books = Book::paginate(10);
    return view('librarian.bookManagement', compact('books'));
}
````

#### Create/Save Book
````php
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
````

#### Edit/Update Book
````php
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
````
#### Delete Book
````php
public function destroy($book_id)
{
    $book = Book::findOrFail($book_id);
    $book->delete();
    return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
}
````

### Authentication Controller (Login & Register)
#### Store new Borrow Transaction
````php
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
        'quantity' => $request->quantity,
    ]);

    return redirect()->route('transactions.create')->with('success', 'Transaction saved!');
}
````
#### Store new Borrow Transaction
````php
public function returnBook($transaction_id)
{
    $transaction = Transaction::findOrFail($transaction_id);
    $transaction->status = 'returned';
    $transaction->return_date = now();
    $transaction->save();

    $book = Book::find($transaction->book_id);
    if ($book) {
        $book->quantity_available += $transaction->quantity;
        $book->save();
    }

    return redirect()->route('transactions.create')->with('success', 'Book returned successfully!');
}
````
---

## Folder Structure

- `app/Models`: Eloquent models (`User`, `Book`, `Transaction`, `Role`, `Fine`)
- `app/Http/Controllers`: Controllers for authentication, user, book, and transaction management
- `resources/views`: Blade templates for UI
- `routes/web.php`: Route definitions
- `database/migrations`: Database schema
- `database/seeders`: Initial data (roles, etc.)

---

## Database Schema

- **roles**: `role_id`, `name`
- **users**: `user_id`, `username`, `fname`, `mi`, `lname`, `email`, `password`, `role_id`
- **books**: `book_id`, `title`, `author`, `isbn`, `category`, `quantity_total`, `quantity_available`
- **transactions**: `transaction_id`, `user_id`, `book_id`, `borrow_date`, `due_date`, `return_date`, `status`, `quantity`
- **fines**: `fine_id`, `transaction_id`, `amount`, `paid`, `date_paid`

---


## Contributors

- **Santiago Elija R. Sabulao Jr.**

- Developed for DMMMSU System Integration and Architecture 2 (AY 2025-26).
