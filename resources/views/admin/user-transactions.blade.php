@extends('layouts.app')

@section('title', 'Transaksi User')

@section('content')
<div class="bg-white rounded-md shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Transaksi {{ $user->name }}</h2>
        <a href="{{ route('admin.users.transactions.pdf', $user->id) }}" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
            Download PDF
        </a>
    </div>

    <div class="mb-6">
        <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-800">
            &larr; Kembali ke Daftar User
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                        Tanggal
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                        Tipe
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                        Keterangan
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                        Jumlah
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                        Status
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($transactions as $transaction)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $transaction->created_at->format('d M Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ ucfirst($transaction->type) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if($transaction->type === 'transfer')
                            @if($transaction->user_id === $user->id)
                                Transfer ke {{ $transaction->target->name }}
                            @else
                                Terima dari {{ $transaction->user->name }}
                            @endif
                        @elseif($transaction->type === 'topup')
                            Top Up Saldo
                        @else
                            Withdraw
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if(($transaction->type === 'transfer' && $transaction->user_id === $user->id) || $transaction->type === 'withdraw')
                            <span class="text-red-600">- Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                        @elseif(($transaction->type === 'topup' && $transaction->status === 'rejected'))
                            <span class=>-</span>
                        @else
                            <span class="text-green-600">+ Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($transaction->status === 'pending')
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">
                            Menunggu
                        </span>
                        @elseif($transaction->status === 'approved')
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">
                            Disetujui
                        </span>
                        @else
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">
                            Ditolak
                        </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                        Tidak ada transaksi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
