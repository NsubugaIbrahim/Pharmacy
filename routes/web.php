<?php

	use Illuminate\Support\Facades\Route;

	/*
	|--------------------------------------------------------------------------
	| Web Routes
	|--------------------------------------------------------------------------
	|
	| Here is where you can register web routes for your application. These
	| routes are loaded by the RouteServiceProvider and all of them will
	| be assigned to the "web" middleware group. Make something great!
	|
	*/
	
	use App\Http\Controllers\HomeController;
	use App\Http\Controllers\RegisterController;
	use App\Http\Controllers\LoginController;
	use App\Http\Controllers\UserProfileController;
	use App\Http\Controllers\ResetPassword;
	use App\Http\Controllers\ChangePassword;
	use App\Http\Controllers\AdminController;
	use App\Http\Controllers\PharmacistController;
	use App\Http\Controllers\MedicalAssistantController;
	use App\Http\Controllers\AccountantController;
	use App\Http\Controllers\DrugController;
	use App\Http\Controllers\SupplierController;
	use App\Http\Controllers\StockController;
	use App\Http\Controllers\RoleController;
	use App\Http\Controllers\SaleController;
	use App\Http\Controllers\SearchController;
	use App\Http\Controllers\InventoryController;
	use App\Http\Controllers\UserController;

	Route::get('/', function () {return view('auth.login');});
	Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
	Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
	Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
	Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
	Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
	Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
	Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
	Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');
	
Route::group(['middleware' => 'auth'], function () {
	Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
	Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
	Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
	Route::post('logout', [LoginController::class, 'logout'])->name('logout');
	Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
	Route::get('/finances', [AdminController::class, 'finances'])->name('finances');
	Route::get('/pharmacist/dashboard', [PharmacistController::class, 'index'])->name('pharmacist.dashboard');
	Route::get('/medical-assistant/dashboard', [MedicalAssistantController::class, 'index'])->name('medical-assistant.dashboard');
	Route::get('/accountant/dashboard', [AccountantController::class, 'index'])->name('accountant.dashboard');
	Route::get('/drugs', [DrugController::class, 'index'])->name('drugs.index');
    Route::get('/drugs/add', [DrugController::class, 'addDrug'])->name('drugs.add');
    Route::post('/drugs/add', [DrugController::class, 'storeDrug'])->name('drugs.store');
    Route::get('/drugs/set-price', [DrugController::class, 'setSellingPriceForm'])->name('drugs.set_price');
    Route::post('/drugs/{drug}/set-price', [DrugController::class, 'updateSellingPrice'])->name('drugs.setprice.update');
	Route::get('drugs/{drug}/edit', [DrugController::class, 'edit'])->name('drugs.edit');
	Route::get('drugs/{drug}/sell', [DrugController::class, 'sell'])->name('drugs.sell');
	Route::put('drugs/{drug}', [DrugController::class, 'update'])->name('drugs.update');
	Route::delete('drugs/{drug}/delete', [DrugController::class, 'destroy'])->name('drugs.destroy');
	Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
	Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
	Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
	Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
	Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
	Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
	Route::get('/orderstock', [StockController::class, 'index'])->name('stock.index');
	Route::get('/inventory', [StockController::class, 'show'])->name('stock.show');
	Route::get('/stock/create', [StockController::class, 'create'])->name('stock.create');
	Route::post('/stock', [StockController::class, 'store'])->name('stock.store');
	Route::get('/stock/{stockEntry}/edit', [StockController::class, 'edit'])->name('stock.edit');
	Route::put('/stock/{stockEntry}', [StockController::class, 'update'])->name('stock.update');
	Route::delete('/stock/{stockEntry}', [StockController::class, 'destroy'])->name('stock.destroy');
	Route::get('/stock-history', [StockController::class, 'stockView'])->name('stock.view');
	Route::get('/approvestockorders', [StockController::class, 'approve_order'])->name('approve.stock.orders');
	Route::post('/stock/approve/{id}', [StockController::class, 'approveOrder'])->name('stock.approve');
	Route::post('/stock/decline/{id}', [StockController::class, 'declineOrder'])->name('stock.decline');
	Route::get('/receivestock', [StockController::class, 'receiveStock'])->name('receive.stock');
	Route::post('/stock/update-expiry/{order}', [StockController::class, 'receiveStockLogic'])->name('stock.update-expiry');
	Route::get('/inventory-stock', [StockController::class, 'inventory'])->name('inventory.stock');
	Route::post('/stock-orders', [StockController::class, 'store_order'])->name('stock_orders.store');
	Route::put('/inventory/{id}/update-price', [InventoryController::class, 'updatePrice'])->name('inventory.update-price');
	Route::get('/expiry-alerts', [InventoryController::class, 'nearExpiry'])->name('near.expiry');
	Route::get('/expired-drugs', [InventoryController::class, 'expiredDrugs'])->name('expired.drugs');
	Route::post('/dispose-drug/{id}', [InventoryController::class, 'disposeDrug'])->name('dispose.drug');
	Route::get('disposed-drugs', [InventoryController::class, 'disposedDrugs'])->name('disposed.drugs');
	Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
	Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
	Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
	Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
	Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
	Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
	Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
	Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
	Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
	Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
	Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
	Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
	Route::get('/sales', [SaleController::class, 'show'])->name('sales.show');
	Route::get('/sell', [SaleController::class, 'index'])->name('sales.index');
	Route::get('/get-selling-price/{drugId}', [SaleController::class, 'getSellingPrice'])->name('getSellingPrice');
	Route::post('/sell/store', [SaleController::class, 'store'])->name('sales.store');
	Route::get('/sell/report', [SaleController::class, 'report'])->name('sales.report');
	Route::post('/sell/cart/add', [SaleController::class, 'addToCart'])->name('sales.cart.add');
	Route::get('/sell/cart/remove/{index}', [SaleController::class, 'removeFromCart'])->name('sales.cart.remove');
	Route::post('/sell/checkout', [SaleController::class, 'finalizeSale'])->name('sales.checkout');
	Route::get('/sell/receipt', [SaleController::class, 'receipt'])->name('sales.receipt');
	Route::get('/mdashboard', [SaleController::class, 'salesHistory'])->name('sales.history');
	Route::get('/sales/receipt/{receipt_number}', [SaleController::class, 'viewReceiptByNumber'])->name('sales.receiptview');
	Route::get('sales/receipt/export/{receiptNumber}', [SaleController::class, 'exportReceipt'])->name('sales.exportReceipt');
	Route::get('/users', [UserController::class, 'index'])->name('user-management');
	Route::post('/users', [UserController::class, 'store'])->name('users.store');
	Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
	Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
	Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

//Search feature
Route::get('/api/search', [SearchController::class, 'search']);

Route::get('/medical-assistant/dashboard', [MedicalAssistantController::class, 'dashboard'])->name('medical-assistant.dashboard');
Route::get('/drugs/search', [MedicalAssistantController::class, 'searchDrugs'])->name('drugs.search');
Route::get('/drugs/get-price', [MedicalAssistantController::class, 'getDrugPrice'])->name('drugs.getPrice');
Route::get('/drugs/get-price', [MedicalAssistantController::class, 'getDrugPrice'])->name('drugs.getPrice');
Route::post('/medical-assistant/store-order', [MedicalAssistantController::class, 'storeOrder'])->name('medical-assistant.storeOrder');

  
?>