<?php

namespace App\Http\Controllers;


use App;
use App\Models\Account;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request as Req;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Year;
use App\Models\Setting;
use App\Models\Company;
use App\Models\Document;
use App\Models\Entry;
use App\Models\DocumentType;
use App\Models\User;
use Inertia\Inertia;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
// use Crypt;
use Illuminate\Support\Facades\Crypt;
use PDF;

class WarehouseReportController extends Controller
{
    public function index()
    {
        $accounts = \App\Models\Account::all()->where('company_id', session('company_id'))->map->only('id', 'name');
        $account_first = \App\Models\Account::all()->where('company_id', session('company_id'))->map->only('id', 'name')->first();
        return Inertia::render('Reports/WarehouseIndex', [
            'account_first' => $account_first,
            'accounts' => $accounts,
            'companies' => Company::all()
                ->map(function ($com) {
                    return [
                        'id' => $com->id,
                        'name' => $com->name,
                    ];
                }),
        ]);
    }

// FOR Delivery Order GENERATION -------------------------- --------
    public function deliveryorder()
    {

        $tb = App::make('dompdf.wrapper');
        $tb->loadView('receipt');
        return $tb->stream('receipt.pdf');





//DELIVERY REPORT
        // $data['accounts'] = Account::where('company_id', session('company_id'))->get();

        // $tb = App::make('dompdf.wrapper');
        // // $pdf->loadView('pdf', compact('a'));
        // $tb->loadView('deliveryOrder', $data);
        // return $tb->stream('deliveryOrder.pdf');
//DELIVERY REPORT
    }

}
