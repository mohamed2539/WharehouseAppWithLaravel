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

    <form action="{{ route('dispatch.storeManual') }}" method="POST" class="space-y-4">
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">UPC</label>
                <input type="text" name="upc" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Style Name</label>
                <input type="text" name="style_name" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Color</label>
                <input type="text" name="color" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Size</label>
                <input type="text" name="size" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Location</label>
                <input type="text" name="location" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Quantity</label>
                <input type="number" name="quantity" min="1" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700">اسم المحل (اختياري)</label>
                <input type="text" name="store_name" class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded mt-4">
            <i class="fas fa-paper-plane mr-2"></i> صرف الصنف
        </button>
    </form>
</div>

</body>
</html>
