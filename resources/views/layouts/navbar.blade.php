<nav class="bg-white shadow-lg mb-6">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
        
        <!-- الشعار -->
        <div class="flex items-center space-x-3">
            <div class="appLogo">
                <img src="{{ asset('pictures/logo.png') }}" alt="Logo" class="h-10 w-auto Logo">
            </div>
            <span class="text-xl font-bold text-blue-700">برنامج إدارة الطلبيات</span>
        </div>

        <!-- القائمة المنسدلة -->
        <div class="relative">
            <!-- زر القائمة -->
            <button id="menuButton" class="bg-blue-600 text-white px-5 py-2 rounded-xl hover:bg-blue-700 transition duration-200 shadow-md flex items-center gap-2 classMargin"> 
                القائمة
                <i class="fas fa-chevron-down"></i>
            </button>

            <!-- محتوى القائمة -->
            <ul id="dropdownMenu" class="absolute right-0 mt-5 bg-white border border-gray-200 rounded-xl shadow-lg z-50 min-w-[300px] hidden overflow-hidden classMargin">
                <li>
                    <a href="/dashboard" class="block px-5 py-3 hover:bg-blue-50 text-gray-700 hover:text-blue-600 transition flex items-center gap-2">
                        <i class="fas fa-chart-line"></i> لوحة التحكم
                    </a>
                </li>
                <li>
                    <a href="/import-stock" class="block px-5 py-3 hover:bg-blue-50 text-gray-700 hover:text-blue-600 transition flex items-center gap-2">
                        <i class="fas fa-file-import"></i> وارد من Excel
                    </a>
                </li>
                <li>
                    <a href="/order-dispatch" class="block px-5 py-3 hover:bg-blue-50 text-gray-700 hover:text-blue-600 transition flex items-center gap-2">
                        <i class="fas fa-truck"></i> صرف طلبية
                    </a>
                </li>
                <li>
                    <a href="/live-add-quantity" class="block px-5 py-3 hover:bg-blue-50 text-gray-700 hover:text-blue-600 transition flex items-center gap-2">
                        <i class="fas fa-boxes"></i>أضافة كمية لمنتج 
                    </a>
                </li>
                <li>
                    <a href="/transactions" class="block px-5 py-3 hover:bg-blue-50 text-gray-700 hover:text-blue-600 transition flex items-center gap-2">
                        <i class="fas fa-book"></i> سجل الصرف
                    </a>
                </li>
                <li>
                    <a href="/stock-search" class="block px-5 py-3 hover:bg-blue-50 text-gray-700 hover:text-blue-600 transition flex items-center gap-2">
                        <i class="fas fa-search"></i> بحث
                    </a>
                </li>
                <li>
                    <a href="/manual-stock" class="block px-5 py-3 hover:bg-blue-50 text-gray-700 hover:text-blue-600 transition flex items-center gap-2">
                        <i class="fas fa-pencil-alt"></i> وارد يدوي
                    </a>
                </li>
                <li>
                    <a href="/manual-dispatch" class="block px-5 py-3 hover:bg-blue-50 text-gray-700 hover:text-blue-600 transition flex items-center gap-2">
                        <i class="fas fa-sign-out-alt"></i> صرف يدوي
                    </a>
                </li>
                <li>
                    <a href="/report/dispatches" class="block px-5 py-3 hover:bg-blue-50 text-gray-700 hover:text-blue-600 transition flex items-center gap-2">
                    <i class="fas fa-clipboard-list"></i> تقرير الصرف
                    </a>
                </li>

                <li>
                    <a href="/report/import" class="block px-5 py-3 hover:bg-blue-50 text-gray-700 hover:text-blue-600 transition flex items-center gap-2">
                    <i class="fas fa-file"></i> تقرير الوارد
                    </a>
                </li>

        </ul>
        </div>
    </div>
</nav>
<script>
    const menuButton = document.getElementById('menuButton');
    const dropdownMenu = document.getElementById('dropdownMenu');

    // عند الضغط على زر القائمة
    menuButton.addEventListener('click', function (e) {
        e.stopPropagation();
        dropdownMenu.classList.toggle('hidden');
    });

    // إخفاء القائمة عند الضغط في أي مكان خارجها
    document.addEventListener('click', function (e) {
        if (!menuButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });
</script>
