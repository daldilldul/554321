@extends('layouts.app')

@section('title', 'Top Up Saldo Siswa')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-md shadow-md">
    <h2 class="text-2xl font-bold mb-6">Top Up Saldo Siswa</h2>

    <form method="POST" action="{{ route('bank.topup.process') }}">
        @csrf
        <div class="mb-4">
            <label for="siswa_id" class="block text-gray-700 mb-2">Pilih Siswa</label>
            <select name="siswa_id" id="siswa_id" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200">
                @if($siswa)
                    <option value="{{ $siswa->id }}" selected>{{ $siswa->name }} (Rp {{ number_format($siswa->saldo, 0, ',', '.') }})</option>
                @else
                    <option value="" disabled selected>-- Pilih Siswa --</option>
                    @foreach($allSiswa as $s)
                        <option value="{{ $s->id }}">{{ $s->name }} (Rp {{ number_format($s->saldo, 0, ',', '.') }})</option>
                    @endforeach
                @endif
            </select>
            @error('siswa_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="amount" class="block text-gray-700 mb-2">Jumlah (Rp)</label>
            <input type="number" name="amount" id="amount" value="{{ old('amount', 10000) }}" min="1000" step="1000" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200">
            @error('amount')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-sm text-gray-500 mt-1">Minimal top up Rp 1.000</p>
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('bank.siswa.list') }}" class="text-indigo-600 hover:text-indigo-800">
                Kembali
            </a>
            <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring focus:ring-indigo-200">
                Proses Top Up
            </button>
        </div>
    </form>
</div>
@endsection
