@include('librarian.navbar')

<div class="user-mgmt-flex">
    <!-- Main Members Table -->
    <div class="user-mgmt-main">
        <div class="user-mgmt-header">
            <h2>Manage <strong>Members</strong></h2>
            <div>
                <a href="{{ route('librarian.addMember') }}" class="user-mgmt-btn add"><span>+</span> Add New Member</a>
            </div>
        </div>
        <table class="user-mgmt-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $user)
                <tr>
                    <td>{{ $user->fname }} {{ $user->mi }} {{ $user->lname }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->username }}</td>
                    <td>
                        <a href="{{ route('librarian.edit', $user->user_id) }}" class="user-mgmt-action edit" title="Edit">&#9998;</a>
                        <form action="{{ route('librarian.destroy', $user->user_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="user-mgmt-action delete" title="Delete" style="background:none;border:none;padding:0;cursor:pointer;">
                                &#128465;
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center;">No members found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="user-mgmt-pagination">
            {{ $members->links() }}
        </div>
    </div>

    <!-- Librarians Table (smaller, on the side) -->
    <div class="user-mgmt-main">
        <div class="user-mgmt-header" style="background:#23408e;">
            <h2>Manage <strong>Librarians</strong></h2>
            <div>
                <a href="{{ route('librarian.addLibrarian') }}" class="user-mgmt-btn add"><span>+</span> Add New Librarian</a>
            </div>
        </div>
        <table class="user-mgmt-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th style="width:70px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($librarians as $user)
                <tr>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('librarian.edit', $user->user_id) }}" class="user-mgmt-action edit" title="Edit">&#9998;</a>
                        <form action="{{ route('librarian.destroy', $user->user_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="user-mgmt-action delete" title="Delete" style="background:none;border:none;padding:0;cursor:pointer;">
                                &#128465;
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align:center;">No librarians found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>