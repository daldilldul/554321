<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dompet Digital - @yield('title', 'Home')</title>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-indigo-600 text-white shadow-md">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="text-xl font-bold">Dompet Digital</div>
                @auth
                <div class="flex items-center space-x-4">
                    <span>{{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})</span>
                    {{-- @if(Auth::user()->role === 'siswa')
                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">
                        Saldo: Rp {{ number_format(Auth::user()->saldo, 0, ',', '.') }}
                    </span>
                    @endif --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-indigo-800 hover:bg-indigo-700 px-4 py-2 rounded-md text-sm">Logout</button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-6">
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
            {{ session('error') }}
        </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>
</html>
