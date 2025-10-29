@include('librarian.navbar')



<div class="container container-wide">
    <h2>Borrow Book</h2>
    @if(session('success'))
        <div class="info">{{ session('success') }}</div>
    @endif

    <div class="transaction-flex">
        <!-- Unreturned Books Table -->
        <div class="transaction-side">
            @if($unreturned->count())
                <h3>Unreturned Books</h3>
                <table class="book-mgmt-table">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Book</th>
                            <th>Quantity</th>
                            <th>Borrow Date</th>
                            <th>Due Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($unreturned as $transaction)
                        <tr>
                            <td>{{ $transaction->user->fname ?? '' }} {{ $transaction->user->lname ?? '' }}</td>
                            <td>{{ $transaction->book->title ?? '' }}</td>
                            <td>{{ $transaction->quantity }}</td>
                            <td>{{ $transaction->borrow_date }}</td>
                            <td>{{ $transaction->due_date }}</td>
                            <td>
                                <form action="{{ route('transactions.return', $transaction->transaction_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="user-mgmt-action" style="color: #28a745;">Return</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="book-mgmt-pagination">
                    {{ $unreturned->links() }}
                </div>
            @endif
        </div>

        <!-- Transaction Form -->
        <div class="transaction-main">
            <form method="POST" action="{{ route('transactions.store') }}">
                @csrf
                <div class="form-group">
                    <label for="user_id">Member</label>
                    <select name="user_id" required>
                        <option value="">Select Member</option>
                        @foreach($members as $member)
                            <option value="{{ $member->user_id }}">{{ $member->fname }} {{ $member->lname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="book_id">Book</label>
                    <select name="book_id" required>
                        <option value="">Select Book</option>
                        @foreach($books as $book)
                            <option value="{{ $book->book_id }}">{{ $book->title }} (Available: {{ $book->quantity_available }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" min="1" value="1" required>
                </div>
                <div class="form-group">
                    <label for="borrow_date">Borrow Date</label>
                    <input type="date" name="borrow_date" required>
                </div>
                <div class="form-group">
                    <label for="due_date">Due Date</label>
                    <input type="date" name="due_date" required>
                </div>
                <button type="submit">Save Transaction</button>
            </form>
        </div>
    </div>
</div>