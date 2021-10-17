<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Models\Quantity;
use App\Models\Company;
use App\Models\Document;
use Inertia\Inertia;

class QuantityController extends Controller
{
    public function index()
    {
     
        return Inertia::render('Quantity/Index', [

            'data' => Quantity::all()
                ->map(function ($quantity) {
                    return [
                        'id' => $quantity->id,
                         'item_id' => $quantity->items->name,  
                        'number' => $quantity->number,
                        'file_id' => $quantity->files->file_no,
                        'invoice_id' => $quantity->invoices->amount,
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
        $items = \App\Models\Item::all(); 
                $files = \App\Models\File::all(); 
                $invoices = \App\Models\Invoice::all(); 

       if($items->first()){
         if($files->first()){
               if($invoices->first()){

                   return Inertia::render('Quantity/Create', [
                       'items' => $items, 
                       'files' => $files, 
                       'invoices' => $invoices, 
                    ]);
                }else{
              return Redirect::route('invoices.create')->with('warning', 'INVOICE NOT FOUND, Please create Invoice first.');
                }
           }else{
             return Redirect::route('files.create')->with('warning', 'FILE NOT FOUND, Please create file first.');
        }
        } else {
            return Redirect::route('items.create')->with('warning', 'ITEM NOT FOUND, Please create Item first.');
        }
    }

    public function store()
    {
        Request::validate([
            'number' => ['required'],
        ]);
        
        Quantity::create([
            'item_id' => Request::input('item_id'),
            'file_id' => Request::input('file_id'),
            'qty' => Request::input('qty'),
            'invoice_id' => Request::input('invoice_id'),
        ]);

        return Redirect::route('quantities')->with('success', 'Quantity created.');
    }

    // public function show(DocumentType $documenttype)
    // {
    // }

    public function edit(Quantity $quantity)
    {
        return Inertia::render('Quantity/Edit', [
            'items' => \App\Models\Item::all(), 
            'files' => \App\Models\File::all(), 
            'invoices' => \App\Models\Invoice::all(), 
            
            'quantity' => [
                'id' => $quantity->id,
                'item_id' => $quantity->item_id,
                'qty' => $quantity->qty,
                'file_id' => $quantity->file_id,
                'invoice_id' => $quantity->invoice_id,
            ],
        ]);
    }

    public function update(Quantity $quantity)
    {
        Request::validate([
            'qty' => ['required'],
        ]);

        $quantity->item_id = Request::input('item_id');
        $quantity->qty = Request::input('qty');
        $quantity->file_id = Request::input('file_id');
        $quantity->invoice_id = Request::input('invoice_id');
        $quantity->save();

        return Redirect::route('quantities')->with('success', 'Quantity updated.');
    }

    public function destroy(Quantity $quantity)
    {
        $quantity->delete();
        return Redirect::back()->with('success', 'Quantity deleted.');
    }
}
