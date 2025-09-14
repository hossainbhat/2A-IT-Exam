<?php

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\PurchaseOrderController;

Route::get('/', [IndexController::class, 'index'])->name('index');


Auth::routes(['register' => false]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {

    Route::post('check-pwd', [SettingController::class, 'chkPassword'])->name('chkPassword');
    Route::post('update-pwd', [SettingController::class, 'updatePassword'])->name('updatePassword');
    Route::match(['get', 'post'], 'profile', [SettingController::class, 'profile'])->name('profile');

    Route::resource('unit', UnitController::class)->except(['show']);
    Route::resource('brand', BrandController::class)->except(['show']);
    Route::resource('category', CategoryController::class)->except(['show']);
    Route::resource('supplier', SupplierController::class)->except(['show']);
    Route::resource('product', ProductController::class)->except(['show']);
    Route::resource('purchase', PurchaseOrderController::class)->except(['edit', 'update']);
   
});
