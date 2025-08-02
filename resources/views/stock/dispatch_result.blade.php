<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>نتائج الصرف</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-7xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold text-gray-700 mb-4">📦 نتيجة الصرف</h2>
    <form action="{{ route('dispatch.export') }}" method="POST" class="mb-4">
    @csrf
    <input type="hidden" name="data" value="{{ json_encode($dispatchedItems) }}">
    <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
        📥 تصدير كـ Excel
    </button>
</form>




    <div class="mb-6">
        <h3 class="text-lg font-semibold mb-2 text-green-600">✅ تم صرف:</h3>
        <table class="min-w-full text-sm border mb-4">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-2">Sn</th>
                    <th class="p-2">UPC</th>
                    <th class="p-2">Style</th>
                    <th class="p-2">Color</th>
                    <th class="p-2">Size</th>
                    <th class="p-2">Location</th>
                    <th class="p-2">Quantity</th>
                </tr>
            </thead>
            <tbody>
            @foreach($dispatchedItems as $index => $item)
                    <tr>
                        <td class="p-2">{{ $index + 1 }}</td>
                        <td class="p-2">{{ $item['upc'] }}</td>
                        <td class="p-2">{{ $item['style'] }}</td>
                        <td class="p-2">{{ $item['color'] }}</td>
                        <td class="p-2">{{ $item['size'] }}</td>
                        <td class="p-2">{{ $item['location'] }}</td>
                        <td class="p-2">{{ $item['dispatched'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if(count($notFoundItems))
        <div>
            <h3 class="text-lg font-semibold mb-2 text-red-600">❌ لم يتم صرف بعض الأصناف:</h3>
            <table class="min-w-full text-sm border">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-2">UPC</th>
                        <th class="p-2">Style</th>
                        <th class="p-2">Color</th>
                        <th class="p-2">Size</th>
                        <th class="p-2">الكمية غير المصروفة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notFoundItems as $item)
                        <tr>
                            <td class="p-2">{{ $item['upc'] }}</td>
                            <td class="p-2">{{ $item['style'] }}</td>
                            <td class="p-2">{{ $item['color'] }}</td>
                            <td class="p-2">{{ $item['size'] }}</td>
                            <td class="p-2">{{ $item['qty'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>

</body>
</html>
