<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\InvoiceAchiveController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvoicesReportController;
use App\Http\Controllers\costomer_reportsController;

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
})->name('handle');
Auth::routes();
//Auth::routes(['register'=> false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('/invoices', InvoicesController::class);
Route::resource('/sections', SectionsController::class);
Route::resource('/products', ProductsController::class);

Route::get('/section/{id}', [InvoicesController::class,'getproduct']);
Route::get('/invoices_details/{id}', [InvoicesDetailsController::class,'edit']);

Route::get('View_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class,'open_file']);
Route::get('download/{invoice_number}/{file_name}', [InvoicesDetailsController::class,'get_file']);
Route::post('delete_file', [InvoicesDetailsController::class,'destroy'])->name('delete_file');
Route::resource('/InvoiceAttachments', InvoicesAttachmentsController::class);
Route::get('/Status_show/{id}', [InvoicesController::class,'show'])->name('Status_show');
Route::post('/Status_Update/{id}', [InvoicesController::class,'Status_Update'])->name('Status_Update');

Route::get('/edit_invoice/{id}', [InvoicesController::class,'edit']);

Route::get('/Invoices_paid',[InvoicesController::class,'Invoices_paid']);
Route::get('/Invoices_partpaid',[InvoicesController::class,'Invoices_partpaid']);
Route::get('/Invoices_unpaid',[InvoicesController::class,'Invoices_unpaid']);
Route::get('/Print_invoice/{id}',[InvoicesController::class,'Print_invoice']);
Route::resource('Archive', InvoiceAchiveController::class);

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

});

Route::get('/invoices_report' , [InvoicesReportController::class,'index']);
Route::post('/Search_invoices' , [InvoicesReportController::class,'Search_invoices']);
Route::get('/customers_report' , [costomer_reportsController::class,'index']);
Route::post('/Search_customers' , [costomer_reportsController::class,'Search_customers'])->name('Search_customers');
Route::get('/MarkAsRead_all',[invoicesController::class,'MarkAsRead_all'])->name('MarkAsRead_all');



Route::get('/{page}',[AdminController::class ,'index']);
