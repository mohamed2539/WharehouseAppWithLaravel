@include('layouts.header')
@include('layouts.navbar')
<div class="max-w-6xl mx-auto bg-white p-8 rounded-2xl shadow-lg border border-gray-200">
    <h2 class="text-3xl font-bold mb-6 text-blue-700 flex items-center gap-2">
        <i class="fas fa-plus-circle text-blue-600"></i> إضافة كمية مباشرة للصنف
    </h2>

    <!-- مربع البحث -->
    <div class="mb-6 relative">
        <input type="text" id="searchInput" placeholder="ابحث عن الصنف بالـ UPC أو Style أو Color أو Size"
               class="w-full px-4 py-2 border rounded shadow focus:ring-2 focus:ring-blue-400"
               autocomplete="off">
        <ul id="searchResults" class="absolute bg-white border w-full shadow-lg z-10 hidden max-h-60 overflow-y-auto rounded mt-1">
            <!-- نتائج البحث ستظهر هنا -->
        </ul>
    </div>

    <!-- تفاصيل الصنف المختار -->
    <div id="itemDetails" class="hidden border-t pt-6 mt-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-3 flex items-center gap-2">
            <i class="fas fa-search text-gray-600"></i> تفاصيل الصنف:
        </h3>
        <div id="detailsContent" class="mb-4 text-sm text-gray-700 leading-relaxed"></div>

        <!-- نموذج الإضافة -->
        <form id="addQuantityForm" class="flex flex-col sm:flex-row items-center gap-4">
            <input type="number" id="quantityInput" name="quantity" min="1"
                   placeholder="أدخل الكمية الجديدة"
                   class="px-4 py-2 border border-gray-300 rounded-md w-full sm:w-1/3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                   required>
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg shadow transition duration-200">
                <i class="fas fa-plus mr-2"></i> أضف الكمية
            </button>
        </form>

        <!-- رسالة النجاح -->
        <div id="message" class="mt-4 text-green-600 font-bold hidden"></div>
    </div>
</div>

<!-- Script -->
<script>
    let selectedId = null;

    // البحث عند كتابة النص
    $('#searchInput').on('keyup', function () {
        let query = $(this).val();
        if (query.length < 2) {
            $('#searchResults').addClass('hidden').html('');
            return;
        }

        // إرسال Ajax للبحث عن الأصناف
        $.get('/stock-search/live', { query: query }, function (data) {
            let html = '';
            data.forEach(item => {
                html += `<li class="px-4 py-2 hover:bg-blue-100 cursor-pointer border-b" data-id="${item.id}">
                    ${item.product.upc} - ${item.product.style_name} - ${item.product.color} - ${item.product.size} (الموقع: ${item.location})
                </li>`;
            });

            $('#searchResults').removeClass('hidden').html(html);
        });
    });

    // عند الضغط على نتيجة البحث
    $('#searchResults').on('click', 'li', function () {
        selectedId = $(this).data('id');
        $('#searchResults').addClass('hidden');

        $.get('/get-stock-item/' + selectedId, function (data) {
            $('#detailsContent').html(`
                <p><strong>UPC:</strong> ${data.product.upc}</p>
                <p><strong>Style:</strong> ${data.product.style_name}</p>
                <p><strong>Color:</strong> ${data.product.color}</p>
                <p><strong>Size:</strong> ${data.product.size}</p>
                <p><strong>Location:</strong> ${data.location}</p>
                <p><strong>الكمية الحالية:</strong> <span id="currentQuantity">${data.quantity}</span></p>
            `);
            $('#itemDetails').removeClass('hidden');
            $('#message').hide();
            $('#searchInput').val('');
        });
    });

    // إرسال الكمية المضافة
    $('#addQuantityForm').submit(function (e) {
        e.preventDefault();

        let quantity = $('#quantityInput').val();

        $.post('/update-stock-quantity/' + selectedId, {
            quantity: quantity,
            _token: '{{ csrf_token() }}'
        }, function (data) {
            $('#message').text(data.message).removeClass('hidden');
            $('#currentQuantity').text(data.new_quantity);
            $('#quantityInput').val('');
        });
    });
</script>

</body>
</html>
