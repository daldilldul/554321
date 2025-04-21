@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
    <div class="bg-white rounded-md shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Dashboard Siswa</h2>
            <div>
                <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-md">
                    Saldo: <span class="font-bold">Rp {{ number_format(Auth::user()->saldo, 0, ',', '.') }}</span>
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <button type="button" data-modal-target="topup-modal" data-modal-toggle="topup-modal"
                class="bg-green-500 text-white rounded-md p-6 flex flex-col items-center hover:bg-green-600 transition">
                <div class="text-xl mb-2">Top Up</div>
                <div class="text-sm">Tambah saldo</div>
            </button>
            <div id="topup-modal" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow-sm">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 pb-0">
                            <h3 class="text-2xl font-bold text-green-600">
                                Request Top Up
                            </h3>
                            <button type="button"
                                class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="topup-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5">
                            <form method="POST" action="{{ route('siswa.topup.request') }}">
                                @csrf
                                <div class="mb-6">
                                    <label for="amount" class="block text-gray-700 mb-2">Jumlah (Rp)</label>
                                    <input type="number" name="amount" id="amount" value="{{ old('amount', 10000) }}"
                                        min="1000" step="1000" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200">
                                    @error('amount')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                    <p class="text-sm text-gray-500 mt-1">Minimal top up Rp 1.000</p>
                                </div>

                                <div class="mb-6">
                                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-yellow-700">
                                                    Permintaan top up akan menunggu persetujuan dari bank.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between">
                                    <button type="submit"
                                        class="bg-green-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring focus:ring-indigo-200">
                                        Request Top Up
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
            Toggle modal
          </button> --}}

            <button type="button" data-modal-target="transfer-modal" data-modal-toggle="transfer-modal"
                class="bg-blue-500 text-white rounded-md p-6 flex flex-col items-center hover:bg-blue-600 transition">
                <div class="text-xl mb-2">Transfer</div>
                <div class="text-sm">Kirim ke siswa lain</div>
            </button>
            <div id="transfer-modal" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow-sm">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 pb-0">
                            <h2 class="text-2xl font-bold text-blue-600">Transfer Saldo</h2>

                            <button type="button"
                                class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="transfer-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-4">
                            <div class="mb-4 bg-indigo-50 p-4 rounded-md">
                                <p class="text-indigo-800">Saldo Anda: <span class="font-bold">Rp
                                        {{ number_format(Auth::user()->saldo, 0, ',', '.') }}</span></p>
                            </div>

                            <form method="POST" action="{{ route('siswa.transfer.process') }}">
                                @csrf
                                <div class="mb-4">
                                    <label for="target_id" class="block text-gray-700 mb-2">Pilih Penerima</label>
                                    <select name="target_id" id="target_id" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200">
                                        <option value="" disabled selected>-- Pilih Siswa --</option>
                                        @foreach ($siswa as $s)
                                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('target_id')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-6">
                                    <label for="amount" class="block text-gray-700 mb-2">Jumlah (Rp)</label>
                                    <input type="number" name="amount" id="amount"
                                        value="{{ old('amount', 1000) }}" min="1000" step="1000" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200">
                                    @error('amount')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                    <p class="text-sm text-gray-500 mt-1">Minimal transfer Rp 1.000</p>
                                </div>

                                <div class="flex items-center justify-between">
                                    <button type="submit"
                                        class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring focus:ring-indigo-200">
                                        Transfer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" data-modal-target="withdraw-modal" data-modal-toggle="withdraw-modal"
                class="bg-purple-500 text-white rounded-md p-6 flex flex-col items-center hover:bg-purple-600 transition">
                <div class="text-xl mb-2">Withdraw</div>
                <div class="text-sm">Tarik saldo</div>
            </button>
            <div id="withdraw-modal" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow-sm">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 pb-0">
                            <h2 class="text-2xl font-bold text-blue-600">Withdraw Saldo</h2>

                            <button type="button"
                                class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="withdraw-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-4">
                            <div class="mb-4 bg-indigo-50 p-4 rounded-md">
                                <p class="text-indigo-800">Saldo Anda: <span class="font-bold">Rp {{ number_format(Auth::user()->saldo, 0, ',', '.') }}</span></p>
                            </div>

                            <form method="POST" action="{{ route('siswa.withdraw.request') }}">
                                @csrf
                                <div class="mb-6">
                                    <label for="amount" class="block text-gray-700 mb-2">Jumlah (Rp)</label>
                                    <input type="number" name="amount" id="amount" value="{{ old('amount', 10000) }}" min="1000" step="1000" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200">
                                    @error('amount')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                    <p class="text-sm text-gray-500 mt-1">Minimal withdraw Rp 1.000</p>
                                </div>

                                <div class="mb-6">
                                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-yellow-700">
                                                    Permintaan withdraw akan menunggu persetujuan dari bank.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between">
                                    <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring focus:ring-indigo-200">
                                        Request Withdraw
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="mb-4 flex justify-between items-center">
            <h3 class="text-xl font-semibold">Transaksi Terakhir</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th
                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                            Tanggal
                        </th>
                        <th
                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                            Tipe
                        </th>
                        <th
                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                            Keterangan
                        </th>
                        <th
                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                            Jumlah
                        </th>
                        <th
                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
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
                                @if ($transaction->type === 'transfer')
                                    @if ($transaction->user_id === Auth::id())
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
                                @if (($transaction->type === 'transfer' && $transaction->user_id === Auth::id()) || $transaction->type === 'withdraw')
                                    <span class="text-red-600">- Rp
                                        {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                                @elseif($transaction->type === 'topup'  $transaction->type === 'withdraw' && $transaction->status === 'rejected')
                                    <span>-</span>
                                @else
                                    <span class="text-green-600">+ Rp
                                        {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if ($transaction->status === 'pending')
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
                                Belum ada transaksi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

{{-- @extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div>
    <h2>Dashboard Siswa</h2>
    <p>Saldo: Rp {{ number_format(Auth::user()->saldo, 0, ',', '.') }}</p>

    <div>
        <form action="{{ route('siswa.topup.form') }}" method="get" style="margin-bottom: 10px;">
            <button type="submit">Top Up - Tambah saldo</button>
        </form>

        <form action="{{ route('siswa.transfer.form') }}" method="get" style="margin-bottom: 10px;">
            <button type="submit">Transfer - Kirim ke siswa lain</button>
        </form>

        <form action="{{ route('siswa.withdraw.form') }}" method="get">
            <button type="submit">Withdraw - Tarik saldo</button>
        </form>
    </div>


    <h3>Transaksi Terakhir</h3>
    <p><a href="{{ route('siswa.transactions') }}">Lihat Semua</a></p>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Tipe</th>
                <th>Keterangan</th>
                <th>Jumlah</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $transaction)
            <tr>
                <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                <td>{{ ucfirst($transaction->type) }}</td>
                <td>
                    @if ($transaction->type === 'transfer')
                        @if ($transaction->user_id === Auth::id())
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
                <td>
                    @if (($transaction->type === 'transfer' && $transaction->user_id === Auth::id()) || $transaction->type === 'withdraw')
                        - Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                    @elseif(($transaction->status === 'rejected' && $transaction->user_id === Auth::id()))
                        -
                    @else
                        + Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                    @endif
                </td>
                <td>
                    @if ($transaction->status === 'pending')
                        Menunggu
                    @elseif($transaction->status === 'approved')
                        Disetujui
                    @else
                        Ditolak
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">Belum ada transaksi</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection --}}
