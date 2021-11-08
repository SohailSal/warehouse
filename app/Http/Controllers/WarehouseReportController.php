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
use App\Models\Delivery;
use App\Models\Quantity;
use App\Models\File;
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
    
    // FOR Labour Contract GENERATION -------------------------- --------
    public function labourcontract()
    {
        $tb = App::make('dompdf.wrapper');
        $tb->loadView('labourcontract');
        return $tb->stream('labourcontract.pdf');
    }


    public function bincard($bincard)
    {
        $data = Delivery::where('file_id', $bincard)->get()
            ->map(function ($delivery) {
                $quantiy = Quantity::where('file_id', $delivery->file_id)->get()->sum('qty');
                return [
                    'date' => $delivery->date,
                    'item' => $delivery->items->name,
                    'qty' => $delivery->qty,
                    't_qty' => $quantiy,
                    'vehicle_no' => $delivery->Vehicle_no,
                ];
            })->toArray();



        // }
        // dd($quantity);
        $file = File::where('id', $bincard)->get()
            ->map(function ($file) {
                $quantity = Quantity::where('file_id', $file->id)->get()->sum('qty');

                return [
                    'bond_no' => $file->bond_no,
                    'file_no' => $file->file_no,
                    'date' => $file->date_bond,
                    's.s' => $file->bl_no,
                    'igm_no' => $file->vir_no,
                    'index_no' => $file->index_no,
                    'importer_id' => $file->importers ? $file->importers->name : null,
                    'client_id' =>   $file->clients ? $file->clients->name : null,
                    'agent_id' =>   $file->agents ? $file->agents->name : null,
                    'desc' => $file->description,
                    'qty' => $quantity,
                    'file_code' => $file->file_code,
                ];
            })->toArray();
        // dd($file);


        $bc = App::make('dompdf.wrapper');
        $bc->loadView('bincard', compact('data', 'file'));
        return $bc->stream('BinCard.pdf');
    }

    public function gatePass()
    {
        // $data = Delivery::where('file_id', $bincard)->get()
        //     ->map(function ($delivery) {
        //         $quantiy = Quantity::where('file_id', $delivery->file_id)->get()->sum('qty');
        //         return [
        //             'date' => $delivery->date,
        //             'item' => $delivery->items->name,
        //             'qty' => $delivery->qty,
        //             't_qty' => $quantiy,
        //             'vehicle_no' => $delivery->Vehicle_no,
        //         ];
        //     })->toArray();



        // }
        // dd($quantity);
        // $file = File::where('id', $bincard)->get()
        //     ->map(function ($file) {
        //         $quantity = Quantity::where('file_id', $file->id)->get()->sum('qty');

        //         return [
        //             'bond_no' => $file->bond_no,
        //             'file_no' => $file->file_no,
        //             'date' => $file->date_bond,
        //             's.s' => $file->bl_no,
        //             'igm_no' => $file->vir_no,
        //             'index_no' => $file->index_no,
        //             'importer_id' => $file->importers ? $file->importers->name : null,
        //             'client_id' =>   $file->clients ? $file->clients->name : null,
        //             'agent_id' =>   $file->agents ? $file->agents->name : null,
        //             'desc' => $file->description,
        //             'qty' => $quantity,
        //             'file_code' => $file->file_code,
        //         ];
        //     })->toArray();
        // // dd($file);

        $data = ['a', 54, 'juanid'];
        // dd($data);
        $bc = App::make('dompdf.wrapper');
        $bc->loadView('gatepass', compact('data'));
        return $bc->stream('gatePass.pdf');
    }
}
