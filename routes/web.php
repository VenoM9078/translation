<?php

use App\Http\Controllers\ContractorAuthController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TranslatorController;
use App\Http\Controllers\UserController;
use App\Mail\OrderCreated;
use App\Models\ContactAdmin;
use App\Models\Invoice;
use Illuminate\Http\Request;
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
    return view('index');
})->name('/');

Route::get('contact', function () {
    return view('contact');
})->name('contact');

Route::post('sendContactForm', function (Request $request) {
    $validated = $request->validate([
        'name' => 'string|max:255',
        'email' => 'email|max:255',
        'message' => 'string|max:255'
    ]);

    ContactAdmin::create($validated);

    return redirect()->route('/');
})->name('sendContactForm');

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::get('/admin/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
Route::post('/admin/register', [AdminAuthController::class, 'store'])->name('admin.register');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

//Contracter

Route::get('/contractor/login', [ContractorAuthController::class, 'showLoginForm'])->name('contractor.login');
Route::get('/contractor/register', [ContractorAuthController::class, 'showRegisterForm'])->name('contractor.register');
Route::post('/contractor/register', [ContractorAuthController::class, 'store'])->name('contractor.register');
Route::post('/contractor/login', [ContractorAuthController::class, 'login'])->name('contractor.login');

// Route::get('/pdf')
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('generate-invoice/{id}', [AdminController::class, 'generatePDFInvoice'])->name('generatePDFInvoice');

Route::group(['middleware' => ['auth:contractor']], function () {
    Route::get('contractor/dashboard', [ContractorAuthController::class, 'index'])->name('contractor.dashboard');
    Route::get('/contractor/logout', [ContractorAuthController::class, 'logout'])->name('contractor.logout');
    //pending translations
    Route::get('contractor/translations/pending', [ContractorAuthController::class, 'pendingTranslations'])->name('contractor.translations.pending');
    //completed translations
    Route::get('contractor/translations/completed', [ContractorAuthController::class, 'completedTranslations'])->name('contractor.translations.completed');

    Route::get('contractor/proof-reads', [ContractorAuthController::class, 'pendingProofRead'])->name('contractor.proof-read');
    Route::get('contractor/interpretaions', [ContractorAuthController::class, 'pendingInterpretations'])->name('contractor.interpretations');

    Route::get('/contractor/accept/{order}', [ContractorAuthController::class, 'acceptTranslation'])->name('contractor.accept');
    Route::get('/contractor/decline/{order}', [ContractorAuthController::class, 'declineTranslation'])->name('contractor.decline');
    //Download order
    Route::get('/contractor/downloadFiles/{order}', [ContractorAuthController::class, 'downloadFiles'])->name('contractor.downloadFiles');
});

Route::group(['middleware' => ['auth:admin']], function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/pending', [AdminController::class, 'pendingOrders'])->name('admin.pending');
    Route::get('admin/paidOrders', [AdminController::class, 'paidOrders'])->name('admin.paidOrders');


    Route::get('admin/ongoing-interpretations', [AdminController::class, 'ongoingInterpretations'])->name('admin.ongoingInterpretations');


    Route::delete('destroy/{id}', [AdminController::class, 'destroy'])->name('destroy');
    Route::get('downloadFiles/{order}', [AdminController::class, 'downloadFiles'])->name('downloadFiles');
    Route::get('downloadEvidence/{order}', [AdminController::class, 'downloadEvidence'])->name('downloadEvidence');
    Route::get('approveEvidence/{order}', [AdminController::class, 'approveEvidence'])->name('approveEvidence');
    Route::get('rejectEvidence/{order}', [AdminController::class, 'rejectEvidence'])->name('rejectEvidence');
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
    Route::get('mailOfCompletion/{id}', [AdminController::class, 'mailOfCompletion'])->name('mailOfCompletion');
    Route::post('sendDocumentsToUser', [AdminController::class, 'sendDocumentsToUser'])->name('sendDocumentsToUser');
    Route::get('downloadTranslatedFiles/{id}', [AdminController::class, 'downloadTranslatedFiles'])->name('downloadTranslatedFiles');
    Route::get('viewQuoteRequests', [AdminController::class, 'viewQuoteRequests'])->name('viewQuoteRequests');
    Route::post('manageLatePay', [AdminController::class, 'manageLatePay'])->name('manageLatePay');
    Route::get('viewFeedback', [AdminController::class, 'viewFeedback'])->name('viewFeedback');
    Route::get('viewMessages', [AdminController::class, 'viewMessages'])->name('viewMessages');
    Route::post('deleteAllQuotes', [AdminController::class, 'deleteAllQuotes'])->name('deleteAllQuotes');
    Route::post('deleteAllContacts', [AdminController::class, 'deleteAllContacts'])->name('deleteAllContacts');
    Route::post('adminUpload', [AdminController::class, 'uploadImage'])->name('adminUpload');

    Route::get('/assign-contractor/{orderID}', [AdminController::class, 'viewAssignContractor'])->name('view-assign-contractor');
    Route::post('/assign-contractor', [AdminController::class, 'assignContractor'])->name('assign-contractor');
});

Route::middleware(['web', 'auth'])->group(function () {
    Route::resource('user', UserController::class);
    Route::get('myorders', [UserController::class, 'myorders'])->name('myorders');
    Route::get('allInvoices', [UserController::class, 'allInvoices'])->name('allInvoices');

    Route::get('order-new-interpretation', [UserController::class, 'newInterpretation'])->name('newInterpretation');
    Route::post('order-new-interpretation', [UserController::class, 'storeNewInterpretation'])->name('storeNewInterpretation');


    Route::get('logout', [UserController::class, 'destroySession'])->name('logout');
    Route::get('viewInvoice/{id}', [UserController::class, 'viewInvoice'])->name('viewInvoice');
    Route::get('provideProof/{id}', [UserController::class, 'provideProof'])->name('provideProof');
    Route::post('payLater', [UserController::class, 'payLater'])->name('payLater');
    Route::post('processProof', [UserController::class, 'processProof'])->name('processProof');
    Route::get('thankyou/{id}', [UserController::class, 'updatePaymentStatus'])->name('thankyou');
    Route::get('viewPayment/{id}', [UserController::class, 'viewPayment'])->name('viewPayment');
    Route::get(
        'payLaterLanding',
        function () {
            return view('user.payLaterLanding');
        }
    )->name('payLaterLanding');

    Route::post('upload', [UserController::class, 'uploadImage'])->name('upload');

    Route::post('uploadProof', [UserController::class, 'uploadProof'])->name('uploadProof');

    Route::delete('deleteUpload', [UserController::class, 'deleteUpload'])->name('deleteUpload');

    Route::get('downloadTranslatedForUser/{id}', [UserController::class, 'downloadTranslatedForUser'])->name('downloadTranslatedForUser');
    Route::post('submitFeedback', [UserController::class, 'submitFeedback'])->name('submitFeedback');
});


Route::post('freequote', [GuestController::class, 'freequote'])->name('freequote');



require __DIR__ . '/auth.php';
