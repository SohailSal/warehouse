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
                    'file_id' => $invoice->files->file_no,
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

        $files = \App\Models\File::all();
        // dd($clients->first());

        if ($files->first()) {

            return Inertia::render('Invoices/Create', [
                'files' => $files, 
            ]);
        } else {
            return Redirect::route('files.create')->with('warning', 'File NOT FOUND, Please create File first.');
        }
    }

    public function store()
    {
        Request::validate([
            'file_id' => ['required'],
            'date' => ['required'],
            'amount' => ['required'],
        ]);
        
        Invoice::create([
            'file_id' => Request::input('file_id')['id'],
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
