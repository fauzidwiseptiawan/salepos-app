<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CostumerController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SubTypeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\WarehouseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.index');
});

// route login
Route::get('login-form', [LoginController::class, 'index'])->name('auth');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth', 'checklevels:Admin']], function () {
    // route home
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // route user
    Route::get('user/profile/{id}', [UserController::class, 'profile'])->name('user.profile');
    Route::post('user/profile/{id}', [UserController::class, 'profileUpdate'])->name('user.updateProfile');
    Route::post('user/change-password/{id}', [UserController::class, 'changePassword'])->name('user.changePassword');
    Route::resource('user', UserController::class);
    // route brand
    Route::get('brandlist/fetch', [BrandController::class, 'fetch'])->name('brandlist.fetch');
    Route::post('brandlist/destroySelected', [BrandController::class, 'destroySelected'])->name('brandlist.destroySelected');
    Route::post('brandlist/import', [BrandController::class, 'importBrand'])->name('brandlist.import');
    Route::get('brandlist/exportPDF', [BrandController::class, 'exportPDFBrand'])->name('brandlist.exportPDF');
    Route::resource('brandlist', BrandController::class);
    // // route unit
    Route::get('unitlist/fetch', [UnitController::class, 'fetch'])->name('unitlist.fetch');
    Route::post('unitlist/destroySelected', [UnitController::class, 'destroySelected'])->name('unitlist.destroySelected');
    Route::post('unitlist/import', [UnitController::class, 'importUnit'])->name('unitlist.import');
    Route::get('unitlist/exportPDF', [UnitController::class, 'exportPDFUnit'])->name('unitlist.exportPDF');
    Route::resource('unitlist', UnitController::class);
    // // route type
    Route::get('typelist/fetch', [TypeController::class, 'fetch'])->name('typelist.fetch');
    Route::post('typelist/destroySelected', [TypeController::class, 'destroySelected'])->name('typelist.destroySelected');
    Route::post('typelist/import', [TypeController::class, 'importType'])->name('typelist.import');
    Route::get('typelist/exportPDF', [TypeController::class, 'exportPDFType'])->name('typelist.exportPDF');
    Route::resource('typelist', TypeController::class);
    // // route sub type
    Route::get('subtypelist/fetch', [SubTypeController::class, 'fetch'])->name('subtypelist.fetch');
    Route::post('subtypelist/destroySelected', [SubTypeController::class, 'destroySelected'])->name('subtypelist.destroySelected');
    Route::post('subtypelist/import', [SubTypeController::class, 'importSubType'])->name('subtypelist.import');
    Route::get('subtypelist/exportPDF', [SubTypeController::class, 'exportPDFSubType'])->name('subtypelist.exportPDF');
    Route::resource('subtypelist', SubTypeController::class);
    // // route bank
    Route::get('banklist/fetch', [BankController::class, 'fetch'])->name('banklist.fetch');
    Route::post('banklist/destroySelected', [BankController::class, 'destroySelected'])->name('banklist.destroySelected');
    Route::post('banklist/import', [BankController::class, 'importBank'])->name('banklist.import');
    Route::get('banklist/exportPDF', [BankController::class, 'exportPDFBank'])->name('banklist.exportPDF');
    Route::resource('banklist', BankController::class);
    // // route warehouse
    Route::get('warehouselist/fetch', [WarehouseController::class, 'fetch'])->name('warehouselist.fetch');
    Route::post('warehouselist/destroySelected', [WarehouseController::class, 'destroySelected'])->name('warehouselist.destroySelected');
    Route::post('warehouselist/import', [WarehouseController::class, 'importWarehouse'])->name('warehouselist.import');
    Route::get('warehouselist/exportPDF', [WarehouseController::class, 'exportPDFWarehouse'])->name('warehouselist.exportPDF');
    Route::resource('warehouselist', WarehouseController::class);
    // // route supplier
    Route::get('supplierlist/fetch', [SupplierController::class, 'fetch'])->name('supplierlist.fetch');
    Route::post('supplierlist/destroySelected', [SupplierController::class, 'destroySelected'])->name('supplierlist.destroySelected');
    Route::post('supplierlist/import', [SupplierController::class, 'importSupplier'])->name('supplierlist.import');
    Route::get('supplierlist/exportPDF', [SupplierController::class, 'exportPDFSupplier'])->name('supplierlist.exportPDF');
    Route::resource('supplierlist', SupplierController::class);
    // // route costumer
    Route::get('costumerlist/fetch', [CostumerController::class, 'fetch'])->name('costumerlist.fetch');
    Route::post('costumerlist/destroySelected', [CostumerController::class, 'destroySelected'])->name('costumerlist.destroySelected');
    Route::post('costumerlist/import', [CostumerController::class, 'importCostumer'])->name('costumerlist.import');
    Route::get('costumerlist/exportPDF', [CostumerController::class, 'exportPDFCostumer'])->name('costumerlist.exportPDF');
    Route::resource('costumerlist', CostumerController::class);
    // // route item
    Route::get('itemlist/fetch', [ItemController::class, 'fetch'])->name('itemlist.fetch');
    Route::get('itemlist/getbyid/{id}', [ItemController::class, 'getById'])->name('itemlist.getById');
    Route::post('itemlist/destroySelected', [ItemController::class, 'destroySelected'])->name('itemlist.destroySelected');
    Route::post('itemlist/import', [ItemController::class, 'importItem'])->name('itemlist.import');
    Route::get('itemlist/exportPDF', [ItemController::class, 'exportPDFItem'])->name('itemlist.exportPDF');
    Route::get('itemlist/details/{id}', [ItemController::class, 'details'])->name('itemlist.details');
    Route::resource('itemlist', ItemController::class);
    // route order purchase
    Route::get('purchaseorderlist/fetch', [PurchaseOrderController::class, 'fetch'])->name('purchaseorderlist.fetch');
    Route::get('purchaseorderlist/fetchSupplier', [PurchaseOrderController::class, 'fetchSupplier'])->name('purchaseorderlist.fetchSupplier');
    Route::get('purchaseorderlist/fetchItem', [PurchaseOrderController::class, 'fetchItem'])->name('purchaseorderlist.fetchItem');
    Route::post('purchaseorderlist/destroySelected', [PurchaseOrderController::class, 'destroySelected'])->name('purchaseorderlist.destroySelected');
    Route::get('purchaseorderlist/getSupplier/{id}', [PurchaseOrderController::class, 'getSupplier'])->name('purchaseorderlist.getSupplier');
    Route::post('purchaseorderlist/showSelected', [PurchaseOrderController::class, 'showSelected'])->name('purchaseorderlist.showSelected');
    Route::post('purchaseorderlist/updatePrice/{id}', [PurchaseOrderController::class, 'updatePrice'])->name('purchaseorderlist.updatePrice');
    Route::post('purchaseorderlist/changePurchasePrice/{id}', [PurchaseOrderController::class, 'changePurchasePrice'])->name('purchaseorderlist.changePurchasePrice');
    Route::get('purchaseorderlist/getItem/{id}', [PurchaseOrderController::class, 'getItem'])->name('purchaseorderlist.getItem');
    Route::post('purchaseorderlist/import', [PurchaseOrderController::class, 'importPurchaseOrder'])->name('purchaseorderlist.import');
    Route::get('purchaseorderlist/exportPDF', [PurchaseOrderController::class, 'exportPDFimportPurchaseOrder'])->name('purchaseorderlist.exportPDF');
    Route::get('purchaseorderlist/details/{id}', [PurchaseOrderController::class, 'details'])->name('purchaseorderlist.details');
    Route::get('purchaseorderlist/print/{id}', [PurchaseOrderController::class, 'print'])->name('purchaseorderlist.print');
    Route::resource('purchaseorderlist', PurchaseOrderController::class);
    // route purchase
    Route::get('purchaselist/fetch', [PurchaseController::class, 'fetch'])->name('purchaselist.fetch');
    Route::get('purchaselist/fetchSupplier', [PurchaseController::class, 'fetchSupplier'])->name('purchaselist.fetchSupplier');
    Route::get('purchaselist/fetchItem', [PurchaseController::class, 'fetchItem'])->name('purchaselist.fetchItem');
    Route::post('purchaselist/destroySelected', [PurchaseController::class, 'destroySelected'])->name('purchaselist.destroySelected');
    Route::get('purchaselist/getSupplier/{id}', [PurchaseController::class, 'getSupplier'])->name('purchaselist.getSupplier');
    Route::post('purchaselist/showSelected', [PurchaseController::class, 'showSelected'])->name('purchaselist.showSelected');
    Route::post('purchaselist/updatePrice/{id}', [PurchaseController::class, 'updatePrice'])->name('purchaselist.updatePrice');
    Route::post('purchaselist/changePurchasePrice/{id}', [PurchaseController::class, 'changePurchasePrice'])->name('purchaselist.changePurchasePrice');
    Route::get('purchaselist/getItem/{id}', [PurchaseController::class, 'getItem'])->name('purchaselist.getItem');
    Route::post('purchaselist/import', [PurchaseController::class, 'importPurchaseOrder'])->name('purchaselist.import');
    Route::get('purchaselist/exportPDF', [PurchaseController::class, 'exportPDFimportPurchaseOrder'])->name('purchaselist.exportPDF');
    Route::get('purchaselist/details/{id}', [PurchaseController::class, 'details'])->name('purchaselist.details');
    Route::get('purchaselist/print/{id}', [PurchaseController::class, 'print'])->name('purchaselist.print');
    Route::get('purchaselist/orderPurchase/{id}', [PurchaseController::class, 'orderPurchase'])->name('purchaselist.orderPurchase');
    Route::get('purchaselist/getOrderPurchase/{id}', [PurchaseController::class, 'getOrderPurchase'])->name('purchaselist.getOrderPurchase');
    Route::get('purchaselist/listOrderPurchase/{id}', [PurchaseController::class, 'listOrderPurchase']);
    Route::resource('purchaselist', PurchaseController::class);
});
