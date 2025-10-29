<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserManagement;
use App\Http\Controllers\BookManagement;
use App\Http\Controllers\TransactionsManagement;

Route::get('/', function () {
    return view('auth.login');
});


// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
//User management
Route::get('/librarian/users', [UserManagement::class, 'userManagement'])->name('librarian.users');
Route::get('/librarian/{user_id}/edit', [UserManagement::class, 'edit'])->name('librarian.edit');
Route::put('/librarian/{user_id}' , [UserManagement::class, 'update'])->name('librarian.update');
Route::delete('/librarian/{user_id}/delete', [UserManagement::class, 'destroy'])->name('librarian.destroy');
//Transactions (Borrowing of Books)
Route::get('/transactions/create', [TransactionsManagement::class, 'create'])->name('transactions.create');
Route::post('/transactions', [TransactionsManagement::class, 'store'])->name('transactions.store');
Route::post('/transactions/{transaction_id}/return', [TransactionsManagement::class, 'returnBook'])->name('transactions.return');
//Reports
Route::get('/transactions/report', [TransactionsManagement::class, 'report'])->name('transactions.report');
//Check Available Books (Members)
Route::get('/member/available-books', [BookManagement::class, 'availableBooks'])->name('member.availableBooks');
//Check History and Transactions (Members)
Route::get('/member/transactions', [TransactionsManagement::class, 'memberTransactions'])->name('member.transactions');
// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/librarian/dashboard', function () {
        return view('librarian.librarianDashboard');
    })->name('librarian.dashboard');

    Route::get('/member/dashboard', function () {
        return view('member.memberDashboard');
    })->name('member.dashboard');

     // Show forms
    Route::get('/librarian/add-member', [UserManagement::class, 'showAddMemberForm'])->name('librarian.addMember');
    Route::get('/librarian/add-librarian', [UserManagement::class, 'showAddLibrarianForm'])->name('librarian.addLibrarian');

    // Handle form submissions
    Route::post('/librarian/add-member', [UserManagement::class, 'registerMember'])->name('librarian.registerMember');
    Route::post('/librarian/add-librarian', [UserManagement::class, 'registerLibrarian'])->name('librarian.registerLibrarian');

    Route::get('/books', [BookManagement::class, 'index'])->name('books.index');
    Route::get('/books/create', [BookManagement::class, 'create'])->name('books.create');
    Route::post('/books', [BookManagement::class, 'store'])->name('books.store');
    Route::get('/books/{book_id}/edit', [BookManagement::class, 'edit'])->name('books.edit');
    Route::put('/books/{book_id}', [BookManagement::class, 'update'])->name('books.update');
    Route::delete('/books/{book_id}', [BookManagement::class, 'destroy'])->name('books.destroy');
});