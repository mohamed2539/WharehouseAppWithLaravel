<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إضافة كمية مباشرة</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4 text-gray-700">➕ إضافة كمية مباشرة للصنف</h2>

    <table class="w-full mb-6 border">
        <thead class="bg-gray-200 text-gray-700 text-sm">
            <tr>
                <th class="p-2">UPC</th>
                <th class="p-2">Style</th>
                <th class="p-2">Color</th>
                <th class="p-2">Size</th>
                <th class="p-2">Location</th>
                <th class="p-2">Quantity</th>
            </tr>
        </thead>
        <tbody id="stockTable">
            @foreach($stockItems as $item)
                <tr class="cursor-pointer hover:bg-gray-100" data-id="{{ $item->id }}">
                    <td class="p-2">{{ $item->product->upc }}</td>
                    <td class="p-2">{{ $item->product->style_name }}</td>
                    <td class="p-2">{{ $item->product->color }}</td>
                    <td class="p-2">{{ $item->product->size }}</td>
                    <td class="p-2">{{ $item->location }}</td>
                    <td class="p-2 quantity-cell" id="quantity-{{ $item->id }}">{{ $item->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $stockItems->links('pagination::tailwind') }}

    <div id="itemDetails" class="hidden border-t pt-4 mt-6">
        <h3 class="text-xl font-semibold text-gray-700 mb-2">🔍 تفاصيل الصنف:</h3>
        <div id="detailsContent" class="mb-4 text-sm text-gray-700"></div>

        <form id="addQuantityForm" class="flex items-center gap-4">
            <input type="number" id="quantityInput" name="quantity" min="1" placeholder="أدخل الكمية"
                   class="px-4 py-2 border rounded w-1/3" required>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                ➕ أضف الكمية
            </button>
        </form>

        <div id="message" class="mt-3 text-green-600 font-bold hidden"></div>
    </div>
</div>

<script>
    let selectedId = null;

    $('#stockTable tr').click(function () {
        selectedId = $(this).data('id');

        $.get('/get-stock-item/' + selectedId, function (data) {
            $('#detailsContent').html(`
                <p><strong>UPC:</strong> ${data.product.upc}</p>
                <p><strong>Style:</strong> ${data.product.style_name}</p>
                <p><strong>Color:</strong> ${data.product.color}</p>
                <p><strong>Size:</strong> ${data.product.size}</p>
                <p><strong>Location:</strong> ${data.location}</p>
                <p><strong>Current Quantity:</strong> <span id="currentQuantity">${data.quantity}</span></p>
            `);
            $('#itemDetails').removeClass('hidden');
            $('#message').hide();
        });
    });

    $('#addQuantityForm').submit(function (e) {
        e.preventDefault();

        let quantity = $('#quantityInput').val();

        $.post('/update-stock-quantity/' + selectedId, {
            quantity: quantity,
            _token: '{{ csrf_token() }}'
        }, function (data) {
            $('#message').text(data.message).removeClass('hidden');

            $('#currentQuantity').text(data.new_quantity);
            $('#quantity-' + selectedId).text(data.new_quantity);
            $('#quantityInput').val('');
        });
    });
</script>

</body>
</html>
