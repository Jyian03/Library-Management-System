@include('member.navbar')

    <div class="lib-hero">
        <img src="{{ asset('images/books.png') }}" alt="Library Dashboard" class="lib-hero-img">
        <h1 class="lib-hero-title">Librarian Dashboard</h1>
    </div>

    <div class="lib-dashboard-cards">
        <div class="lib-card">
            <div class="lib-card-icon">📚</div>
            <h3>Book Inventory</h3>
            <p>View available Books</p>
            <a href="{{ route('member.availableBooks') }}" class="lib-btn">Manage Books</a>
        </div>
        <div class="lib-card">
            <div class="lib-card-icon">📝</div>
            <h3>Transactions</h3>
            <p>Monitor borrowed Books</p>
            <a href="{{ route('member.transactions') }}" class="lib-btn">View Transactions</a>
        </div>
    </div>
</body>

