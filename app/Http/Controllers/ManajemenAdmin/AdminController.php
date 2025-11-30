<?php

namespace App\Http\Controllers\ManajemenAdmin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::withCount('orders')
            ->with(['orders' => function($query) {
                $query->where('status', 'completed');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        // Add total sales to each user
        $users->each(function($user) {
            $user->total_sales = $user->orders->sum('total');
        });

        $adminAktif = $users->where('role', 'admin')->where('is_active', true)->count();
        $totalAdmin = $users->count();

        return view('manajemen-admin.index', compact('users', 'adminAktif', 'totalAdmin'));
    }

    public function show($id)
    {
        $user = User::withCount('orders')
            ->with(['orders' => function($query) {
                $query->where('status', 'completed');
            }])
            ->findOrFail($id);

        $user->total_sales = $user->orders->sum('total');

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    public function changeRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'role' => 'required|in:admin,kasir',
        ]);

        $user->update(['role' => $validated['role']]);

        return redirect()->route('manajemen-admin.index')
            ->with('success', 'Role berhasil diubah menjadi ' . ucfirst($validated['role']));
    }

    public function toggleStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Don't allow deactivating current user
        // if ($user->id === auth()->id()) {
        if ($user->id == Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menonaktifkan akun sendiri'
            ], 400);
        }

        $validated = $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $user->update(['is_active' => $validated['is_active']]);

        return response()->json([
            'success' => true,
            'message' => 'Status user berhasil diubah'
        ]);
    }
}
