@include('librarian.navbar')
<div class="container">
    <h2>Edit User</h2>
    <form method="POST" class="crudForm" action="{{ route('librarian.update', $user->user_id) }}">
        @csrf
        @method('PUT')
        <input type="text" name="username" value="{{ old('username', $user->username) }}" placeholder="Username" required>
        <input type="text" name="fname" value="{{ old('fname', $user->fname) }}" placeholder="First Name" required>
        <input type="text" name="mi" value="{{ old('mi', $user->mi) }}" placeholder="Middle Initial" required>
        <input type="text" name="lname" value="{{ old('lname', $user->lname) }}" placeholder="Last Name" required>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Email" required>
        <input type="hidden" name="role_id" value="{{ $user->role_id }}">
        <input type="password" name="password" placeholder="New Password (leave blank to keep current)">
        <input type="password" name="password_confirmation" placeholder="Confirm New Password">
        <button type="submit">Update User</button>
    </form>
</div>