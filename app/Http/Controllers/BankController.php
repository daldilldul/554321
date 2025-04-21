<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BankController extends Controller
{
    public function dashboard()
    {
        $pendingTransactions = Transaction::where('status', 'pending')
            ->whereIn('type', ['topup', 'withdraw'])
            ->with(['user', 'target'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('bank.dashboard', compact('pendingTransactions'));
    }

    public function siswaList()
    {
        $siswa = User::where('role', 'siswa')->orderBy('name')->get();
        return view('bank.siswa-list', compact('siswa'));
    }

    // public function createSiswa()
    // {
    //     return view('bank.create-siswa');
    // }

    public function storeSiswa(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'siswa',
            'saldo' => 0,
        ]);

        return redirect()->route('bank.siswa.list')->with('success', 'Siswa berhasil ditambahkan');
    }

    public function updateSiswa(Request $request, $id)
    {
        $user = User::where('role', 'siswa')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
        ]);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        return redirect()->route('bank.siswa.list')->with('success', 'Siswa berhasil diperbarui');
    }

    public function deleteSiswa($id)
    {
        $user = User::where('role', 'siswa')->findOrFail($id);
        $user->delete();

        return redirect()->route('bank.siswa.list')->with('success', 'Siswa berhasil dihapus');
    }

    public function topupForm($id = null)
    {
        $siswa = null;
        $allSiswa = User::where('role', 'siswa')->orderBy('name')->get();

        if ($id) {
            $siswa = User::where('role', 'siswa')->findOrFail($id);
        }

        return view('bank.topup-form', compact('siswa', 'allSiswa'));
    }

    public function processTopup(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1000',
        ]);

        $siswa = User::findOrFail($validated['siswa_id']);

        // Langsung topup tanpa approval
        $siswa->saldo += $validated['amount'];
        $siswa->save();

        // Catat transaksi
        Transaction::create([
            'user_id' => $siswa->id,
            'type' => 'topup',
            'amount' => $validated['amount'],
            'status' => 'approved',
            'description' => 'Topup langsung oleh bank',
        ]);

        return redirect()->route('bank.siswa.list')->with('success', 'Topup berhasil dilakukan');
    }

    public function approveTransaction($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi sudah diproses sebelumnya');
        }

        $transaction->status = 'approved';
        $transaction->save();

        $user = $transaction->user;

        if ($transaction->type === 'topup') {
            $user->saldo += $transaction->amount;
            $user->save();
        } elseif ($transaction->type === 'withdraw') {
            // Pastikan saldo cukup (double-check)
            if ($user->saldo >= $transaction->amount) {
                $user->saldo -= $transaction->amount;
                $user->save();
            } else {
                $transaction->status = 'rejected';
                $transaction->descriptions = 'Saldo tidak cukup';
                $transaction->save();
                return back()->with('error', 'Saldo siswa tidak cukup');
            }
        }

        return back()->with('success', 'Transaksi berhasil disetujui');
    }

    public function rejectTransaction($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi sudah diproses sebelumnya');
        }

        $transaction->status = 'rejected';
        $transaction->save();

        return back()->with('success', 'Transaksi berhasil ditolak');
    }

    // public function requestWithdrawUser(Request $request)
    // {
    //     $validated = $request->validate([
    //         'amount' => 'required|numeric|min:1000',
    //     ]);

    //     $user = Auth::user();

    //     if ($user->saldo < $validated['amount']) {
    //         return back()->withErrors(['amount' => 'Saldo tidak cukup'])->withInput();
    //     }

    //     Transaction::create([
    //         'user_id' => $user->id,
    //         'type' => 'withdraw',
    //         'amount' => $validated['amount'],
    //         'status' => 'pending',
    //     ]);

    //     return redirect()->route('siswa.dashboard')->with('success', 'Permintaan withdraw berhasil dibuat, menunggu persetujuan bank');
    // }

    public function withdrawForm($id = null)
    {
        $siswa = null;
        $allSiswa = User::where('role', 'siswa')->orderBy('name')->get();

        if ($id) {
            $siswa = User::where('role', 'siswa')->findOrFail($id);
        }

        return view('bank.withdraw-form', compact('siswa', 'allSiswa'));
    }

    public function processWithdraw(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1000',
        ]);

        $siswa = User::findOrFail($validated['siswa_id']);

        // Langsung withdraw tanpa approval
        $siswa->saldo -= $validated['amount'];
        $siswa->save();

        // Catat transaksi
        Transaction::create([
            'user_id' => $siswa->id,
            'type' => 'withdraw',
            'amount' => $validated['amount'],
            'status' => 'approved',
            'description' => 'Withdraw langsung oleh bank',
        ]);

        return redirect()->route('bank.siswa.list')->with('success', 'Withdraw berhasil dilakukan');
    }
}
