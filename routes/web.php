<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TranslatorController;
use App\Http\Controllers\UserController;
use App\Mail\OrderCreated;
use App\Models\Invoice;
use Illuminate\Support\Facades\Mail;


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
    return view('welcome');
});

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::get('/admin/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
Route::post('/admin/register', [AdminAuthController::class, 'store'])->name('admin.register');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => ['auth:admin']], function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/pending', [AdminController::class, 'pendingOrders'])->name('admin.pending');
    Route::get('admin/paidOrders', [AdminController::class, 'paidOrders'])->name('admin.paidOrders');

    Route::delete('destroy/{id}', [AdminController::class, 'destroy'])->name('destroy');
    Route::get('downloadFiles/{order}', [AdminController::class, 'downloadFiles'])->name('downloadFiles');
    Route::resource('invoice', InvoiceController::class);
    Route::get('customInvoice/{id}', [InvoiceController::class, 'customInvoice'])->name('invoice.customInvoice');
    Route::get('mailToTranslator/{id}', [AdminController::class, 'mailToTranslator'])->name('mailToTranslator');
    Route::post('sendDocumentsToTranslator', [AdminController::class, 'sendDocumentsToTranslator'])->name('sendDocumentsToTranslator');
    Route::get('showTranslationRequests', [AdminController::class, 'showTranslationRequests'])->name('showTranslationRequests');
    Route::get('changeTranslationRequestStatus/{id}', [AdminController::class, 'changeTranslationRequestStatus'])->name('changeTranslationRequestStatus');
    Route::get('mailToProofReader/{id}', [AdminController::class, 'mailToProofReader'])->name('mailToProofReader');
    Route::post('sendDocumentsToProofReader', [AdminController::class, 'sendDocumentsToProofReader'])->name('sendDocumentsToProofReader');
    Route::get('showProofReadRequests', [AdminController::class, 'showProofReadRequests'])->name('showProofReadRequests');
    Route::get('completedOrders', [AdminController::class, 'viewCompletedOrders'])->name('completedOrders');
    Route::get('changeProofReadRequestStatus/{id}', [AdminController::class, 'changeProofReadRequestStatus'])->name('changeProofReadRequestStatus');

});

Route::middleware(['web', 'auth'])->group(function () {
    Route::resource('user', UserController::class);
    Route::get('myorders', [UserController::class, 'myorders'])->name('myorders');
    Route::get('logout', [UserController::class, 'destroySession'])->name('logout');
    Route::get('viewInvoice/{id}', [UserController::class, 'viewInvoice'])->name('viewInvoice');
    Route::get('thankyou/{id}', [UserController::class, 'updatePaymentStatus'])->name('thankyou');
});


require __DIR__ . '/auth.php';
