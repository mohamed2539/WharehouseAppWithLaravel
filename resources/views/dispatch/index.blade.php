@include('layouts.header')
@include('layouts.navbar')

<div class="max-w-7xl mx-auto p-4">
    <h2 class="text-xl font-bold text-blue-600 mb-4">📤 عمليات الصرف</h2>

    <table class="min-w-full bg-white border rounded shadow text-sm">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2">UPC</th>
                <th class="px-4 py-2">Style</th>
                <th class="px-4 py-2">Color</th>
                <th class="px-4 py-2">Size</th>
                <th class="px-4 py-2">المكان</th>
                <th class="px-4 py-2">الكمية</th>
                <th class="px-4 py-2">التاريخ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dispatches as $d)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $d->product->upc ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $d->product->style_name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $d->product->color ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $d->product->size ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $d->location }}</td>
                    <td class="px-4 py-2">{{ $d->quantity }}</td>
                    <td class="px-4 py-2">{{ $d->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4 pagination">
        {{ $dispatches->links('vendor.pagination.tailwind') }}
    </div>
</div>
