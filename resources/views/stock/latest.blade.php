<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>أحدث الوارد</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6 font-sans">

<div class="max-w-7xl mx-auto bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-700">📦 أحدث الأصناف الواردة</h2>
        <a href="{{ route('stock.export') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
            ⬇️ تصدير إلى Excel
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-300 text-sm">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="px-4 py-2 text-start">UPC</th>
                    <th class="px-4 py-2 text-start">Style</th>
                    <th class="px-4 py-2 text-start">Color</th>
                    <th class="px-4 py-2 text-start">Size</th>
                    <th class="px-4 py-2 text-start">Location</th>
                    <th class="px-4 py-2 text-start">Quantity</th>
                    <th class="px-4 py-2 text-start">تاريخ الإضافة</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($stockItems as $item)
                    <tr>
                        <td class="px-4 py-2">{{ $item->product->upc }}</td>
                        <td class="px-4 py-2">{{ $item->product->style_name }}</td>
                        <td class="px-4 py-2">{{ $item->product->color }}</td>
                        <td class="px-4 py-2">{{ $item->product->size }}</td>
                        <td class="px-4 py-2">{{ $item->location }}</td>
                        <td class="px-4 py-2">{{ $item->quantity }}</td>
                        <td class="px-4 py-2">{{ $item->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $stockItems->links('pagination::tailwind') }}
    </div>
</div>

</body>
</html>
