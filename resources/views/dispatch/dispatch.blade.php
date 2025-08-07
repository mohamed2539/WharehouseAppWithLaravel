@include('layouts.header')
@include('layouts.navbar')

<div class="max-w-7xl mx-auto p-6">
    <h2 class="text-xl font-bold text-blue-600 mb-4">📤 تقرير الصرف</h2>

    <form method="GET" class="mb-6 flex gap-4 items-end">
        <div>
            <label class="block text-sm text-gray-700">من تاريخ</label>
            <input type="date" name="from" value="{{ request('from') }}" class="border rounded p-2 w-full">
        </div>
        <div>
            <label class="block text-sm text-gray-700">إلى تاريخ</label>
            <input type="date" name="to" value="{{ request('to') }}" class="border rounded p-2 w-full">
        </div>
        <div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">عرض</button>
        </div>
    </form>


<!-- // <div class="test"> -->
// @foreach($dispatches as $item)
//     <p>Quantity: {{ $item->dispatched_quantity }}</p>
//     @endforeach
// </div>

    @if($dispatches->isEmpty())
        <div class="overflow-x-auto shadow rounded border bg-white">
            <table class="min-w-full text-sm text-gray-800">
                <thead class="bg-gray-100 text-gray-600 text-left">
                    <tr>
                        <th class="px-4 py-2">UPC</th>
                        <th class="px-4 py-2">Style</th>
                        <th class="px-4 py-2">Color</th>
                        <th class="px-4 py-2">Size</th>
                        <th class="px-4 py-2">Location</th>
                        <th class="px-4 py-2">Quantity</th>
                        <!-- <th class="px-4 py-2">تاريخ</th> -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($dispatches as $item)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $item->product->upc ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $item->product->style_name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $item->product->color ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $item->product->size ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $item->location }}</td>
                            <td class="px-4 py-2">{{ $item->dispatched_quantity ?? '0' }}</td>
                            <!-- <td class="px-4 py-2">{{ $item->created_at->format('Y-m-d H:i') }}</td> -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $dispatches->links('pagination::tailwind') }}
        </div>
    @else
        <div class="bg-yellow-100 text-yellow-800 p-3 rounded">
            لا توجد عمليات صرف في هذا النطاق.
        </div>
    @endif
</div>
