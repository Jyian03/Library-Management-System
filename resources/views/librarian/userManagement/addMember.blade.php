@include('librarian.navbar')
<div class="container">
    <h2>Add New Member</h2>
    <form method="POST" class="crudForm" action="{{ route('librarian.registerMember') }}">
        @csrf
        <input type="text" name="username" placeholder="Username" required>
        <input type="text" name="fname" placeholder="First Name" required>
        <input type="text" name="mi" placeholder="Middle Initial" required>
        <input type="text" name="lname" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
        <button type="submit">Add Member</button>
    </form>
</div>