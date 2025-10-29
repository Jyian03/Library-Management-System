<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class UserManagement extends Controller
{
    public function userManagement()
    {
        $members = User::with('role')->where('role_id', 2)->paginate(5);
        $librarians = User::with('role')->where('role_id', 1)->get();
        return view('librarian.userManagement', compact('members', 'librarians'));
    }

    public function registerMember(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'fname' => 'required|string|max:255',
            'mi' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'username' => $request->username,
            'fname' => $request->fname,
            'mi' => $request->mi,
            'lname' => $request->lname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2, // Member role (assuming role_id 2 is for members)
        ]);

        return redirect()->route('librarian.users');
    }

    public function registerLibrarian(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'fname' => 'required|string|max:255',
            'mi' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'username' => $request->username,
            'fname' => $request->fname,
            'mi' => $request->mi,
            'lname' => $request->lname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 1,
        ]);

        return redirect()->route('librarian.users');
        }

        public function showAddMemberForm()
        {
            return view('librarian.userManagement.addMember');
        }

        public function showAddLibrarianForm()
        {
            return view('librarian.userManagement.addLibrarian');
        }

        public function edit($user_id){
            $user = User::findOrFail($user_id);
            return view('librarian.userManagement.edit', compact('user'));
        }

        public function update(Request $request, $user_id)
        {
            $user = User::findOrFail($user_id);

            $request->validate([
                'username' => 'required|string|max:255',
                'fname' => 'required|string|max:255',
                'mi' => 'required|string|max:255',
                'lname' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $user->user_id . ',user_id',
                'role_id' => 'required|in:1,2',
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            $user->username = $request->username;
            $user->fname = $request->fname;
            $user->mi = $request->mi;
            $user->lname = $request->lname;
            $user->email = $request->email;
            $user->role_id = $request->role_id;

            // Only update password if provided
            if ($request->filled('password')) {
                $user->password = \Hash::make($request->password);
            }

            $user->save();

            return redirect()->route('librarian.users')->with('success', 'User updated successfully.');
        }

        public function destroy($user_id){
            $user = User::findOrFail($user_id);
            $user->delete();
            return redirect()->route('librarian.users')->with('succes', 'User Deleted Successfully.');
        }
}
