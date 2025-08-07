@include('layouts.header')
@include('layouts.navbar')

<div class="max-w-7xl mx-auto p-4">
    <h2 class="text-xl font-bold text-blue-700 mb-4">📤 تقرير عمليات الصرف</h2>

    <form method="GET" action="{{ route('report.dispatch') }}" class="mb-4 flex gap-2">
        <input type="date" name="from" value="{{ $from }}" class="border rounded p-2" required>
        <input type="date" name="to" value="{{ $to }}" class="border rounded p-2" required>
        <button class="bg-blue-600 text-white px-4 py-2 rounded">عرض</button>
    </form>

    @if($dispatches->count())
        <a href="{{ route('report.dispatch.export', ['from' => $from, 'to' => $to]) }}" class="bg-green-600 text-white px-4 py-2 rounded mb-3 inline-block">📥 تصدير Excel</a>

        <div class="overflow-auto rounded shadow">
            <table class="min-w-full text-sm bg-white border">
                <thead class="bg-gray-200 text-left">
                    <tr>
                        <th class="px-4 py-2">UPC</th>
                        <th class="px-4 py-2">Style</th>
                        <th class="px-4 py-2">Color</th>
                        <th class="px-4 py-2">Size</th>
                        <th class="px-4 py-2">Location</th>
                        <th class="px-4 py-2">Quantity</th>
                        <th class="px-4 py-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dispatches as $item)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $item->product->upc ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $item->product->style_name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $item->product->color ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $item->product->size ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $item->location }}</td>
                            <td class="px-4 py-2">{{ $item->dispatched_quantity }}</td>
                            <td class="px-4 py-2">{{ $item->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $dispatches->appends(['from' => $from, 'to' => $to])->links('pagination::tailwind') }}
        </div>
    @else
        <div class="bg-yellow-100 text-yellow-800 p-3 rounded">
            لا توجد بيانات لعرضها في هذا النطاق الزمني.
        </div>
    @endif
</div>
