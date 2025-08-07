@include('layouts.header')
@include('layouts.navbar')
<div class="max-w-7xl mx-auto p-4">
    <h2 class="text-xl font-bold text-red-600 mb-4">📦 إدارة المخزون</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('stock.clear') }}" method="POST" onsubmit="return confirm('⚠️ هل أنت متأكد أنك تريد حذف كل الرصيد؟')">
        @csrf
        @method('DELETE')
        <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded mb-4">
            🗑️ حذف كل رصيد المخزون
        </button>
    </form>

    <div id="stockTableWrapper">
        @include('stock._table')
    </div>
  
</div>


<script>



console.log("✅ JavaScript loaded");

document.addEventListener('click', function (e) {
    const link = e.target.closest('.pagination a');
    if (link) {
        console.log("🔗 Pagination link clicked!");
        e.preventDefault();
        
    }
});



    // لما أضغط على أي رابط في pagination
    document.addEventListener('click', function (e) {
        const link = e.target.closest('.pagination a');

        if (link) {
            e.preventDefault();
            const url = link.getAttribute('href');
            fetchStockTable(url);
        }
    });

    function fetchStockTable(url) {
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'  // عشان Laravel يعرف إنه Ajax
            }
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById('stockTableWrapper').innerHTML = data;
        })
        .catch(error => {
            console.error('❌ Error fetching table:', error);
        });
    }
</script>

