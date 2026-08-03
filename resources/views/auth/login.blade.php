<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Teras Abah Homestay</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Login Admin</h1>
            <p class="text-gray-500">Teras Abah Homestay</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full border-gray-300 rounded-md p-3 border focus:ring-blue-500 focus:border-blue-500" required autofocus>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" name="password" id="password" class="w-full border-gray-300 rounded-md p-3 border focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-900">Ingat Saya</label>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-900 text-white font-bold py-3 px-4 rounded hover:bg-blue-800 transition">
                Masuk ke Dasbor
            </button>
        </form>
        
        <div class="mt-6 text-center">
            <a href="{{ route('home') }}" class="text-sm text-blue-600 hover:underline">&larr; Kembali ke Halaman Utama</a>
        </div>
    </div>

</body>
</html>
