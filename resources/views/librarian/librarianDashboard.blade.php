@include('librarian.navbar')

    <div class="lib-hero">
        <img src="{{ asset('images/books.png') }}" alt="Library Dashboard" class="lib-hero-img">
        <h1 class="lib-hero-title">Librarian Dashboard</h1>
    </div>

    <div class="lib-dashboard-cards">
        <div class="lib-card">
            <div class="lib-card-icon">👤</div>
            <h3>User Management</h3>
            <p>Manage library users, approve memberships, and assign roles.</p>
            <a href="{{ route('librarian.users') }}" class="lib-btn">Manage Users</a>
        </div>
        <div class="lib-card">
            <div class="lib-card-icon">📚</div>
            <h3>Book Inventory</h3>
            <p>View, add, or update books in the library collection.</p>
            <a href="{{ route('books.index') }}" class="lib-btn">Manage Books</a>
        </div>
        <div class="lib-card">
            <div class="lib-card-icon">📈</div>
            <h3>Reports</h3>
            <p>Generate and view reports on library usage and transactions.</p>
            <a href="{{ route('transactions.report') }}" class="lib-btn">View Reports</a>
        </div>
        <div class="lib-card">
            <div class="lib-card-icon">📝</div>
            <h3>Transactions</h3>
            <p>Monitor and manage book borrow/return transactions.</p>
            <a href="{{ route('transactions.create') }}" class="lib-btn">View Transactions</a>
        </div>
    </div>
</body>

