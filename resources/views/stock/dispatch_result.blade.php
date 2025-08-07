@include('layouts.header')
@include('layouts.navbar')
<div class="max-w-6xl mx-auto bg-white p-8 rounded-2xl shadow-lg border border-gray-200">
    <!-- العنوان -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-clipboard-check text-green-600 mr-2"></i> نتيجة الصرف
        </h2>
        <!-- زر التصدير -->
        <form action="{{ route('dispatch.export') }}" method="POST">
            @csrf
            <input type="hidden" name="data" value="{{ json_encode($dispatchedItems) }}">
            <button class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded-lg transition duration-200 shadow">
                <i class="fas fa-file-excel mr-2"></i> تصدير Excel
            </button>
        </form>
    </div>

    <!-- جدول الأصناف المصروفة -->
    <div class="mb-8">
        <h3 class="text-xl font-semibold text-green-700 mb-3">
            <i class="fas fa-check-circle mr-2"></i> تم صرف الأصناف التالية:
        </h3>
        <div class="overflow-x-auto rounded-md border">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-green-100 text-green-900 font-semibold">
                    <tr>
                        <th class="p-3 text-center">#</th>
                        <th class="p-3 text-center">UPC</th>
                        <th class="p-3 text-center">Style</th>
                        <th class="p-3 text-center">Color</th>
                        <th class="p-3 text-center">Size</th>
                        <th class="p-3 text-center">Location</th>
                        <th class="p-3 text-center">الكمية</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dispatchedItems as $index => $item)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="p-2 text-center">{{ $index + 1 }}</td>
                            <td class="p-2 text-center">{{ $item['upc'] }}</td>
                            <td class="p-2 text-center">{{ $item['style'] }}</td>
                            <td class="p-2 text-center">{{ $item['color'] }}</td>
                            <td class="p-2 text-center">{{ $item['size'] }}</td>
                            <td class="p-2 text-center">{{ $item['location'] }}</td>
                            <td class="p-2 text-center font-bold text-green-700">{{ $item['dispatched'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- جدول الأصناف التي لم تُصرف -->
    @if(count($notFoundItems))
        <div>
            <h3 class="text-xl font-semibold text-red-600 mb-3">
                <i class="fas fa-times-circle mr-2"></i> لم يتم صرف بعض الأصناف:
            </h3>
            <div class="overflow-x-auto rounded-md border">
                <table class="min-w-full text-sm text-gray-700">
                    <thead class="bg-red-100 text-red-900 font-semibold">
                        <tr>
                            <th class="p-3 text-center">UPC</th>
                            <th class="p-3 text-center">Style</th>
                            <th class="p-3 text-center">Color</th>
                            <th class="p-3 text-center">Size</th>
                            <th class="p-3 text-center">الكمية غير المصروفة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notFoundItems as $item)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="p-2 text-center">{{ $item['upc'] }}</td>
                                <td class="p-2 text-center">{{ $item['style'] }}</td>
                                <td class="p-2 text-center">{{ $item['color'] }}</td>
                                <td class="p-2 text-center">{{ $item['size'] }}</td>
                                <td class="p-2 text-center font-bold text-red-700">{{ $item['qty'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

</body>
</html>
