@include('layouts.header')
@include('layouts.navbar')

<div class="max-w-7xl mx-auto px-4 py-8 space-y-12">

    <!-- العنوان الرئيسي -->
    <h1 class="text-4xl font-extrabold text-blue-700 flex items-center gap-2 animate-pulse">
        📊 لوحة التحكم
    </h1>

    <!-- فلتر البحث -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="relative w-full md:w-1/2">
            <input type="text" id="tableSearch" placeholder="🔍 ابحث داخل الجدول..."
                   class="w-full px-5 py-3 text-sm border border-gray-300 rounded-xl shadow focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
    </div>

    <!-- ملخص الرصيد -->
    <section class="space-y-4">
        <h2 class="text-2xl font-semibold text-gray-800">📦 ملخص رصيد المنتجات</h2>

        <div class="overflow-x-auto bg-white rounded-xl shadow-md border border-gray-200">
            <table id="stockTable" class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-blue-50 text-blue-900 uppercase text-xs font-bold tracking-wide">
                    <tr>
                        <th class="px-6 py-3 text-center">UPC</th>
                        <th class="px-6 py-3 text-center">Style</th>
                        <th class="px-6 py-3 text-center">Color</th>
                        <th class="px-6 py-3 text-center">Size</th>
                        <th class="px-6 py-3 text-center">الرصيد الكلي</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100 text-center">
                    @foreach($stockSummary as $index => $product)
                        <tr class="transition hover:bg-blue-50 {{ $product->total_quantity == 0 ? 'bg-red-50' : ($index % 2 === 0 ? 'bg-gray-50' : '') }}">
                            <td class="px-4 py-3">{{ $product->upc }}</td>
                            <td class="px-4 py-3">{{ $product->style_name }}</td>
                            <td class="px-4 py-3">{{ $product->color }}</td>
                            <td class="px-4 py-3">{{ $product->size }}</td>
                            <td class="px-4 py-3 font-bold">
                            {{ $product->total_quantity ?? 0 }}
                            <!-- {{ $product->total_quantity }} -->
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <!-- الكروت -->
    <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gradient-to-r from-blue-100 to-blue-50 p-6 rounded-xl shadow-md border hover:scale-105 hover:shadow-xl transition duration-300 transform">
            <h3 class="text-lg font-semibold text-gray-700 mb-1">📦 إجمالي المنتجات</h3>
            <p class="text-5xl font-extrabold text-blue-700">{{ $totalProducts }}</p>
        </div>

        <div class="bg-gradient-to-r from-red-100 to-red-50 p-6 rounded-xl shadow-md border hover:scale-105 hover:shadow-xl transition duration-300 transform">
            <h3 class="text-lg font-semibold text-gray-700 mb-1">📤 عمليات الصرف (آخر 7 أيام)</h3>
            <p class="text-5xl font-extrabold text-red-700">{{ $weeklyDispatches->sum() }}</p>
        </div>
    </section>

    <!-- الرسم البياني -->
    <section class="bg-white p-6 rounded-xl shadow-md border">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">📅 عدد عمليات الصرف خلال آخر أسبوع</h3>
        <canvas id="dispatchChart" height="100"></canvas>
    </section>

    <!-- المنتجات غير المتوفرة -->
    @if($outOfStockProducts->count() > 0)
        <section class="bg-red-50 border border-red-300 p-6 rounded-xl shadow-md">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-red-800 flex items-center gap-2">
                    🚨 منتجات غير متوفرة في المخزون
                </h3>
                <a href="{{ route('stock.exportMissing') }}"
                   class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm shadow transition">
                    ⬇️ تصدير كـ Excel
                </a>
            </div>

            <div class="overflow-x-auto bg-white rounded-2xl shadow-md p-4 border border-gray-200">

<table class="min-w-full divide-y divide-gray-200 text-sm text-center">
    <thead class="bg-red-100 text-red-800 uppercase text-xs font-bold tracking-wider">
        <tr>
            <th class="px-6 py-3">UPC</th>
            <th class="px-6 py-3">Style</th>
            <th class="px-6 py-3">Color</th>
            <th class="px-6 py-3">Size</th>
            <th class="px-6 py-3">المخزون</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100 text-gray-700">
        @foreach($outOfStockProducts as $index => $product)
            <tr class="hover:bg-red-50 transition {{ $index % 2 === 0 ? 'bg-red-50/40' : '' }}">
                <td class="px-4 py-2">{{ $product->upc }}</td>
                <td class="px-4 py-2">{{ $product->style_name }}</td>
                <td class="px-4 py-2">{{ $product->color }}</td>
                <td class="px-4 py-2">{{ $product->size }}</td>
                <td class="px-4 py-2 font-bold text-red-600">0</td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Pagination -->
<div class="mt-6 flex justify-center">
    {{ $outOfStockProducts->links('pagination::tailwind') }}
</div>
</div>
        </section>
    @endif

</div>

<!-- Chart.js -->
<script>
    const ctx = document.getElementById('dispatchChart').getContext('2d');
    const dispatchChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($weeklyDispatches->keys()) !!},
            datasets: [{
                label: 'عدد العمليات',
                data: {!! json_encode($weeklyDispatches->values()) !!},
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>

<!-- فلترة الجدول -->
<script>
    const searchInput = document.getElementById('tableSearch');
    const table = document.getElementById('stockTable');
    const rows = table.getElementsByTagName('tr');

    searchInput.addEventListener('keyup', function () {
        const filter = searchInput.value.toLowerCase();

        for (let i = 1; i < rows.length; i++) {
            let rowText = rows[i].innerText.toLowerCase();
            rows[i].style.display = rowText.includes(filter) ? '' : 'none';
        }
    });
</script>
