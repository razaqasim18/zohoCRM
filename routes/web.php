<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/welcome', function () {

// $file_path = storage_path('app/insert_state.txt');

// foreach (file($file_path) as $line) {
//     DB::insert($line);
// }

// $query = DB::statement("Select * from countries");
// dd($query);
// });
Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes(['verify' => true]);

Route::post('/register/second', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationSecondForm'])->name('register.second');
Route::any('/register/final', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.final');

Route::middleware(['auth:web', 'verified', 'isblocked'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    Route::prefix('/item')->name('item.')->group(function () {
        Route::get('/', [App\Http\Controllers\ItemController::class, 'index'])->name('list');
        Route::get('/add', [App\Http\Controllers\ItemController::class, 'add'])->name('add');
        Route::post('/insert', [App\Http\Controllers\ItemController::class, 'insert'])->name('insert');
        Route::delete('/delete/{id}', [App\Http\Controllers\ItemController::class, 'delete'])->name('delete');
        Route::get('/edit/{id}', [App\Http\Controllers\ItemController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [App\Http\Controllers\ItemController::class, 'update'])->name('update');
    });

    Route::prefix('/sale/person')->name('sale.person.')->group(function () {
        Route::get('/', [App\Http\Controllers\SalePersonController::class, 'index'])->name('list');
        Route::get('/add', [App\Http\Controllers\SalePersonController::class, 'add'])->name('add');
        Route::post('/insert', [App\Http\Controllers\SalePersonController::class, 'insert'])->name('insert');
        Route::delete('/delete/{id}', [App\Http\Controllers\SalePersonController::class, 'delete'])->name('delete');
        Route::get('/edit/{id}', [App\Http\Controllers\SalePersonController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [App\Http\Controllers\SalePersonController::class, 'update'])->name('update');
    });

    Route::prefix('/customer')->name('customer.')->group(function () {
        Route::get('/', [App\Http\Controllers\CustomerController::class, 'index'])->name('list');
        Route::get('/add', [App\Http\Controllers\CustomerController::class, 'add'])->name('add');
        Route::post('/insert', [App\Http\Controllers\CustomerController::class, 'insert'])->name('insert');
        Route::delete('/delete/{id}', [App\Http\Controllers\CustomerController::class, 'delete'])->name('delete');
        Route::delete('/contact/delete/{id}', [App\Http\Controllers\CustomerController::class, 'contactDelete'])->name('contact.delete');
        Route::get('/edit/{id}', [App\Http\Controllers\CustomerController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [App\Http\Controllers\CustomerController::class, 'update'])->name('update');

    });

    // quote
    Route::prefix('/quote')->name('quote.')->group(function () {
        Route::get('/', [App\Http\Controllers\QuoteController::class, 'index'])->name('list');
        Route::get('/add', [App\Http\Controllers\QuoteController::class, 'add'])->name('add');
        Route::post('/insert', [App\Http\Controllers\QuoteController::class, 'insert'])->name('insert');
        Route::get('/item/detail/{id}', [App\Http\Controllers\QuoteController::class, 'getItemDetail'])->name('item.detail');
        Route::delete('/delete/{id}', [App\Http\Controllers\QuoteController::class, 'delete'])->name('delete');
        Route::delete('/item/delete/{id}', [App\Http\Controllers\QuoteController::class, 'itemDelete'])->name('item.delete');
        Route::get('/edit/{id}', [App\Http\Controllers\QuoteController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [App\Http\Controllers\QuoteController::class, 'update'])->name('update');
        Route::get('/clone/{id}', [App\Http\Controllers\QuoteController::class, 'cloned'])->name('clone');

        // ajax
        Route::post('/customer/insert/ajax', [App\Http\Controllers\QuoteController::class, 'insertCustomer'])->name('customer.ajax.insert');
        Route::post('/saleperson/insert/ajax', [App\Http\Controllers\QuoteController::class, 'insertSaleperson'])->name('saleperson.ajax.insert');
        Route::post('/item/insert/ajax', [App\Http\Controllers\QuoteController::class, 'insertItem'])->name('item.ajax.insert');
        Route::post('/tax/insert/ajax', [App\Http\Controllers\QuoteController::class, 'insertTax'])->name('tax.ajax.insert');
    });

    // tax
    Route::prefix('/tax')->name('tax.')->group(function () {
        Route::get('/', [App\Http\Controllers\SettingController::class, 'listTax'])->name('list');
        Route::get('/add', [App\Http\Controllers\SettingController::class, 'addTax'])->name('add');
        Route::post('/insert', [App\Http\Controllers\SettingController::class, 'insertTax'])->name('insert');
        Route::get('/edit/{id}', [App\Http\Controllers\SettingController::class, 'editTax'])->name('edit');
        Route::put('/update/{id}', [App\Http\Controllers\SettingController::class, 'updateTax'])->name('update');
        Route::delete('/delete/{id}', [App\Http\Controllers\SettingController::class, 'deleteTax'])->name('delete');
    });

    // vendors
    Route::prefix('/vendors')->name('vendor.')->group(function () {
        Route::get('/', function () {
            return view('user.vendor.list');
        })->name('list');
        Route::get('/add', function () {
            return view('user.vendor.add');
        })->name('add');
    });

    // expenses
    Route::prefix('/expense')->name('expense.')->group(function () {
        Route::get('/', function () {
            return view('user.expense.list');
        })->name('list');
        Route::get('/add', function () {
            return view('user.expense.add');
        })->name('add');
    });

    // invoice
    Route::prefix('/invoice')->name('invoice.')->group(function () {
        Route::get('/', function () {
            return view('user.invoice.list');
        })->name('list');
        Route::get('/add', function () {
            return view('user.invoice.add');
        })->name('add');
        // Route::get('/add', [App\Http\Controllers\InvoiceController::class, 'add'])->name('add');
        Route::post('/insert', [App\Http\Controllers\InvoiceController::class, 'insert'])->name('insert');
        Route::get('/item/detail/{id}', [App\Http\Controllers\InvoiceController::class, 'getItemDetail'])->name('item.detail');
        Route::delete('/delete/{id}', [App\Http\Controllers\InvoiceController::class, 'delete'])->name('delete');
        Route::delete('/item/delete/{id}', [App\Http\Controllers\InvoiceController::class, 'itemDelete'])->name('item.delete');
        Route::get('/edit/{id}', [App\Http\Controllers\InvoiceController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [App\Http\Controllers\InvoiceController::class, 'update'])->name('update');
        Route::get('/clone/{id}', [App\Http\Controllers\InvoiceController::class, 'cloned'])->name('clone');

        // ajax
        Route::post('/customer/insert/ajax', [App\Http\Controllers\InvoiceController::class, 'insertCustomer'])->name('customer.ajax.insert');
        Route::post('/saleperson/insert/ajax', [App\Http\Controllers\InvoiceController::class, 'insertSaleperson'])->name('saleperson.ajax.insert');
        Route::post('/item/insert/ajax', [App\Http\Controllers\InvoiceController::class, 'insertItem'])->name('item.ajax.insert');
    });

    // new
    Route::get('/creditnotes/add', function () {
        return view('user.creditnotes.add');
    })->name('creditnotes.add');
    Route::get('/creditnotes/edit', function () {
        return view('user.creditnotes.add');
    })->name('creditnotes.edit');
    Route::get('/paymentReceived/add', function () {
        return view('user.paymentReceived.add');
    })->name('paymentReceived.add');
    Route::get('/paymentReceived/edit', function () {
        return view('user.paymentReceived.add');
    })->name('paymentReceived.edit');

    Route::middleware(['isbusinessadmin'])->group(function () {
        //clients
        Route::prefix('/client')->name('client.')->group(function () {
            Route::get('/add', [App\Http\Controllers\ClientController::class, 'add'])->name('add');
            Route::post('/insert', [App\Http\Controllers\ClientController::class, 'insert'])->name('insert');
            Route::get('/edit/{id}', [App\Http\Controllers\ClientController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [App\Http\Controllers\ClientController::class, 'update'])->name('update');
            Route::get('/list', [App\Http\Controllers\ClientController::class, 'list'])->name('list');
            Route::delete('/delete/{id}', [App\Http\Controllers\ClientController::class, 'delete'])->name('delete');

        });
    });
});

// admin

Route::get('/admin/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'showAdminLoginForm'])->name('admin.login.view');
Route::post('/admin/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'adminLogin'])->name('admin.login.submit');
Route::post('/admin/logout', [App\Http\Controllers\Auth\AdminLoginController::class, 'adminLogout'])->name('admin.logout');

Route::prefix('/admin')->name('admin.')->middleware(['auth.admin', 'isblocked'])->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('dashboard');
    // business
    Route::prefix('/business')->name('business.')->group(function () {
        Route::get('/admin/list', [App\Http\Controllers\Admin\BusinessController::class, 'index'])->name('admin.list');
        Route::post('/admin/change/status', [App\Http\Controllers\Admin\BusinessController::class, 'changeStatus'])->name('admin.status');
    });
});

// Route::middleware('guest:admin')->prefix('/admin')->name('admin.')->group(function () {
// Route::get('/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'showAdminLoginForm'])->name('login.view');
// Route::post('/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'adminLogin'])->name('login');
// Route::post('/logout', [App\Http\Controllers\Auth\AdminLoginController::class, 'adminLogout'])->name('logout')->withoutMiddleware(['guest:admin']);
// });
