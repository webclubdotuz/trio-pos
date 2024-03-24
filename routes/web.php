<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


// Login
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate')->middleware('guest');


Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


    // customers
    Route::resource('customers', \App\Http\Controllers\CustomerController::class);

    // suppliers
    Route::resource('suppliers', \App\Http\Controllers\SupplierController::class);

    // warehouses
    Route::resource('warehouses', \App\Http\Controllers\WarehouseController::class);

    // brands
    Route::resource('brands', \App\Http\Controllers\BrandController::class);

    // categories
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);

    // Products
    Route::resource('products', \App\Http\Controllers\ProductController::class);

    // Purchases
    Route::resource('purchases', \App\Http\Controllers\PurchaseController::class);

    // Tasks
    Route::resource('tasks', \App\Http\Controllers\TaskController::class);

    // Sales
    Route::resource('sales', \App\Http\Controllers\SaleController::class);
    Route::get('sales/{sale}/contract', [\App\Http\Controllers\SaleController::class, 'contract'])->name('sales.contract');
    Route::post('sales/{sale}/review', [\App\Http\Controllers\SaleController::class, 'storeReview'])->name('sales.store-review');
    Route::delete('sales/{sale}/review/{review}', [\App\Http\Controllers\SaleController::class, 'destroyReview'])->name('sales.destroy-review');

    // Users
    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::get('/', [\App\Http\Controllers\UserController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\UserController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\UserController::class, 'store'])->name('store');
        Route::get('/show/{user}', [\App\Http\Controllers\UserController::class, 'show'])->name('show');
        Route::get('my-profile', [\App\Http\Controllers\UserController::class, 'myProfile'])->name('my-profile');
        Route::get('/edit/{user}', [\App\Http\Controllers\UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('destroy');
        Route::post('auth/{user}', [AuthController::class, 'adminAuth'])->name('auth.admin');
    });

    // ExpenseCategories
    Route::group(['prefix' => 'expense-categories', 'as' => 'expense-categories.'], function () {
        Route::get('/', [\App\Http\Controllers\ExpenseCategoryController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\ExpenseCategoryController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\ExpenseCategoryController::class, 'store'])->name('store');
        Route::get('/edit/{expense_category}', [\App\Http\Controllers\ExpenseCategoryController::class, 'edit'])->name('edit');
        Route::put('/edit/{expense_category}', [\App\Http\Controllers\ExpenseCategoryController::class, 'update'])->name('update');
        Route::delete('/{expense_category}', [\App\Http\Controllers\ExpenseCategoryController::class, 'destroy'])->name('destroy');
    });

    // Expenses
    Route::group(['prefix' => 'expenses', 'as' => 'expenses.'], function () {
        Route::get('/', [\App\Http\Controllers\ExpenseController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\ExpenseController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\ExpenseController::class, 'store'])->name('store');
        Route::get('/edit/{expense}', [\App\Http\Controllers\ExpenseController::class, 'edit'])->name('edit');
        Route::put('/edit/{expense}', [\App\Http\Controllers\ExpenseController::class, 'update'])->name('update');
        Route::delete('/{expense}', [\App\Http\Controllers\ExpenseController::class, 'destroy'])->name('destroy');
    });

    // Reports
    Route::group(['prefix' => 'reports', 'as' => 'reports.'], function () {
        Route::get('/sale-report-user', [\App\Http\Controllers\SaleController::class, 'report_user'])->name('sale-report-user');
        Route::get('/installment-report-debt', [\App\Http\Controllers\InstallmentController::class, 'report_debt'])->name('installment-report-debt');
        Route::get('/customer-report', [\App\Http\Controllers\CustomerController::class, 'report'])->name('customer-report');
        Route::get('/customer-find-report', [\App\Http\Controllers\CustomerController::class, 'find_report'])->name('customer-find-report');
        Route::get('/product-report-sale', [\App\Http\Controllers\ProductController::class, 'report_sales'])->name('product-report-sale');
        Route::get('/product-report-frozen', [\App\Http\Controllers\ProductController::class, 'report_sales_frozen'])->name('product-report-frozen');
        Route::get('/product-report-top-sale', [\App\Http\Controllers\ProductController::class, 'report_top_sale'])->name('product-report-top-sale');
        Route::get('/expense', [\App\Http\Controllers\ReportController::class, 'expense'])->name('expense');
    });

    // Installments
    Route::group(['prefix' => 'installments', 'as' => 'installments.'], function () {
        Route::get('/debt', [\App\Http\Controllers\InstallmentController::class, 'debt'])->name('debt');
    });

    // Settings
    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
        Route::put('update/{key}', [\App\Http\Controllers\SettingController::class, 'update'])->name('update');
    });

    // PaymentMethods
    Route::resource('payment-methods', \App\Http\Controllers\PaymentMethodController::class);
    Route::resource('finds', \App\Http\Controllers\FindController::class);
    //


});

