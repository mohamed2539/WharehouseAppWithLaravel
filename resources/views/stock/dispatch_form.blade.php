<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>رفع طلبية صرف</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
@include('layouts.navbar')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4 text-gray-700">📤 رفع طلبية صرف من شيت Excel</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('dispatch.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <input type="file" name="file" accept=".xlsx,.xls,.csv" required class="w-full px-4 py-2 border rounded">
        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            ✅ رفع وتنفيذ الطلبية
        </button>
    </form>
</div>

</body>
</html>
