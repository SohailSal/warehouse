<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as Req;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Models\Delivery;
use App\Models\Company;
use App\Models\File;
use App\Models\Item;
use App\Models\Quantity;
;
use Inertia\Inertia;



use App;

class DeliveryController extends Controller
{
    public function index()
    {
     
       

        return Inertia::render('Delivery/Index', [
            'data' =>Delivery::all()
            ->map(function ($item){
                // dd($item);
                return[
                    'id' => $item->id,
                    'date' => $item->date,
                    'file_id' => $item->files->file_no,
                    'cash_no' => $item->Cash_no,
                    'vehicle_no' => $item->Vehicle_no,
                    'item_id' => $item->items->name,
                    'qty' => $item->qty,
                    
    
                ];
            }),    
               
           

            'companies' => Company::all()
                ->map(
                    function ($com) {
                        return [
                            'id' => $com->id,
                            'name' => $com->name,
                        ];
                    }
                ),

        ]);
    }

    public function create()
    {
        $files = File::all()->map->only('id', 'file_no');
        
        $items = Item::all()->map->only('id', 'name');
        if ($files->first()) {
            if($items->first()){
                return Inertia::render('Delivery/Create', [
                    'items' => $items, 
                    'files' => $files, 
                ]);
            }
            else{
                return Redirect::route('items.create')->with('warning', 'ITEM NOT FOUND, Please create Item first.');
            }
            
        } else {
            return Redirect::route('files.create')->with('warning', 'FILE NOT FOUND, Please create File first.');
        }
    }

    public function store(Req  $request)
    {
        Request::validate([

            'deliveries.*.file_id' => 'required',
            

        ]);

        
        $deliveries = $request->deliveries;
        
        foreach ($deliveries as $delivery) {
         
               
                Delivery::create([
                    'file_id' => $delivery['file_id']['id'],
                    'date' => $delivery['date'],
                    'cash_no' => $delivery['cash_no'],
                    'vehicle_no' => $delivery['vehicle_no'],
                    'item_id' => $delivery['item_id']['id'],
                    'qty' => $delivery['qty'],
                 
                ]);
                return Redirect::route('deliveries')->with('success', 'Delivery created.');
        
        }
    }

    public function edit(Delivery $delivery)
    {
        $files = File::all()->map->only('id', 'file_no');   
        $items = Item::all()->map->only('id', 'name');
        $item_first = Item::where('id', $delivery->item_id)->first();
        $file_first = File::where('id', $delivery->file_id)->first();

        return Inertia::render('Delivery/Edit', [
           'items_first' => $item_first,
           'file_first' => $file_first,
            'files' => $files,
            'items' => $items,
            'delivery' => [
                'id' => $delivery->id,
                'date' => $delivery->date,
                'file_id' => $delivery->file_id,
                'Cash_no' => $delivery->Cash_no,
                'Vehicle_no' => $delivery->Vehicle_no,
                'item_id' => $delivery->item_id,
                'qty' => $delivery->qty,
            ],
        ]);
    }

    public function update(Delivery $delivery)
    {
        Request::validate([
            'date' => ['required'],
        ]);

        // dd($delivery);
        $delivery->date = Request::input('date');
        $delivery->file_id = Request::input('file_id')['id'];
        $delivery->Cash_no = Request::input('Cash_no');
        $delivery->Vehicle_no = Request::input('Vehicle_no');
        $delivery->item_id = Request::input('item_id')['id'];
        $delivery->qty = Request::input('qty');
        $delivery->save();

        return Redirect::route('deliveries')->with('success', 'Item updated.');
    }

    public function destroy(Delivery $delivery)
    {
        $delivery->delete();
        return Redirect::back()->with('success', 'Delivery deleted.');
    }


    public function pdf(Delivery $delivery)
    {
        
        $invoices = File::where('id', $delivery->file_id)->get()
            ->map(function ($invoice) {
            return[
            'id' => $invoice->id,
            'file_no' => $invoice->file_no,
            'qty' => $invoice->qty,
            'description' => $invoice->description,
            'amount' => $invoice->amount,
            's_tax' => $invoice->s_tax,
            'date_bond' => $invoice->date_bond,
            'importer' => $invoice->importers->name  ,
            'stn_no' => $invoice->importers->stn_no  ,
            'agent' => $invoice->agents->name ,
            'bond_no' => $invoice->bond_no,
            'lc_no' => $invoice->lc_no,
            ];
        });
    
        

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('invoice', compact('invoices','delivery'));
        return $pdf->stream('v.pdf');
        
       
    }
}
