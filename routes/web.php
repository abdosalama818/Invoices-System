<?php

use App\Http\Controllers\invoices\ArcheiveInvoicesController;
use App\Http\Controllers\Invoices\InvoicesDetailsController;
use App\Http\Controllers\Invoices\ReportInvoicesController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\Products\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

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
    return view('auth.login');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::resource('invoices',InvoicesController::class);
Route::resource('ArcheivesInvoices',ArcheiveInvoicesController::class);
Route::delete('restoreInvoice',[ArcheiveInvoicesController::class,'restoreInvoice'])->name('restoreInvoice');

Route::resource('sections',SectionController::class);
Route::resource('products',ProductController::class);
Route::delete('archieve/{id}',[InvoicesController::class,'archieve'])->name('archieve');
Route::get('Status_show/{id}',[InvoicesController::class,'edit_status'])->name('update_status');
Route::post('Status_show/{id}',[InvoicesController::class,'update_status'])->name('Status_Update');


Route::get('invoicespaid',[InvoicesController::class,'invoicespaid'])->name('invoicespaid');
Route::get('uninvoicespaid',[InvoicesController::class,'uninvoicespaid'])->name('uninvoicespaid');
Route::get('partilainvoices',[InvoicesController::class,'partilainvoices'])->name('partilainvoices');
Route::get('Print_invoice/{id}',[InvoicesController::class,'Print_invoice'])->name('Print_invoice');


//report
Route::get('invoices_report',[ReportInvoicesController::class,'index']);
Route::post('Search_invoices',[ReportInvoicesController::class,'Search_invoices']);

Route::get('customers_report',[ReportInvoicesController::class,'customers_report']);
Route::post('Search_customers',[ReportInvoicesController::class,'Search_customers']);

//end report

Route::get('section/{id}',[SectionController::class,'getPorducts']);
Route::get('InvoicesDetails/{id}',[InvoicesDetailsController::class,'getData']);

Route::get('View_file/{invoice_number}',[InvoicesDetailsController::class,'viewFile']);
Route::get('download/{invoice_number}',[InvoicesDetailsController::class,'downloadFile']);
Route::post('delete_file',[InvoicesDetailsController::class,'deletefile'])->name('delete_file');
Route::post('InvoiceAttachments',[InvoicesDetailsController::class,'update_attachment'])->name('InvoiceAttachments');
Route::get('Status/show',[SectionController::class,'getPorducts'])->name('Status_show');

//for packege permission spetia

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
});









































Route::get('/{page}', [AdminController::class,'index']);
