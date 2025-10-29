@extends('includes.header')

<div class="lib-navbar">
    <span class="lib-brand">LibrarySys</span>
    <div class="lib-nav-links">
        <a href="{{ route('member.dashboard') }}">Home</a>
        <a href="{{ route('member.availableBooks') }}">Available Books</a>
        <a href="{{ route('member.transactions') }}">Transactions</a>
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