<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>وارد المخزن</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-xl mx-auto mt-20 bg-white p-10 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-700">📦 استيراد وارد من Excel</h2>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('stock.import') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label for="file" class="block text-sm font-medium text-gray-700">اختر ملف Excel</label>
            <input type="file" name="file" id="file" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition">
            ⬆️ استيراد
        </button>
    </form>
</div>

</body>
</html>
