<?php
use App\Http\Controllers\StockImportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});







Route::get('/import-stock', [StockImportController::class, 'importForm'])->name('stock.importForm');
Route::post('/import-stock', [StockImportController::class, 'import'])->name('stock.import');
Route::get('/latest-stock', [StockImportController::class, 'latest'])->name('stock.latest');
Route::get('/export-stock', [StockImportController::class, 'export'])->name('stock.export');
Route::get('/stock-search', [StockImportController::class, 'searchPage'])->name('stock.search');
Route::get('/stock-search/live', [StockImportController::class, 'liveSearch'])->name('stock.liveSearch');
// Live Add Quantity
Route::get('/live-add-quantity', [StockImportController::class, 'liveAddPage'])->name('stock.liveAddPage');
Route::get('/get-stock-item/{id}', [StockImportController::class, 'getStockItem'])->name('stock.getItem');
Route::post('/update-stock-quantity/{id}', [StockImportController::class, 'updateStockQuantity'])->name('stock.updateQuantity');
// Live Add Quantity

