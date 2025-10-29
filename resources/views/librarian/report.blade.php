@include('librarian.navbar')

<div class="container container-wide">
    <h2>All Transactions</h2>
    <table class="book-mgmt-table">
        <thead>
            <tr>
                <th>Member</th>
                <th>Book</th>
                <th>Borrow Date</th>
                <th>Due Date</th>
                <th>Return Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $transaction)
            <tr>
                <td>{{ $transaction->user->fname ?? '' }} {{ $transaction->user->lname ?? '' }}</td>
                <td>{{ $transaction->book->title ?? '' }}</td>
                <td>{{ $transaction->borrow_date }}</td>
                <td>{{ $transaction->due_date }}</td>
                <td>{{ $transaction->return_date ?? '-' }}</td>
                <td>{{ ucfirst($transaction->status) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center;">No transactions found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="book-mgmt-pagination">
        {{ $transactions->links() }}
    </div>
</div>