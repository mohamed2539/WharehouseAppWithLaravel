<?php
use App\Http\Controllers\StockImportController;
use App\Http\Controllers\StockDispatchController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DispatchReportController;
use App\Http\Controllers\ReportController;
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




Route::get('/api/products/autocomplete', [StockDispatchController::class, 'autocomplete'])->name('products.autocomplete');
Route::get('/api/product-details', [StockDispatchController::class, 'productDetails'])->name('products.details');

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
Route::get('/export-missing-stock', [DashboardController::class, 'exportMissing'])->name('stock.exportMissing');



Route::get('/stock/manage', [StockController::class, 'manage'])->name('stock.manage');
Route::delete('/stock/delete/{id}', [StockController::class, 'delete'])->name('stock.delete');
Route::post('/stock/clear', [StockController::class, 'clearAll'])->name('stock.clear');

//port 2233

Route::get('/dispatches', [\App\Http\Controllers\DispatchController::class, 'index'])->name('dispatch.index');



// Route::get('/report', [\App\Http\Controllers\ReportController::class, 'index'])->name('report.index');
// Route::get('/report/export', [\App\Http\Controllers\ReportController::class, 'export'])->name('report.export');

// report routes/web.php
Route::get('/report/dispatches', [ReportController::class, 'dispatchReport'])->name('report.dispatch');
// Route::get('/report/imports', [ReportController::class, 'importReport'])->name('report.import');
Route::get('/report/import', [ReportController::class, 'importReport'])->name('report.import');
Route::get('/report/dispatches/export', [ReportController::class, 'exportDispatch'])->name('report.dispatch.export');
Route::get('/report/imports/export', [ReportController::class, 'exportImport'])->name('report.import.export');
