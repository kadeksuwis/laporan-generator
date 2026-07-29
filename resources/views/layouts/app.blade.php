<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laporan Generator') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">
    <nav class="bg-white shadow p-4 mb-4">
        <a href="{{ route('reports.index') }}" class="font-bold text-lg">Laporan Generator</a>
    </nav>

    <main>
        @yield('content')
    </main>
</body>
</html>