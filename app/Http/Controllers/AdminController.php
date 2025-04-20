<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.dashboard', compact('users'));
    }

    public function createUser()
    {
        return view('admin.create-user');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:bank,siswa',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'saldo' => 0,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'User berhasil ditambahkan');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'role' => 'required|in:bank,siswa',
        ]);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'User berhasil diperbarui');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'User berhasil dihapus');
    }

    public function transactions()
    {
        $transactions = Transaction::with(['user', 'target'])->orderBy('created_at', 'desc')->get();
        return view('admin.transactions', compact('transactions'));
    }

    public function userTransactions($id)
    {
        $user = User::findOrFail($id);
        $transactions = Transaction::where('user_id', $id)
            ->orWhere('target_id', $id)
            ->with(['user', 'target'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.user-transactions', compact('user', 'transactions'));
    }

    public function downloadPdf($id)
    {
        $user = User::findOrFail($id);
        $transactions = Transaction::where('user_id', $id)
            ->orWhere('target_id', $id)
            ->with(['user', 'target'])
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.transactions-pdf', compact('user', 'transactions'));
        return $pdf->download('transactions-' . $user->name . '.pdf');
    }

    public function uhuy() {
        
    }
}
