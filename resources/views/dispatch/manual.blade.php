<!-- <!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>صرف يدوي</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
</head>
<body class="bg-gray-100 font-sans"> -->
@include('layouts.header')
@include('layouts.navbar')

<div class="max-w-xl mx-auto bg-white mt-10 p-8 rounded-xl shadow border">
    <h2 class="text-2xl font-bold mb-6 text-red-700">📤 صرف يدوي من المخزون</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            {{ $errors->first() }}
        </div>
    @endif

        <!-- داخل resources/views/dispatch/manual.blade.php مثلاً -->
<form action="{{ route('dispatch.storeManual') }}" method="POST" class="space-y-4">
    @csrf

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">UPC</label>
            <input type="text" id="upc_input" name="upc" class="w-full border rounded px-3 py-2" required>
            <input type="hidden" id="product_id" name="product_id">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Style Name</label>
            <input type="text" id="style_input" name="style_name" class="w-full border rounded px-3 py-2" readonly>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Color</label>
            <input type="text" id="color_input" name="color" class="w-full border rounded px-3 py-2" readonly>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Size</label>
            <input type="text" id="size_input" name="size" class="w-full border rounded px-3 py-2" readonly>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">الكمية المطلوبة</label>
            <input type="number" id="dispatch_quantity" name="quantity" min="1"
                   class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700">اسم المحل (اختياري)</label>
            <input type="text" name="store_name" class="w-full border rounded px-3 py-2">
        </div>
    </div>

    <div id="stock_info" class="text-sm text-green-700 font-bold mt-2 hidden"></div>

    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded mt-4">
        <i class="fas fa-paper-plane mr-2"></i> صرف الصنف
    </button>
</form>
</div>



<script>
$(function () {
    $('#upc_input').autocomplete({
        source: '/api/products/autocomplete',
        minLength: 2,
        select: function (event, ui) {
            $('#product_id').val(ui.item.id);
            $('#upc_input').val(ui.item.value);

            $.get('/api/product-details', { id: ui.item.id }, function (data) {
                $('#style_input').val(data.style);
                $('#color_input').val(data.color);
                $('#size_input').val(data.size);
                $('#stock_info')
                    .text(`🟢 الكمية المتاحة: ${data.quantity}`)
                    .removeClass('hidden')
                    .removeClass('text-red-600')
                    .addClass('text-green-700');

                if (data.quantity == 0) {
                    $('#stock_info')
                        .text(`🔴 لا توجد كمية متاحة للصنف`)
                        .removeClass('text-green-700')
                        .addClass('text-red-600');
                }
            });

            return false;
        }
    });
});
</script>

<!-- <script>
$(function () {
    $('#upc_input').autocomplete({
        source: '/api/products/autocomplete',
        minLength: 2,
        select: function (event, ui) {
            $('#product_id').val(ui.item.id);
            $('#upc_input').val(ui.item.value);

            $.get('/api/product-details', { id: ui.item.id }, function (data) {
                $('#style_input').val(data.style);
                $('#color_input').val(data.color);
                $('#size_input').val(data.size);
                $('#stock_info').text(`🟢 الكمية المتاحة: ${data.quantity}`).removeClass('hidden');
            });

            return false;
        }
    });
});
</script> -->

</body>
</html>
