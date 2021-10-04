<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Models\Invoice;
use App\Models\Company;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    public function index()
    {

     
        return Inertia::render('Invoices/Index', [

            'data' =>Invoice::all()
            ->map(function ($invoice){
                return[
                    'id' => $invoice->id,
                    'client_id' => $invoice->clients->name,
                    'date' => $invoice->date,
                    'amount' => $invoice->amount,    
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

        $clients = \App\Models\Client::all()->map->only('id', 'name');


        if ($clients) {

            return Inertia::render('Invoices/Create', [
                'clients' => $clients, 
            ]);
        } else {
            return Redirect::route('clients.create')->with('success', 'Client NOT FOUND, Please create Client first.');
        }
    }

    public function store()
    {
        Request::validate([
            'date' => ['required'],
            'amount' => ['required'],
        ]);
        
        Invoice::create([
            'client_id' => Request::input('client_id'),
            'date' => Request::input('date'),
            'amount' => Request::input('amount'),
        
            
        ]);

        return Redirect::route('invoices')->with('success', 'Invoice created.');
    }

    // public function show(DocumentType $documenttype)
    // {
    // }

    public function edit(Invoice $invoice)
    {
        return Inertia::render('Invoices/Edit', [
            'invoice' => [
                'id' => $invoice->id,
                'date' => $invoice->date,
                'amount' => $invoice->amount,
            ],
        ]);
    }

    public function update(Invoice $invoice)
    {
        Request::validate([
            'amount' => ['required'],
        ]);

        $invoice->date = Request::input('date');
        $invoice->amount = Request::input('amount');
        $invoice->save();

        return Redirect::route('invoices')->with('success', 'Invoice updated.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return Redirect::back()->with('success', 'Invoice deleted.');
    }
}
