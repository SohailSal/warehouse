<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AccountGroupController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\DocumentTypeController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\YearController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\DashboardController;
use Database\Seeders\GroupSeeder;
use App\Http\Controllers\UnitTypeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\QuantityController;
use App\Http\Controllers\ImporterController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\FileController;



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

//PDF -------------------- STARTS ---------------------------
// Route::get('/user/invoice/{invoice}', function (Request $request, $invoiceId) {
//     return $request->user()->downloadInvoice($invoiceId, [
//         'vendor' => 'Your Company',
//         'product' => 'Your Product',
//     ], 'practice');
// });



Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('reports', [ReportController::class, 'index'])
    ->name('reports')
    ->middleware('auth');

Route::get('ledgers', [LedgerController::class, 'index'])
    ->name('ledgers')
    ->middleware('auth');

Route::get('ledgers/getledger/{id}', [LedgerController::class, 'getledger'])
    // ->name('getledger.onscreen');
    ->name('getledger');

//PDF -----------------------------------------------
Route::get('pd', [ReportController::class, 'pd'])
    ->name('pd')
    ->middleware('auth');

//Trial Balance -------------------- ENDS ---------------------------
Route::get('trialbalance', [ReportController::class, 'trialbalance'])
    ->name('trialbalance')
    ->middleware('auth');

//Balance Sheet -------------------- Starts ---------------------------
Route::get('bs', [ReportController::class, 'bs'])
    ->name('bs')
    ->middleware('auth');

Route::get('pl', [ReportController::class, 'pl'])
    ->name('pl')
    ->middleware('auth');


Route::get('range', [ReportController::class, 'rangeLedger'])
    ->name('range')
    ->middleware('auth');


//TO CHANGE COMPANY THE FROM DROPDOWN
Route::get('companies/coch/{id}', [CompanyController::class, 'coch'])
    ->name('companies.coch');

//TO CHANGE YEAR THE FROM DROPDOWN
Route::get('years/yrch/{id}', [YearController::class, 'yrch'])
    ->name('years.yrch');


Route::get('dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

    Route::post('dashboard/roleassign', [DashboardController::class, 'roleassign'])
    ->name('dashboard.roleassign')
    ->middleware('auth');



Route::get('accountgroups/generate', [GroupSeeder::class, 'run'])
    ->name('accountgroups.generate')
    ->middleware('auth');

Route::get('accountgroups', [AccountGroupController::class, 'index'])
    ->name('accountgroups')
    ->middleware('auth');

Route::get('accountgroups/create', [AccountGroupController::class, 'create'])
    ->name('accountgroups.create')
    ->middleware('auth');

Route::get('accountgroups/{accountgroup}', [AccountGroupController::class, 'show'])
    ->name('accountgroups.show')
    ->middleware('auth');

Route::post('accountgroups', [AccountGroupController::class, 'store'])
    ->name('accountgroups.store')
    ->middleware('auth');

Route::get('accountgroups/{accountgroup}/edit', [AccountGroupController::class, 'edit'])
    ->name('accountgroups.edit')
    ->middleware('auth');

Route::put('accountgroups/{accountgroup}', [AccountGroupController::class, 'update'])
    ->name('accountgroups.update')
    ->middleware('auth');

Route::delete('accountgroups/{accountgroup}', [AccountGroupController::class, 'destroy'])
    ->name('accountgroups.destroy')
    ->middleware('auth');


//USER
Route::get('users', [UserController::class, 'index'])
    ->name('users')
    ->middleware('auth');


//COMPANIES -------------------- STARTS ---------------------------
Route::get('companies', [CompanyController::class, 'index'])
    ->name('companies')
    ->middleware('auth');

Route::get('companies/create', [CompanyController::class, 'create'])
    ->name('companies.create')
    ->middleware('auth');

Route::post('companies', [CompanyController::class, 'store'])
    ->name('companies.store')
    ->middleware('auth');

Route::get('companies/{company}/edit', [CompanyController::class, 'edit'])
    ->name('companies.edit')
    ->middleware('auth');

Route::put('companies/{company}', [CompanyController::class, 'update'])
    ->name('companies.update')
    ->middleware('auth');

Route::delete('companies/{company}', [CompanyController::class, 'destroy'])
    ->name('companies.destroy')
    ->middleware('auth');
//COMPANIES -------------------- END ---------------------------


//ACCOUNTS ----------------------- STARTS --------------------
Route::get('accounts', [AccountController::class, 'index'])
    ->name('accounts')
    ->middleware('auth');

Route::get('accounts/create', [AccountController::class, 'create'])
    ->name('accounts.create')
    ->middleware('auth');

Route::post('accounts', [AccountController::class, 'store'])
    ->name('accounts.store')
    ->middleware('auth');

Route::get('accounts/{account}/edit', [AccountController::class, 'edit'])
    ->name('accounts.edit')
    ->middleware('auth');

Route::put('accounts/{account}', [AccountController::class, 'update'])
    ->name('accounts.update')
    ->middleware('auth');

Route::delete('accounts/{account}', [AccountController::class, 'destroy'])
    ->name('accounts.destroy')
    ->middleware('auth');
//ACCOUNTS ----------------------- END --------------------


//DOCUMENT TYPES / VOUCHER ----------- STARTS ------------------------------
Route::get('documenttypes', [DocumentTypeController::class, 'index'])
    ->name('documenttypes')
    ->middleware('auth');

Route::get('documenttypes/create', [DocumentTypeController::class, 'create'])
    ->name('documenttypes.create')
    ->middleware('auth');

Route::post('documenttypes', [DocumentTypeController::class, 'store'])
    ->name('documenttypes.store')
    ->middleware('auth');

Route::get('documenttypes/{documenttype}/edit', [DocumentTypeController::class, 'edit'])
    ->name('documenttypes.edit')
    ->middleware('auth');

Route::put('documenttypes/{documenttype}', [DocumentTypeController::class, 'update'])
    ->name('documenttypes.update')
    ->middleware('auth');

Route::delete('documenttypes/{documenttype}', [DocumentTypeController::class, 'destroy'])
    ->name('documenttypes.destroy')
    ->middleware('auth');
//DOCUMENT TYPES / VOUCHER ----------- END ------------------------------


//DOCUMENT ....TRANSACTION + ENTRIES--------------------- STARTS ----------------------
Route::get('documents', [DocumentController::class, 'index'])
    ->name('documents')
    ->middleware('auth');

Route::get('documents/create', [DocumentController::class, 'create'])
    ->name('documents.create')
    ->middleware('auth');

Route::post('documents', [DocumentController::class, 'store'])
    ->name('documents.store')
    ->middleware('auth');

Route::get('documents/{document}/edit', [DocumentController::class, 'edit'])
    ->name('documents.edit')
    ->middleware('auth');

Route::put('documents/{document}', [DocumentController::class, 'update'])
    ->name('documents.update')
    ->middleware('auth');

Route::delete('documents/{document}', [DocumentController::class, 'destroy'])
    ->name('documents.destroy')
    ->middleware('auth');
//DOCUMENT ....TRANSACTION + ENTRIES--------------------- END ----------------------


//YEARS ------------------------------------ STARTS ------------------
Route::get('years', [YearController::class, 'index'])
    ->name('years')
    ->middleware('auth');

Route::get('years/create', [YearController::class, 'create'])
    ->name('years.create')
    ->middleware('auth');

Route::post('years', [YearController::class, 'store'])
    ->name('years.store')
    ->middleware('auth');

Route::get('years/{year}/edit', [YearController::class, 'edit'])
    ->name('years.edit')
    ->middleware('auth');

Route::put('years/{year}', [YearController::class, 'update'])
    ->name('years.update')
    ->middleware('auth');

Route::delete('years/{year}', [YearController::class, 'destroy'])
    ->name('years.destroy')
    ->middleware('auth');
//YEARS ------------------------------------ END ------------------


//Unit Types
Route::get('unittypes', [UnitTypeController::class, 'index'])
    ->name('unittypes')
    ->middleware('auth');

Route::get('unittypes/create', [UnitTypeController::class, 'create'])
    ->name('unittypes.create')
    ->middleware('auth');

Route::get('unittypes/{unittype}', [UnitTypeController::class, 'show'])
    ->name('unittypes.show')
    ->middleware('auth');

Route::post('unittypes', [UnitTypeController::class, 'store'])
    ->name('unittypes.store')
    ->middleware('auth');

Route::get('unittypes/{unittype}/edit', [UnitTypeController::class, 'edit'])
    ->name('unittypes.edit')
    ->middleware('auth');

Route::put('unittypes/{unittype}', [UnitTypeController::class, 'update'])
    ->name('unittypes.update')
    ->middleware('auth');

    Route::delete('unittypes/{unittype}', [UnitTypeController::class, 'destroy'])
    ->name('unittypes.destroy')
    ->middleware('auth');


    //Items
Route::get('items', [ItemController::class, 'index'])
->name('items')
->middleware('auth');

Route::get('items/create', [ItemController::class, 'create'])
->name('items.create')
->middleware('auth');

Route::get('items/{item}', [ItemController::class, 'show'])
->name('items.show')
->middleware('auth');

Route::post('items', [ItemController::class, 'store'])
->name('items.store')
->middleware('auth');

Route::get('items/{item}/edit', [ItemController::class, 'edit'])
->name('items.edit')
->middleware('auth');

Route::put('items/{item}', [ItemController::class, 'update'])
->name('items.update')
->middleware('auth');

Route::delete('items/{item}', [ItemController::class, 'destroy'])
->name('items.destroy')
->middleware('auth');


//Invoice
Route::get('invoices', [InvoiceController::class, 'index'])
->name('invoices')
->middleware('auth');

Route::get('invoices/create', [InvoiceController::class, 'create'])
->name('invoices.create')
->middleware('auth');

Route::get('invoices/{invoice}', [InvoiceController::class, 'show'])
->name('invoices.show')
->middleware('auth');

Route::post('invoices', [InvoiceController::class, 'store'])
->name('invoices.store')
->middleware('auth');

Route::get('invoices/{invoice}/edit', [InvoiceController::class, 'edit'])
->name('invoices.edit')
->middleware('auth');

Route::put('invoices/{invoice}', [InvoiceController::class, 'update'])
->name('invoices.update')
->middleware('auth');

Route::delete('invoices/{invoice}', [InvoiceController::class, 'destroy'])
->name('invoices.destroy')
->middleware('auth');


//Receipt
Route::get('receipts', [ReceiptController::class, 'index'])
->name('receipts')
->middleware('auth');

Route::get('receipts/create', [ReceiptController::class, 'create'])
->name('receipts.create')
->middleware('auth');

Route::get('receipts/{receipt}', [ReceiptController::class, 'show'])
->name('receipts.show')
->middleware('auth');

Route::post('receipts', [ReceiptController::class, 'store'])
->name('receipts.store')
->middleware('auth');

Route::get('receipts/{receipt}/edit', [ReceiptController::class, 'edit'])
->name('receipts.edit')
->middleware('auth');

Route::put('receipts/{receipt}', [ReceiptController::class, 'update'])
->name('receipts.update')
->middleware('auth');

Route::delete('receipts/{receipt}', [ReceiptController::class, 'destroy'])
->name('receipts.destroy')
->middleware('auth');


//Quantity
Route::get('quantities', [QuantityController::class, 'index'])
->name('quantities')
->middleware('auth');

Route::get('quantities/create', [QuantityController::class, 'create'])
->name('quantities.create')
->middleware('auth');

Route::get('quantities/{quantity}', [QuantityController::class, 'show'])
->name('quantities.show')
->middleware('auth');

Route::post('quantities', [QuantityController::class, 'store'])
->name('quantities.store')
->middleware('auth');

Route::get('quantities/{quantity}/edit', [QuantityController::class, 'edit'])
->name('quantities.edit')
->middleware('auth');

Route::put('quantities/{quantity}', [QuantityController::class, 'update'])
->name('quantities.update')
->middleware('auth');

Route::delete('quantities/{quantity}', [QuantityController::class, 'destroy'])
->name('quantities.destroy')
->middleware('auth');

//IMPORTER ------------------------------------ STARTS ------------------
Route::get('importers', [ImporterController::class, 'index'])
    ->name('importers')
    ->middleware('auth');

Route::get('importers/create', [ImporterController::class, 'create'])
    ->name('importers.create')
    ->middleware('auth');

Route::post('importers', [ImporterController::class, 'store'])
    ->name('importers.store')
    ->middleware('auth');

Route::get('importers/{importer}/edit', [ImporterController::class, 'edit'])
    ->name('importers.edit')
    ->middleware('auth');

Route::put('importers/{importer}', [ImporterController::class, 'update'])
    ->name('importers.update')
    ->middleware('auth');

Route::delete('importers/{importer}', [ImporterController::class, 'destroy'])
    ->name('importers.destroy')
    ->middleware('auth');
//IMPORTER ------------------------------------ END ------------------



//CLIENT ------------------------------------ STARTS ------------------
Route::get('clients', [ClientController::class, 'index'])
    ->name('clients')
    ->middleware('auth');

Route::get('clients/create', [ClientController::class, 'create'])
    ->name('clients.create')
    ->middleware('auth');

Route::post('clients', [ClientController::class, 'store'])
    ->name('clients.store')
    ->middleware('auth');

Route::get('clients/{client}/edit', [ClientController::class, 'edit'])
    ->name('clients.edit')
    ->middleware('auth');

Route::put('clients/{client}', [ClientController::class, 'update'])
    ->name('clients.update')
    ->middleware('auth');

Route::delete('clients/{client}', [ClientController::class, 'destroy'])
    ->name('clients.destroy')
    ->middleware('auth');
//CLIENT ------------------------------------ END ------------------



//Agent ------------------------------------ STARTS ------------------
Route::get('agents', [AgentController::class, 'index'])
    ->name('agents')
    ->middleware('auth');

Route::get('agents/create', [AgentController::class, 'create'])
    ->name('agents.create')
    ->middleware('auth');

Route::post('agents', [AgentController::class, 'store'])
    ->name('agents.store')
    ->middleware('auth');

Route::get('agents/{agent}/edit', [AgentController::class, 'edit'])
    ->name('agents.edit')
    ->middleware('auth');

Route::put('agents/{agent}', [AgentController::class, 'update'])
    ->name('agents.update')
    ->middleware('auth');

Route::delete('agents/{agent}', [AgentController::class, 'destroy'])
    ->name('agents.destroy')
    ->middleware('auth');
//AGENT ------------------------------------ END ------------------



//FILE ------------------------------------ STARTS ------------------
Route::get('files', [FileController::class, 'index'])
    ->name('files')
    ->middleware('auth');

Route::get('files/create', [FileController::class, 'create'])
    ->name('files.create')
    ->middleware('auth');

Route::post('files', [FileController::class, 'store'])
    ->name('files.store')
    ->middleware('auth');

Route::get('files/{file}/edit', [FileController::class, 'edit'])
    ->name('files.edit')
    ->middleware('auth');

Route::put('files/{file}', [FileController::class, 'update'])
    ->name('files.update')
    ->middleware('auth');

Route::delete('files/{file}', [FileController::class, 'destroy'])
    ->name('files.destroy')
    ->middleware('auth');
//FILE ------------------------------------ END ------------------
