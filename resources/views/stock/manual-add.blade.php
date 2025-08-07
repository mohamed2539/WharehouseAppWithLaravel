@include('layouts.header')
@include('layouts.navbar')

<div class="flex justify-center items-start min-h-screen bg-gray-100 px-4 py-10">
    <div class="w-1/2 max-w-xl bg-white p-6 rounded-2xl shadow-md border border-gray-200 HightClass">

        <!-- العنوان -->
        <h2 class="text-2xl font-bold text-blue-700 mb-6 flex items-center gap-2">
            📥 إضافة وارد يدوي
        </h2>

        <!-- رسالة نجاح -->
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded-lg mb-6 border border-green-200 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- الفورم -->
        <form action="{{ route('stock.storeManual') }}" method="POST" class="space-y-5">
            @csrf

            <!-- الحقول -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">UPC</label>
                    <input type="text" name="upc" required
                           class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none transition hover:border-blue-400">
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Style Name</label>
                    <input type="text" name="style_name" required
                           class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none transition hover:border-blue-400">
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Color</label>
                    <input type="text" name="color" required
                           class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none transition hover:border-blue-400">
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Size</label>
                    <input type="text" name="size" required
                           class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none transition hover:border-blue-400">
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Location</label>
                    <input type="text" name="location" required
                           class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none transition hover:border-blue-400">
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Quantity</label>
                    <input type="number" name="quantity" min="1" required
                           class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none transition hover:border-blue-400">
                </div>
            </div>

            <!-- زر الحفظ -->
            <div class="pt-3 text-center">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 mt-6 rounded-lg shadow-md transition duration-200 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-save mr-2"></i> حفظ الصنف
                </button>
            </div>
        </form>

    </div>
</div>

</body>
</html>
