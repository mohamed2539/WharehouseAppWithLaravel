<nav class="bg-white shadow-lg mb-6">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <img src="/images/logo.png" alt="Logo" class="h-10 w-auto">
            <span class="text-xl font-bold text-blue-700">WarehouseApp</span>
        </div>

        <!-- Dropdown Menu -->
        <div class="relative">
    <!-- زر القائمة -->
    <button id="menuButton" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        القائمة <i class="fas fa-chevron-down ml-2"></i>
    </button>

    <!-- القائمة نفسها -->
    <ul id="dropdownMenu" class="absolute right-0 mt-2 bg-white border rounded shadow-lg z-10 text-sm min-w-[200px] hidden">
        <li><a href="/import-stock" class="block px-4 py-2 hover:bg-blue-100">📥 وارد من Excel</a></li>
        <li><a href="/order-dispatch" class="block px-4 py-2 hover:bg-blue-100">📤 صرف طلبية</a></li>
        <li><a href="/live-add-quantity" class="block px-4 py-2 hover:bg-blue-100">📦 كميات مباشرة</a></li>
        <li><a href="/transactions" class="block px-4 py-2 hover:bg-blue-100">📚 سجل الصرف</a></li>
        <li><a href="/stock-search" class="block px-4 py-2 hover:bg-blue-100">بحث </a></li>
        <li><a href="/manual-stock" class="block px-4 py-2 hover:bg-blue-100">✍️ وارد يدوي</a></li>
        <li><a href="/manual-dispatch" class="block px-4 py-2 hover:bg-blue-100">✍️ صرف يدوي</a></li>

    </ul>
</div>
    </div>
</nav>
<script>
    const menuButton = document.getElementById('menuButton');
    const dropdownMenu = document.getElementById('dropdownMenu');

    menuButton.addEventListener('click', function (e) {
        e.stopPropagation(); // علشان ما يقفلش القائمة لو دست تاني
        dropdownMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', function () {
        dropdownMenu.classList.add('hidden'); // يقفل القائمة لو ضغطت خارجها
    });
</script>