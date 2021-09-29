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


//Ledger Sheet -------------------- Starts ---------------------------
// Route::post('ledger/{id}', [ReportController::class, 'ledger'])
//     ->name('ledger')
//     ->middleware('auth');

Route::get('range', [ReportController::class, 'rangeLedger'])
    ->name('range')
    ->middleware('auth');


//TO CHANGE COMPANY THE FROM DROPDOWN
Route::get('companies/coch/{id}', [CompanyController::class, 'coch'])
    ->name('companies.coch');

//TO CHANGE YEAR THE FROM DROPDOWN
Route::get('years/yrch/{id}', [YearController::class, 'yrch'])
    ->name('years.yrch');

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->name('dashboard');

Route::get('dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

    Route::post('dashboard/roleassign', [DashboardController::class, 'roleassign'])
    ->name('dashboard.roleassign')
    ->middleware('auth');

// Route::get('accountgroups/generate', [AccountGroupController::class, 'generate'])
//     ->name('accountgroups.generate')
//     ->middleware('auth');

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
