<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $transactions = Transaction::where('user_id', $user->id)
            ->orWhere('target_id', $user->id)
            ->with(['user', 'target'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('siswa.dashboard', compact('transactions'));
    }

    public function topupForm()
    {
        return view('siswa.topup-form');
    }

    public function requestTopup(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1000',
        ]);

        Transaction::create([
            'user_id' => Auth::id(),
            'type' => 'topup',
            'amount' => $validated['amount'],
            'status' => 'pending',
        ]);

        return redirect()->route('siswa.dashboard')->with('success', 'Permintaan top-up berhasil dibuat, menunggu persetujuan bank');
    }

    public function transferForm()
    {
        $siswa = User::where('role', 'siswa')
            ->where('id', '!=', Auth::id())
            ->orderBy('name')
            ->get();

        return view('siswa.transfer-form', compact('siswa'));
    }

    public function processTransfer(Request $request)
    {
        $validated = $request->validate([
            'target_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1000',
        ]);

        $user = Auth::findOrFail();
        $target = User::findOrFail($validated['target_id']);

        if ($user->saldo < $validated['amount']) {
            return back()->withErrors(['amount' => 'Saldo tidak cukup'])->withInput();
        }

        // Kurangi saldo pengirim
        $user->saldo -= $validated['amount'];
        $user->save();

        // Tambah saldo penerima
        $target->saldo += $validated['amount'];
        $target->save();

        // Catat transaksi
        Transaction::create([
            'user_id' => $user->id,
            'target_id' => $target->id,
            'type' => 'transfer',
            'amount' => $validated['amount'],
            'status' => 'approved',
        ]);

        return redirect()->route('siswa.dashboard')->with('success', 'Transfer berhasil dilakukan');
    }

    public function withdrawForm()
    {
        return view('siswa.withdraw-form');
    }

    public function requestWithdraw(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1000',
        ]);

        $user = Auth::user();

        if ($user->saldo < $validated['amount']) {
            return back()->withErrors(['amount' => 'Saldo tidak cukup'])->withInput();
        }

        Transaction::create([
            'user_id' => $user->id,
            'type' => 'withdraw',
            'amount' => $validated['amount'],
            'status' => 'pending',
        ]);

        return redirect()->route('siswa.dashboard')->with('success', 'Permintaan withdraw berhasil dibuat, menunggu persetujuan bank');
    }

    public function transactions()
    {
        $user = Auth::user();
        $transactions = Transaction::where('user_id', $user->id)
            ->orWhere('target_id', $user->id)
            ->with(['user', 'target'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('siswa.transactions', compact('transactions'));
    }
}
