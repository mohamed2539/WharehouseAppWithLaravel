
<table class="min-w-full bg-white border rounded shadow text-sm">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2">UPC</th>
                <th class="px-4 py-2">Style</th>
                <th class="px-4 py-2">Color</th>
                <th class="px-4 py-2">Size</th>
                <th class="px-4 py-2">Location</th>
                <th class="px-4 py-2">Quantity</th>
                <th class="px-4 py-2">إجراء</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stockItems as $item)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $item->product->upc ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $item->product->style_name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $item->product->color ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $item->product->size ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $item->location }}</td>
                    <td class="px-4 py-2">{{ $item->quantity }}</td>
                    <td class="px-4 py-2">
                        <form action="{{ route('stock.delete', $item->id) }}" method="POST" onsubmit="return confirm('⚠️ هل تريد حذف هذا الصنف؟')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:text-red-800">🗑️ حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        @if($stockItems->isEmpty())
            <tr>
                <td colspan="7" class="text-center text-gray-500 py-4">لا توجد بيانات في المخزون حالياً.</td>
            </tr>
        @endif


    </table>

    <div class="mt-4 pagination">
            {{ $stockItems->links('vendor.pagination.tailwind') }}
    </div>

