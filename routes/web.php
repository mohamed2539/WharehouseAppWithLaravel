<?php
use App\Http\Controllers\StockImportController;
use App\Http\Controllers\StockDispatchController;
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


// dispatch
Route::get('/order-dispatch', [StockDispatchController::class, 'form'])->name('dispatch.form');
Route::post('/order-dispatch', [StockDispatchController::class, 'import'])->name('dispatch.import');
Route::post('/export-dispatch', [StockDispatchController::class, 'export'])->name('dispatch.export');

// dispatch

// routes/web.php
Route::get('/manual-stock', [StockImportController::class, 'manualForm'])->name('stock.manualForm');
Route::post('/manual-stock', [StockImportController::class, 'storeManual'])->name('stock.storeManual');


Route::get('/manual-dispatch', [StockDispatchController::class, 'manualForm'])->name('dispatch.manualForm');
Route::post('/manual-dispatch', [StockDispatchController::class, 'storeManual'])->name('dispatch.storeManual');