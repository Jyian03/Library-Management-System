@include('member.navbar')

<div class="container container-wide">
    <h2>My Transactions</h2>

    <h3>Unreturned Books</h3>
    <table class="book-mgmt-table">
        <thead>
            <tr>
                <th>Book</th>
                <th>Quantity</th>
                <th>Borrow Date</th>
                <th>Due Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($unreturned as $transaction)
            <tr>
                <td>{{ $transaction->book->title ?? '' }}</td>
                <td>{{ $transaction->quantity }}</td>
                <td>{{ $transaction->borrow_date }}</td>
                <td>{{ $transaction->due_date }}</td>
                <td>{{ ucfirst($transaction->status) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center;">No unreturned books.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="book-mgmt-pagination">
        {{ $unreturned->links('pagination::bootstrap-4') }}
    </div>

    <h3 style="margin-top:40px;">History</h3>
    <table class="book-mgmt-table">
        <thead>
            <tr>
                <th>Book</th>
                <th>Quantity</th>
                <th>Borrow Date</th>
                <th>Due Date</th>
                <th>Returned Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($history as $transaction)
            <tr>
                <td>{{ $transaction->book->title ?? '' }}</td>
                <td>{{ $transaction->quantity }}</td>
                <td>{{ $transaction->borrow_date }}</td>
                <td>{{ $transaction->due_date }}</td>
                <td>{{ $transaction->return_date ?? '-' }}</td>
                <td>{{ ucfirst($transaction->status) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center;">No history found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="book-mgmt-pagination">
        {{ $history->links('pagination::bootstrap-4') }}
    </div>
</div>