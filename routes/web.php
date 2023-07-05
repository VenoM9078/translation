<?php

use App\Http\Controllers\ContractorAuthController;
use App\Mail\VerifyContractorMail;
use App\Models\Contractor;
use App\Models\VerifyContractor;
use Carbon\Carbon;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


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

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware(['auth'])->name('verification.notice');

Route::get('/email/verify-contractor', function () {
    // dd("comes");
    return view('auth.verify-email');
})->name('contractor.verification.notice');

// Route::get('/email/verify', function () {
//     dd("hi");
//     return view('auth.verify-email');
// })->middleware(['auth:contractor'])->name('cont.verification.notice');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    if ($request->user()) {
        // dd("ur a ccontractor");
    }
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'auth:contractor', 'throttle:6,1'])->name('verification.send');

Route::post('/email/contractor-verification-notification', function (Request $request) {
    $contractor = Contractor::where('id', $request->user()->id)->first();
    if (!$contractor) {
        return back()->with('error', 'Contractor not found!');
    }

    $verification = VerifyContractor::where('contractor_id', $contractor->id)->first();

    if ($verification) {
        $verification->expiry_time = Carbon::now()->addHours(2);
        $verification->save();
    } else {

        return back()->with('error', 'Verification entry not found!');
    }

    Mail::to($request->user()->email)->send(new VerifyContractorMail($contractor));
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth:contractor', 'throttle:6,1'])->name('contractor.verification.send');


Route::get('/inputForm', [GuestController::class, 'apiRequest']);
Route::post('/inputForm', [GuestController::class, 'realApiRequest'])->name('realApiRequest');

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
// Route::get('/admin/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
// Route::post('/admin/register', [AdminAuthController::class, 'store'])->name('admin.register');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

//Contracter

Route::get('/contractor/verify/{token}', [ContractorAuthController::class, 'verifyContractor'])->name('verify-contractor');


Route::get('/contractor/login', [ContractorAuthController::class, 'showLoginForm'])->name('contractor.login');
Route::get('/contractor/register', [ContractorAuthController::class, 'showRegisterForm'])->name('contractor.register');
Route::post('/contractor/register-complete', [ContractorAuthController::class, 'showRegisterForm2'])->name('contractor.register2');
Route::post('/contractor/register', [ContractorAuthController::class, 'store'])->name('contractor.register');
Route::post('/contractor/login', [ContractorAuthController::class, 'login'])->name('contractor.login');

// Route::get('/pdf')
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('generate-invoice/{id}', [AdminController::class, 'generatePDFInvoice'])->name('generatePDFInvoice');

Route::group(['middleware' => ['auth:contractor', 'contractor.verified']], function () {
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
    Route::post('/contractor/upload-translation', [ContractorAuthController::class, 'submitTranslationFile'])->name('contractor.upload-translation');

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


    Route::get('/contractor/download-translation-file-admin/{id}', [ContractorAuthController::class, 'downloadTranslationFileByAdmin'])->name('contractor.download-translated-file-by-admin');

    Route::post('/contractor/report-submission', [ContractorAuthController::class, 'reportSubmission'])->name('contractor.report-submission');

    //create two routes, get and post. for submitting proof reader translations 
    Route::get('/contractor/proof-read/{orderID}', [ContractorAuthController::class, 'proofRead'])->name('contractor.view-submit-proof-read');
    Route::post('/contractor/proof-read', [ContractorAuthController::class, 'submitProofRead'])->name('contractor.submit-proof-read');
    Route::post('/contractor/upload-proof', [ContractorAuthController::class, 'uploadProofFile'])->name('contractor.upload-proof-read-file');
    Route::get('/contractor/completed-proof-reads', [ContractorAuthController::class, 'completedProofReads'])->name('contractor.completed-proof-read');

    Route::get('/contractor/profile', [ContractorAuthController::class, 'viewProfile'])->name('contractor.edit-profile');
    Route::post('/contractor/profile/update', [ContractorAuthController::class, 'updateProfile'])->name('contractor.edit-profile-submit');
});

Route::group(['middleware' => ['auth:admin']], function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/pending', [AdminController::class, 'pendingOrders'])->name('admin.pending');
    Route::get('admin/paidOrders', [AdminController::class, 'paidOrders'])->name('admin.paidOrders');

    Route::post('admin/cancel-order', [AdminController::class, 'cancelOrder'])->name('admin-cancelOrder');
    Route::post('admin/cancel-interpretation', [AdminController::class, 'cancelInterpretation'])->name('admin-cancelInterpretation');
    Route::get('/admin-copy-interpretation/{id}', [AdminController::class, 'copyInterpretationDetails'])->name('admin-copy-interpretation-details');


    Route::get('admin/new-translation-order', [AdminController::class, 'newTranslationOrder'])->name('admin.newTranslationOrder');
    Route::post('admin/new-translation-order', [AdminController::class, 'submitNewTranslationOrder'])->name('admin.submitNewTranslationOrder');
    Route::post('adminUploadTranslationImage', [AdminController::class, 'uploadTranslationImage'])->name('uploadTranslationImage');
    Route::post('admin/quote/upload', [AdminController::class, 'uploadQuote'])->name('uploadQuote');
    Route::get('admin/quote/download/{id}', [AdminController::class, 'downloadQuoteFile'])->name('downloadQuote');

    // Route::post('admin/int-quote/upload', [AdminController::class, 'uploadInterpretationQuote'])->name('uploadInterpretationQuote');
    Route::get('admin/int-quote/download/{id}', [AdminController::class, 'downloadInterpretationQuoteFile'])->name('downloadInterpretationQuote');



    Route::get('admin/new-interpretation', [AdminController::class, 'newInterpretation'])->name('admin.newInterpretation');
    Route::post('admin/new-interpretation', [AdminController::class, 'submitNewInterpretation'])->name('admin.submitNewInterpretation');

    //view orders
    Route::get('admin/orders/{id}', [AdminController::class, 'show'])->name('admin.show-order');
    Route::delete('/institute/{id}/delete', [AdminController::class, 'deleteInstitute'])->name('institute.delete');


    Route::get('/admin/contractors/{id}/delete', [AdminController::class, 'deleteContractor'])->name('admin.deleteContractor');
    Route::get('/admin/contractors/{id}/edit', [AdminController::class, 'editContractor'])->name('admin.editContractor');
    Route::post('/admin/contractors/edit', [AdminController::class, 'updateContractor'])->name('admin.updateContractor');

    Route::delete('/admin/interpretation/{id}', [AdminController::class, 'deleteInterpretation'])->name('admin.interpretation.delete');

    Route::put('admin/users/{id}/update', [AdminController::class, 'updateUser'])->name('admin.updateUser');


    Route::post('get-contractor-rate', [AdminController::class, 'getContractorRate'])->name('get.contractor.rate');
    Route::post('get-translator-rate', [AdminController::class, 'getTranslatorRate'])->name('get.translator.rate');
    Route::post('get-proofreader-rate', [AdminController::class, 'getProofreaderRate'])->name('get.proofreader.rate');

    Route::get('/admin/interpretation/{id}/edit', [AdminController::class, 'editInterpretation'])->name('admin.interpretation.edit');
    Route::put('/admin/interpretation/{id}', [AdminController::class, 'updateInterpretation'])->name('admin.interpretation.update');


    Route::get('/admin/viewUser/{id}', [AdminController::class, 'viewUser'])->name('admin.viewUser');
    Route::get('/admin/editUser/{id}', [AdminController::class, 'editUser'])->name('admin.editUser');
    Route::delete('/admin/deleteUser/{id}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');

    Route::get('/admin/upload-file/{id}', [AdminController::class, 'showUploadFinalDoc'])->name('show-final-upload-page');
    Route::post('/admin/upload-file/submit', [AdminController::class, 'submitFinalDoc'])->name('admin.submit-final-doc');
    // Route::get('admin/interpretations', [AdminController::class, 'editInterpretations'])->name('admin.edit-interpretation');

    Route::get('admin/ongoing-interpretations', [AdminController::class, 'ongoingInterpretations'])->name('admin.ongoingInterpretations');
    Route::get('/admin/submitQuote/{id}', [AdminController::class, 'showSubmitQuote'])->name('admin.showSubmitQuote');
    Route::post('admin/submitQuote', [AdminController::class, 'submitQuote'])->name('admin.submitQuote');

    Route::get('/admin/order/quote/{id}', [AdminController::class, 'showOrderSubmitQuote'])->name('admin.showOrderSubmitQuote');
    Route::post('/admin/order/quote/submit', [AdminController::class, 'submitOrderQuote'])->name('admin.submitOrderQuote');

    Route::get('admin/view-completed-interpretations', [AdminController::class, 'viewCompletedInterpretations'])->name('admin.viewCompletedInterpretations');

    Route::get('admin/view-customers', [AdminController::class, 'viewCustomers'])->name('admin.viewCustomers');

    Route::get('admin/view-contractors', [AdminController::class, 'viewContractors'])->name('admin.viewContractors');
    // Add this route definition
    Route::get('/admin/contractor/{id}', [AdminController::class, 'viewContractor'])->name('admin.viewContractor');

    Route::get('/view-invoice/{id}', [AdminController::class, 'viewInvoice'])->name('view-invoice');

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
    Route::get('/admin/edit-order/{orderID}', [AdminController::class, 'viewEditOrder'])->name('admin.view-edit-order');
    Route::post('/admin/edit-order/save', [AdminController::class, 'editOrder'])->name('admin.edit-order-save');

    Route::get('/download-proof-read-file/{orderID}', [AdminController::class, 'downloadProofReadFile'])->name('download-proof-read-file');

    //Institute Admin
    Route::get('/institute/admin/pending', [AdminController::class, 'viewInstituteAdminPending'])->name('view-pending-institute-admin');
    Route::get('/institute/admin/{id}/accept', [AdminController::class, 'acceptInstituteAdmin'])->name('institute-admin-accept');
    Route::get('/institute/admin/{id}/decline', [AdminController::class, 'declineInstituteAdmin'])->name('institute-admin-decline');

    //Register User
    Route::get('/register-user', [AdminController::class, 'viewRegisterUser'])->name('register-user');
    Route::post('/register-user', [AdminController::class, 'registerUser'])->name('submit-register-user');

    //Register Contractor
    Route::get('/register-contractor', [AdminController::class, 'viewRegisterContractor'])->name('register-contractor');
    Route::post('/register-contractor', [AdminController::class, 'registerContractor'])->name('submit-register-contractor');

    //Assign proof-read and contractor
    Route::get('/assign/{order}', [AdminController::class, 'assignProofReadTranslator'])->name('assign-proofread-translator');
    Route::post('/assign', [AdminController::class, 'submitAssignProofReadTranslator'])->name('assign-proofread-translator-submit');

    Route::post('/admin/upload-proof', [AdminController::class, 'uploadProofFile'])->name('admin-upload-proof-read-file');

    Route::get('/view-interpretation/{id}', [AdminController::class, 'viewInterpretationDetails'])->name('view-interpretation-details');
    // Route::get('/copy-interpretation/{id}', [AdminController::class, 'copyInterpretationDetails'])->name('copy-interpretation-details');


    // Track Order
    Route::get('/order/{id}/track', [AdminController::class, 'trackOrder']);
    Route::get('/interpretation/{id}/track', [AdminController::class, 'trackInterpretation']);

    Route::post('/upload-translation', [AdminController::class, 'uploadTranslationFile'])->name('upload-translation');

    Route::get('/admin/upload-translation-file/{id}', [AdminController::class, 'showUploadTranslationFile'])->name('admin.show-submit-translation-page');

    Route::post('/admin/upload-translation-file/submit', [AdminController::class, 'submitTranslationFile'])->name('admin.submit-translation-file');

    Route::get('/admin/upload-proof/{id}', [AdminController::class, 'showProofReadPage'])->name('admin.showProofReadSubmission');
    Route::post('/admin/upload-proof', [AdminController::class, 'uploadProofFile'])->name('admin.upload-proof-read-file');
    Route::post('/admin/upload-proof/submit', [AdminController::class, 'submitProofRead'])->name('admin.submit-proof-read');
});

Route::middleware(['web', 'auth', 'verified'])->group(function () {


    // Track Order
    Route::get('/user/order/{id}/track', [AdminController::class, 'trackOrder']);
    Route::get('/user/interpretation/{id}/track', [AdminController::class, 'trackInterpretation']);

    // Order management
    Route::get('user/orders/{id}', [UserController::class, 'show'])->name('show-order');
    Route::get('user/copy-order/{id}', [UserController::class, 'copyOrderDetails'])->name('copy-order');

    Route::get('/view-interpretation/{id}', [UserController::class, 'viewInterpretationDetails'])->name('view-interpretation-details');
    Route::get('/copy-interpretation/{id}', [UserController::class, 'copyInterpretationDetails'])->name('copy-interpretation-details');
    Route::get('/user/interpretation/{id}/edit', [UserController::class, 'editInterpretation'])->name('user.interpretation.edit');
    Route::put('/user/interpretation/{id}', [UserController::class, 'updateInterpretation'])->name('admin.interpretation.update');
    Route::post('cancel-order', [UserController::class, 'cancelOrder'])->name('cancelOrder');
    Route::post('cancel-interpretation', [UserController::class, 'cancelInterpretation'])->name('cancelInterpretation');


    Route::get('/user/quote/{id}/accept', [UserController::class, 'approveQuote'])->name('user.approve-quote');
    Route::get('/user/quote/{id}/reject', [UserController::class, 'disapproveQuote'])->name('user.disapprove-quote');

    //interpretation
    Route::get('/user/int-quote/{id}/accept', [UserController::class, 'approveIntQuote'])->name('user.int-approve-quote');
    Route::get('/user/int-quote/{id}/reject', [UserController::class, 'disapproveIntQuote'])->name('user.int-disapprove-quote');


    Route::get('/edit-order/{orderID}', [UserController::class, 'viewEditOrder'])->name('view-edit-order');
    Route::post('/edit-order/save', [UserController::class, 'editOrder'])->name('admin.edit-order');

    Route::put('/user/update-profile/{id}', [UserController::class, 'updateProfile'])->name('user.updateProfile');
    Route::put('user/{id}/update-institute', [UserController::class, 'updateInstitute'])->name('user.updateInstitute');
    Route::get('/user/downloadFiles/{order}', [UserController::class, 'downloadFiles'])->name('user.downloadFiles');
    Route::get('/user/download-translation-file/{orderID}', [UserController::class, 'downloadTranslationFile'])->name('user.download-translation-file');

    Route::resource('user', UserController::class);
    Route::get('newOrder', [UserController::class, 'newOrder'])->name('newOrder');

    Route::get('myorders', [UserController::class, 'myorders'])->name('myorders');
    Route::get('myinterpretations', [UserController::class, 'myinterpretations'])->name('myinterpretations');

    Route::get('allInvoices', [UserController::class, 'allInvoices'])->name('allInvoices');

    Route::get('order-new-interpretation', [UserController::class, 'newInterpretation'])->name('newInterpretation');
    Route::post('order-new-interpretation', [UserController::class, 'storeNewInterpretation'])->name('storeNewInterpretation');
    Route::get('view-quote-invoice/{id}', [UserController::class, 'viewQuoteInvoice'])->name('viewQuoteInvoice');

    Route::get('view-profile', [UserController::class, 'viewProfile'])->name('user.profile');

    Route::get('/institute-admin', [UserController::class, 'instituteAdmin'])->name('user.institute-admin');

    Route::get('institute-admin/accept/{id}', [UserController::class, 'instituteUserRequestAccept'])->name('institute-admin.accept');
    Route::get('institute-admin/decline/{id}', [UserController::class, 'instituteUserRequestDecline'])->name('institute-admin.decline');


    Route::get('viewInvoice/{id}', [UserController::class, 'viewInvoice'])->name('viewInvoice');
    Route::get('provideProof/{id}', [UserController::class, 'provideProof'])->name('provideProof');
    Route::post('payLater', [UserController::class, 'payLater'])->name('payLater');
    Route::post('processProof', [UserController::class, 'processProof'])->name('processProof');
    Route::get('thankyou/{id}', [UserController::class, 'updatePaymentStatus'])->name('thankyou');
    Route::get('view-quote-invoice/thank-you/{id}', [UserController::class, 'updateQuotePaymentStatus'])->name('quoteThankYou');


    // Pay Any Time for Translation
    Route::post('user/proceed-to-pay-now', [UserController::class, 'proceedToPayNow'])->name('user.proceedToPayNow');
    Route::get('user/pay-anytime/{id}', [UserController::class, 'showPayAnyTimePage'])->name('user.showPayAnyTimePage');

    // Pay Any Time for Interpretation
    Route::post('user/interpretation/proceed-to-pay-now', [UserController::class, 'proceedToPayNowInterpretation'])->name('user.proceedToPayNowInterpretation');
    Route::get('user/interpretation/pay-anytime/{id}', [UserController::class, 'showPayAnyTimePageInterpretation'])->name('user.showPayAnyTimePageInterpretation');

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

    Route::get('user/quote/download/{id}', [UserController::class, 'downloadQuoteFile'])->name('user.downloadQuote');
    Route::get('admin/int-quote/download/{id}', [UserController::class, 'downloadInterpretationQuoteFile'])->name('downloadInterpretationQuote');

    //Institute

    Route::get('/institute/orders', [UserController::class, 'viewInstituteOrders'])->name('view-institute-orders');
    Route::get('/institute/interpretations', [UserController::class, 'viewInstituteInterpretations'])->name('view-institute-interpretations');
});

Route::get('logout', [UserController::class, 'destroySession'])->name('logout');


Route::post('freequote', [GuestController::class, 'freequote'])->name('freequote');



require __DIR__ . '/auth.php';
