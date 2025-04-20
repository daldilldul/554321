@extends('layouts.app')

@section('title', 'Daftar Siswa')

@section('content')
<div class="bg-white rounded-md shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Daftar Siswa</h2>
        <a href="{{ route('siswa.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
            Tambah Siswa Baru
        </a>
    </div>

    <div class="mb-6 flex space-x-4">
        <a href="{{ route('bank.dashboard') }}" class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-md hover:bg-indigo-200">
            Approval Transaksi
        </a>
        <a href="{{ route('siswa.list') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
            Kelola Siswa
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 text-green-600">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left border-b">Nama</th>
                    <th class="px-4 py-2 text-left border-b">Email</th>
                    <th class="px-4 py-2 text-left border-b">Saldo</th>
                    <th class="px-4 py-2 text-left border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($siswa as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border-b">{{ $item->name }}</td>
                        <td class="px-4 py-2 border-b">{{ $item->email }}</td>
                        <td class="px-4 py-2 border-b">Rp{{ number_format($item->saldo, 0, ',', '.') }}</td>
                        <td class="px-4 py-2 border-b space-x-2">
                            <a href="{{ route('siswa.edit', $item->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('siswa.delete', $item->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus siswa ini?')" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

