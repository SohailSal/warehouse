<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Models\Receipt;
use App\Models\Company;
use Inertia\Inertia;

class ReceiptController extends Controller
{
    public function index()
    {

     
        return Inertia::render('Receipts/Index', [

            'data' =>Receipt::all()
            ->map(function ($receipt){
                return[
                    'id' => $receipt->id,
                    'client_id' => $receipt->clients->name,
                    'date' => $receipt->date,
                    'amount' => $receipt->amount,    
                    'i_tax' => $receipt->i_tax,    
                    's_tax' => $receipt->s_tax,    
                    'com' => $receipt->com,    
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

        $clients = \App\Models\Client::all();


        if ($clients->first()) {
            
            return Inertia::render('Receipts/Create', [
                'clients' => $clients, 
            ]);
        } else {
            return Redirect::route('clients.create')->with('warning', 'Client NOT FOUND, Please create Client first.');
        }
    }

    public function store()
    {
        Request::validate([
            'date' => ['required'],
            'amount' => ['required'],
        ]);
        
        Receipt::create([
            'client_id' => Request::input('client_id'),
            'date' => Request::input('date'),
            'amount' => Request::input('amount'),
            'i_tax' => Request::input('i_tax'),
            's_tax' => Request::input('s_tax'),
            'com' => Request::input('com'),
            
        ]);

        return Redirect::route('receipts')->with('success', 'Receipt created.');
    }


    public function edit(Receipt $receipt)
    {
        // dd($receipt);

        return Inertia::render('Receipts/Edit', [
            'receipt' => [
                'id' => $receipt->id,
                'date' => $receipt->date,
                'amount' => $receipt->amount,
                'i_tax' => $receipt->i_tax,
                's_tax' => $receipt->s_tax,
                'com' => $receipt->com,
            ],
        ]);
    }

    public function update(Receipt $receipt)
    {
        Request::validate([
            'amount' => ['required'],
        ]);

        $receipt->date = Request::input('date');
        $receipt->amount = Request::input('amount');
        $receipt->i_tax = Request::input('i_tax');
        $receipt->s_tax = Request::input('s_tax');
        $receipt->com = Request::input('com');
        $receipt->save();
        return Redirect::route('receipts')->with('success', 'Receipt updated.');
    }

    public function destroy(Receipt $receipt)
    {
        $receipt->delete();
        return Redirect::back()->with('success', 'Receipt deleted.');
    }
}
