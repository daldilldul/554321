@extends('layouts.app')

@section('title', 'Bank Dashboard')

@section('content')
<div class="bg-white rounded-md shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Dashboard Bank</h2>
    </div>

    <div class="mb-6 flex space-x-4">
        <a href="{{ route('bank.dashboard') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
            Approval Transaksi
        </a>
        <a href="{{ route('siswa.list') }}" class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-md hover:bg-indigo-200">
            Daftar Siswa
        </a>
        <a href="{{ route('topup.form') }}" class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-md hover:bg-indigo-200">
            Top Up Langsung
        </a>
    </div>

    <h3 class="text-xl font-semibold mb-4">Transaksi Menunggu Persetujuan</h3>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                        Tanggal
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                        Siswa
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                        Tipe
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                        Jumlah
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($pendingTransactions as $transaction)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $transaction->created_at->format('d M Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $transaction->user->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ ucfirst($transaction->type) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex space-x-2">
                        <form method="POST" action="{{ route('bank.transactions.approve', $transaction->id) }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                                Setujui
                            </button>
                        </form>
                        <form method="POST" action="{{ route('bank.transactions.reject', $transaction->id) }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                Tolak
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                        Tidak ada transaksi yang menunggu persetujuan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
