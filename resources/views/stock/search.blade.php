<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>بحث مباشر في المخزن</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100">
@include('layouts.navbar')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4 text-gray-700">🔎 بحث مباشر في الأصناف</h2>

    <input type="text" id="searchInput" placeholder="اكتب UPC أو Style أو لون أو مقاس..." class="w-full px-4 py-2 border rounded mb-4">

    <div id="results">
        <table class="min-w-full divide-y divide-gray-300 text-sm" id="resultsTable">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="px-2 py-1 text-start">UPC</th>
                    <th class="px-2 py-1 text-start">Style</th>
                    <th class="px-2 py-1 text-start">Color</th>
                    <th class="px-2 py-1 text-start">Size</th>
                    <th class="px-2 py-1 text-start">Location</th>
                    <th class="px-2 py-1 text-start">Quantity</th>
                </tr>
            </thead>
            <tbody id="resultsBody" class="divide-y divide-gray-100">
                <!-- النتائج هتتحط هنا -->
            </tbody>
        </table>
    </div>
</div>

<script>
    $('#searchInput').on('keyup', function () {
        let query = $(this).val();
        $.ajax({
            url: "{{ route('stock.liveSearch') }}",
            type: 'GET',
            data: { query: query },
            success: function (data) {
                let rows = '';
                data.forEach(item => {
                    rows += `<tr>
                        <td class="px-2 py-1">${item.product.upc}</td>
                        <td class="px-2 py-1">${item.product.style_name}</td>
                        <td class="px-2 py-1">${item.product.color}</td>
                        <td class="px-2 py-1">${item.product.size}</td>
                        <td class="px-2 py-1">${item.location}</td>
                        <td class="px-2 py-1">${item.quantity}</td>
                    </tr>`;
                });
                $('#resultsBody').html(rows);
            }
        });
    });
</script>

</body>
</html>
