@extends('includes.header')

<div class="lib-navbar">
    <span class="lib-brand">LibrarySys</span>
    <div class="lib-nav-links">
        <a href="{{ route('librarian.dashboard') }}">Home</a>
        <a href="{{ route('books.index') }}">Books</a>
        <a href="{{ route('librarian.users') }}">Members</a>
        <a href="{{ route('transactions.create') }}">Transactions</a>
        <a href="{{ route('transactions.report') }}">Reports</a>
        <div class="lib-dropdown">
            <button class="lib-dropbtn"> {{ Auth::user()->username }}▼</button>
            <div class="lib-dropdown-content">
                <a href="#">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="lib-logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>