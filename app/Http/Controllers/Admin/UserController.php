<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        
        return Inertia::render('Admin/Users/Index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Users/Create');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'boolean'
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'is_admin' => $validated['is_admin'] ?? false
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Inertia\Response
     */
    public function show(User $user)
    {
        $user->load(['orders']);
        
        return Inertia::render('Admin/Users/Show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Inertia\Response
     */
    public function edit(User $user)
    {
        return Inertia::render('Admin/Users/Edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'sometimes|nullable|string|min:8|confirmed',
            'is_admin' => 'sometimes|boolean'
        ]);

        $userData = [
            'name' => $validated['name'] ?? $user->name,
            'email' => $validated['email'] ?? $user->email,
            'is_admin' => $validated['is_admin'] ?? $user->is_admin
        ];
        
        if (!empty($validated['password'])) {
            $userData['password'] = bcrypt($validated['password']);
        }

        $user->update($userData);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        // Don't allow users to delete themselves
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete yourself.');
        }
        
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Toggle admin status for a user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleAdminStatus(User $user)
    {
        // Don't allow users to remove their own admin status
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot change your own admin status.');
        }
        
        $user->update(['is_admin' => !$user->is_admin]);
        
        $status = $user->is_admin ? 'granted' : 'revoked';
        
        return redirect()->route('admin.users.index')
            ->with('success', "Admin privileges {$status} successfully.");
    }

    /**
     * Display a list of orders for a specific user.
     *
     * @param  \App\Models\User  $user
     * @return \Inertia\Response
     */
    public function orders(User $user)
    {
        $orders = Order::where('user_id', $user->id)
            ->with(['product'])
            ->latest()
            ->paginate(10);
            
        return Inertia::render('Admin/Users/Orders', [
            'user' => $user,
            'orders' => $orders
        ]);
    }
}
