<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as Req;
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
        //Validating request
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:name,email']
        ]);

        //Searching request
        $query = Quantity::query();

        //Searching request
        if (request('search')) {
            $query->join('files', 'files.id', '=', 'file_id')
                ->select('quantities.*')
                ->where('files.file_no', 'LIKE', '%' . request('search') . '%');
        }
        if (request('searche')) {
            $query->join('items', 'items.id', '=', 'item_id')
                ->select('quantities.*')
                ->where('items.name', 'LIKE', '%' . request('searche') . '%');
        }

        //Ordering request
        if (request()->has(['field', 'direction'])) {
            $query->orderBy(
                request('field'),
                request('direction')
            );
        }

        return Inertia::render('Quantity/Index', [
            'filters' => request()->all([
                'search', 'searche'
                //  'field', 'direction'
            ]),
            'balances' => $query->paginate(10)
                ->through(function ($quantity) {
                    return [
                        'id' => $quantity->id,
                        'item_id' => $quantity->items->name,
                        'qty' => $quantity->qty,
                        'file_id' => $quantity->files->file_no,
                        'invoice_id' => $quantity->invoices,
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

        if ($items->first()) {
            if ($files->first()) {
                if ($invoices->first()) {

                    return Inertia::render('Quantity/Create', [
                        'items' => $items,
                        'files' => $files,
                        'invoices' => $invoices,
                    ]);
                } else {
                    return Redirect::route('invoices.create')->with('warning', 'INVOICE NOT FOUND, Please create Invoice first.');
                }
            } else {
                return Redirect::route('files.create')->with('warning', 'FILE NOT FOUND, Please create file first.');
            }
        } else {
            return Redirect::route('items.create')->with('warning', 'ITEM NOT FOUND, Please create Item first.');
        }
    }



    //     $items = $request->items;
    //     foreach ($items as $item) {
    //         Item::create([
    //             'name' => $item['name'],
    //             'description' => $item['description'],
    //             'hscode' => $item['hscode'],
    //             'unit_id' => $item['unit_id'],
    //             'file_id' => null,


    //         ]);
    //     }
    //     return Redirect::route('items')->with('success', 'Item created.');
    // }


    public function store(Req  $request)
    {
        // dd($request);
        Request::validate([
            'quantities.*.item_id' => 'required',
            'quantities.*.qty' => 'required',
            'quantities.*.file_id' => 'required',
        ]);
        $quantities = $request->quantities;
        foreach ($quantities as $quantity) {

            Quantity::create([
                'item_id' => $quantity['item_id']['id'],
                'qty' => $quantity['qty'],
                'file_id' => $quantity['file_id']['id'],

            ]);
        }
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

            'item' => \App\Models\Item::where('id', $quantity->item_id)->first(),
            'file' => \App\Models\File::where('id', $quantity->file_id)->first(),
            'invoice' => \App\Models\Invoice::where('id', $quantity->invoice_id)->first(),

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
            'item_id' => ['required'],
            'qty' => ['required'],
            'file_id' => ['required'],
        ]);

        $quantity->item_id = Request::input('item_id')['id'];
        $quantity->qty = Request::input('qty');
        $quantity->file_id = Request::input('file_id')['id'];
        $quantity->invoice_id = Request::input('invoice_id') ? Request::input('invoice_id')['id'] : null;
        $quantity->save();

        return Redirect::route('quantities')->with('success', 'Quantity updated.');
    }

    public function destroy(Quantity $quantity)
    {
        $quantity->delete();
        return Redirect::back()->with('success', 'Quantity deleted.');
    }
}
