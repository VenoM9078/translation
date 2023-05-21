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
    Route::get('contractor/report/{id}', [ContractorAuthController::class, 'reportToAdmin'])->name('reportToAdmin');
    Route::get('contractor/view-report/{id}', [ContractorAuthController::class, 'viewReport'])->name('contractor.viewReport');
    Route::delete('/interpretation/{id}', [ContractorAuthController::class, 'deleteInterpretation'])->name('interpretation.delete');


    Route::get('contractor/dashboard', [ContractorAuthController::class, 'index'])->name('contractor.dashboard');
    Route::get('/contractor/logout', [ContractorAuthController::class, 'logout'])->name('contractor.logout');
    //pending translations
    Route::get('contractor/translations/pending', [ContractorAuthController::class, 'pendingTranslations'])->name('contractor.translations.pending');
    //completed translations
    Route::get('contractor/translations/completed', [ContractorAuthController::class, 'completedTranslations'])->name('contractor.translations.completed');

    Route::get('contractor/proof-reads', [ContractorAuthController::class, 'onGoingProofRead'])->name('contractor.proof-read');
    Route::get('contractor/proof-reads/pending', [ContractorAuthController::class, 'pendingProofRead'])->name('contractor.proof-read-pending');
    Route::get('contractor/proof-reads/{id}', [ContractorAuthController::class, 'viewProofReadSubmission'])->name('contractor.view-proof-read-submission');
    Route::get('contractor/interpretaions', [ContractorAuthController::class, 'pendingInterpretations'])->name('contractor.interpretations');
    Route::get('contractor/interpretaions/requests', [ContractorAuthController::class, 'interpretationRequests'])->name('contractor.interpretationRequests');

    Route::get('/contractor/accept/{order}', [ContractorAuthController::class, 'acceptTranslation'])->name('contractor.accept');
    Route::get('/contractor/decline/{order}', [ContractorAuthController::class, 'declineTranslation'])->name('contractor.decline');
    //Download order
    Route::get('/contractor/downloadFiles/{order}', [ContractorAuthController::class, 'downloadFiles'])->name('contractor.downloadFiles');

    //Submit for approval
    Route::post('/upload-translation', [ContractorAuthController::class, 'submitTranslationFile'])->name('contractor.upload-translation');

    Route::get('/accept-request/{id}', [ContractorAuthController::class, 'acceptInterpretationRequest'])->name('accept.request');
    Route::get('/deny-request/{id}', [ContractorAuthController::class, 'denyInterpretationRequest'])->name('deny.request');

    //accept/reject proof read
    Route::get('/accept-proofread-request/{id}', [ContractorAuthController::class, 'acceptProofReadRequest'])->name('proof-read-accept.request');
    Route::get('/deny-proofread-request/{id}', [ContractorAuthController::class, 'denyProofReadRequest'])->name('proof-read-deny.request');

    //Filepond Upload 
    Route::post('/contractor/translationUpload', [ContractorAuthController::class, 'uploadTranslationFile'])->name('contractor.translationUploadFilePond');

    Route::get('/contractor/submit-translations/{contractorOrderID}', [ContractorAuthController::class, 'viewTranslationSubmissionPage'])->name('contractor.view-submit-translation');
    //Download translated data
    Route::get('/contractor/download-translation-file/{orderID}', [ContractorAuthController::class, 'downloadTranslationFile'])->name('contractor.download-translation-file');
    //create route for downloading proofread file

    Route::post('/contractor/report-submission', [ContractorAuthController::class, 'reportSubmission'])->name('contractor.report-submission');

    //create two routes, get and post. for submitting proof reader translations 
    Route::get('/contractor/proof-read/{orderID}', [ContractorAuthController::class, 'proofRead'])->name('contractor.view-submit-proof-read');
    Route::post('/contractor/proof-read', [ContractorAuthController::class, 'submitProofRead'])->name('contractor.submit-proof-read');
    Route::post('/contractor/upload-proof', [ContractorAuthController::class, 'uploadProofFile'])->name('contractor.upload-proof-read-file');
    Route::get('/contractor/completed-proof-reads', [ContractorAuthController::class, 'completedProofReads'])->name('contractor.completed-proof-read');
});

Route::group(['middleware' => ['auth:admin']], function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/pending', [AdminController::class, 'pendingOrders'])->name('admin.pending');
    Route::get('admin/paidOrders', [AdminController::class, 'paidOrders'])->name('admin.paidOrders');

    Route::get('/admin/contractors/{id}/delete', [AdminController::class, 'deleteContractor'])->name('admin.deleteContractor');
    Route::get('/admin/contractors/{id}/edit', [AdminController::class, 'editContractor'])->name('admin.editContractor');
    Route::post('/admin/contractors/edit', [AdminController::class, 'updateContractor'])->name('admin.updateContractor');

    Route::delete('/admin/interpretation/{id}', [AdminController::class, 'deleteInterpretation'])->name('admin.interpretation.delete');


    Route::post('get-contractor-rate', [AdminController::class, 'getContractorRate'])->name('get.contractor.rate');
    Route::post('get-translator-rate', [AdminController::class, 'getTranslatorRate'])->name('get.translator.rate');

    Route::get('/admin/interpretation/{id}/edit', [AdminController::class, 'editInterpretation'])->name('admin.interpretation.edit');
    Route::put('/admin/interpretation/{id}', [AdminController::class, 'updateInterpretation'])->name('admin.interpretation.update');


    // Route::get('admin/interpretations', [AdminController::class, 'editInterpretations'])->name('admin.edit-interpretation');

    Route::get('admin/ongoing-interpretations', [AdminController::class, 'ongoingInterpretations'])->name('admin.ongoingInterpretations');
    Route::get('/admin/submitQuote/{id}', [AdminController::class, 'showSubmitQuote'])->name('admin.showSubmitQuote');
    Route::post('admin/submitQuote', [AdminController::class, 'submitQuote'])->name('admin.submitQuote');
    Route::get('admin/view-completed-interpretations', [AdminController::class, 'viewCompletedInterpretations'])->name('admin.viewCompletedInterpretations');

    Route::get('admin/view-contractors', [AdminController::class, 'viewContractors'])->name('admin.viewContractors');
    // Add this route definition
    Route::get('/admin/contractor/{id}', [AdminController::class, 'viewContractor'])->name('admin.viewContractor');


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

    Route::get('/download-translation-file/{orderID}', [AdminController::class, 'downloadTranslationFile'])->name('download-translation-file');

    //PRoof reader assignment
    Route::get('/view-assign-proofreader/{orderId}', [AdminController::class, 'viewAssignProofReader'])->name('view-assign-proofreader');
    Route::post('/assign-proofreader', [AdminController::class, 'assignProofReader'])->name('assign-proofreader');
    Route::get('/assign-interpreter/{interpreterID}', [AdminController::class, 'viewAssignInterpreter'])->name('view-assign-interpreter');
    Route::post('/assign-interpreter', [AdminController::class, 'assignInterpreter'])->name('assign-interpreter');
    // Route::post('/re-assign-interpreter', [AdminController::class, 'reAssignInterpreter'])->name('re-assign-interpreter');
    Route::get('/re-assign-interpreter/{interpreterID}', [AdminController::class, 'viewReAssignInterpreter'])->name('view-re-assign-interpreter');
    Route::get('/edit-order/{orderID}', [AdminController::class, 'viewEditOrder'])->name('view-edit-order');
    Route::post('/edit-order/save', [AdminController::class, 'editOrder'])->name('admin.edit-order');

    Route::get('/download-proof-read-file/{orderID}', [AdminController::class, 'downloadProofReadFile'])->name('download-proof-read-file');
});

Route::middleware(['web', 'auth'])->group(function () {
    Route::resource('user', UserController::class);
    Route::get('myorders', [UserController::class, 'myorders'])->name('myorders');
    Route::get('allInvoices', [UserController::class, 'allInvoices'])->name('allInvoices');

    Route::get('order-new-interpretation', [UserController::class, 'newInterpretation'])->name('newInterpretation');
    Route::post('order-new-interpretation', [UserController::class, 'storeNewInterpretation'])->name('storeNewInterpretation');
    Route::get('view-quote-invoice/{id}', [UserController::class, 'viewQuoteInvoice'])->name('viewQuoteInvoice');


    Route::get('logout', [UserController::class, 'destroySession'])->name('logout');
    Route::get('viewInvoice/{id}', [UserController::class, 'viewInvoice'])->name('viewInvoice');
    Route::get('provideProof/{id}', [UserController::class, 'provideProof'])->name('provideProof');
    Route::post('payLater', [UserController::class, 'payLater'])->name('payLater');
    Route::post('processProof', [UserController::class, 'processProof'])->name('processProof');
    Route::get('thankyou/{id}', [UserController::class, 'updatePaymentStatus'])->name('thankyou');
    Route::get('view-quote-invoice/thank-you/{id}', [UserController::class, 'updateQuotePaymentStatus'])->name('quoteThankYou');

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
