<?php

use Illuminate\Support\Facades\Route;
use App\Http\controllers\AdminController;
use App\Http\controllers\invoicesController;
use App\Http\controllers\sectionsController;
use App\Http\controllers\productsController;
use App\Http\controllers\invoiceDet;
use App\Http\controllers\UserController;
use App\Http\controllers\RoleController;
use App\Http\controllers\reportsController;
use App\Http\controllers\homeController;
use App\Http\Controllers\ProfilesController;

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

Route::middleware(['auth'])->group(function(){

    Route::get('/',function(){

        return view('dashboard');
    });
  
});





Route::middleware('auth')->group(function(){

    Route::get('/', [homeController::class,'index'])->name('home');

    Route::get('/profile/index',[ProfilesController::class,'index'])->name('profile.index');

    Route::get('/profile/edit',[ProfilesController::class,'edit_page'])->name('profile.edit');

    Route::post('/profile/update/{user}',[ProfilesController::class,'update'])->name('profile.update');

    Route::get('/profile/password/change',[ProfilesController::class,'password_page'])->name('profile.password.change');

    Route::post('/profile/password/change/process/{user}',[ProfilesController::class,'password_change'])->name('profile.password.change.process');





    Route::resource('/invoices',invoicesController::class);

    Route::get('paid/invoices',[invoicesController::class,'paid_invoices'])->name('paid.invoices');

    Route::get('unpaid/invoices',[invoicesController::class,'unpaid_invoices'])->name('unpaid.invoices');

    Route::get('partialypaid/invoices',[invoicesController::class,'partialypaid_invoices'])->name('partialypaid.invoices');



    Route::resource('/sections',sectionsController::class);
    
    
    Route::post('/sections/store',[sectionsController::class,'store'])->name('sections.store');  
    
    Route::post('/sections/update',[sectionsController::class,'update'])->name('sections.update');

    Route::post('/sections/delete',[sectionsController::class,'destroy'])->name('sections.delete');

    Route::resource('/products',productsController::class);

    Route::post('/products/store',[productsController::class,'store'])->name('products.store');  

    Route::post('/products/update',[productsController::class,'update'])->name('products.update');  

    Route::post('/products/delete',[productsController::class,'destroy'])->name('products.delete');

    Route::get('/invoice/add',[invoiceDet::class,'add']);


       Route::get('/invoices/det/{id}',[invoiceDet::class,'edit'])->name('invoices.det');

       Route::get('viewfile/{file}/{invoice_number}',[invoiceDet::class,'viewfile']);
       Route::get('downloadfile/{file}/{invoice_number}',[invoiceDet::class,'downloadfile']);

       Route::post('/uploadFiles',[invoiceDet::class,'upload'])->name('uploadFiles');

       Route::get('/invoice/edit{id}',[invoiceDet::class,'editinvoice'])->name('invoice.edit');
       Route::post('/invoice/update{id}',[invoiceDet::class,'updateinvoice'])->name('invoice.update');

       Route::post('/invoice/delete',[invoiceDet::class,'deleteinvoice'])->name('invoice.delete');
       Route::get('/status/update{id}',[invoiceDet::class,'statusupdate'])->name('status.update');
       Route::post('/change/status{id}',[invoiceDet::class,'changestatus'])->name('change.status');

       Route::post('/invoice/archive',[invoiceDet::class,'invoicearchive'])->name('invoice.archive');

       Route::get('/archivedinvoices',[invoiceDet::class,'archived'])->name('archivedinvoices');

       Route::post('/unarchive',[invoiceDet::class,'unarchive'])->name('unarchive');

       Route::post('/deleteinvoices',[invoiceDet::class,'delinvoices'])->name('deleteinvoices');

       Route::get('/invoice/print{id}',[invoiceDet::class,'printinvoice'])->name('invoice.print');

       Route::get('users/export/', [invoicesController::class,'export']);


    Route::get('/invoices/getbyajax/{section_id}',[invoiceDet::class,'getprobyajax']);

    Route::post('/invoice/insert',[invoicesController::class,'store'])->name('invoice.insert');




});

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles',RoleController::class);
    Route::resource('users',UserController::class);

    Route::get('roles/showpermission/{id}',[RoleController::class,'show'])->name('roles.showpermission');

    Route::post('/users/del/',[UserController::class,'del'])->name('users.del');

    Route::get('/invoicesreports',[reportsController::class,'index'])->name('invoicesreports');

    Route::post('/searchInvoices',[reportsController::class,'search'])->name('searchInvoices');

    Route::get('/customersreports',[reportsController::class,'index2'])->name('customersreports');

    Route::post('/customersSearch',[reportsController::class,'search2'])->name('customersSearch');




    

    
    });















//Route::get('/{page}',[AdminController::class,'index']);

