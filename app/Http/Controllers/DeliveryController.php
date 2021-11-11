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
use Inertia\Inertia;
use App;

class DeliveryController extends Controller
{
    public function index()
    {
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:file_id']
        ]);

        $query = Delivery::query();

        // $file_id = $query->paginate(10)
        //     ->through(function ($item) {
        //         return [
        //             'no' => $item->files->file_no,
        //         ];
        //     });

        // // dd($file_id);
        if (request('search')) {
            $query->where('file_id', 'LIKE', '%' . request('search') . '%');
        }


        if (request('searche')) {
            $query->where('item_id', 'LIKE', '%' . request('searche') . '%');
        }

        if (request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        } else {
            $query->orderBy(('file_id'), ('asc'));
        }


        return Inertia::render('Delivery/Index', [
            'filters' => request()->all(['search', 'searche', 'field', 'direction']),
            'balances' => $query->paginate(10)
                ->through(function ($item) {
                    return [
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
        $quantity = Quantity::all()->map->only('id', 'qty');
        if ($quantity->first()) {
            if ($items->first()) {
                if ($files->first()) {
                    return Inertia::render('Delivery/Create', [
                        'items' => $items,
                        'files' => $files,
                    ]);
                } else {
                    return Redirect::route('files.create')->with('warning', 'FILE NOT FOUND, Please create File first.');
                }
            } else {
                return Redirect::route('items.create')->with('warning', 'ITEM NOT FOUND, Please create Item first.');
            }
        } else {
            return Redirect::route('quantities.create')->with('warning', 'Quantity NOT FOUND, Please create Quantity first.');
        }
    }

    public function store(Req  $request)
    {
        Request::validate([
            'deliveries.*.file_id' => 'required',
        ]);


        $deliveries = $request->deliveries;
        // dd($deliveries);
        foreach ($deliveries as $delivery) {


            $t_quantity = Quantity::where('file_id', $delivery['file_id']['id'])->get();
            $total_qty = 0;
            foreach ($t_quantity as $qty) {
                if ($qty->item_id == $delivery['item_id']['id']) {
                    $total_qty += $qty->qty;
                }
            }
            // dd($total_qty);
            $t_delivery = Delivery::where('file_id', $delivery['file_id']['id'])->get();
            $total_del = 0;
            foreach ($t_delivery as $delvry) {
                if ($delvry->item_id == $delivery['item_id']['id']) {
                    $total_del += $delvry->qty;
                }
            }
            // dd($total_del);
            $aval = $total_qty - $total_del;
            // dd($aval);
            $bal = $aval - $delivery['qty'];

            if ($bal >= 0) {
                Delivery::create([
                    'file_id' => $delivery['file_id']['id'],
                    'date' => $delivery['date'],
                    'cash_no' => $delivery['cash_no'],
                    'vehicle_no' => $delivery['vehicle_no'],
                    'item_id' => $delivery['item_id']['id'],
                    'qty' => $delivery['qty'],

                ]);
            } else {
                return Redirect::route('deliveries.create')->with('warning', $delivery['item_id']['name'] . ' Out of stock ' . $aval . ' Avalible Quantity');
            }
        }
        return Redirect::route('deliveries')->with('success', 'Delivery created.');
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



        $t_quantity = Quantity::where('file_id', Request::input('file_id')['id'])->get();
        $total_qty = 0;
        foreach ($t_quantity as $qty) {
            if ($qty->item_id == Request::input('item_id')['id']) {
                $total_qty += $qty->qty;
            }
        }
        // dd($total_qty);
        $t_delivery = Delivery::where('file_id', Request::input('file_id')['id'])->get();
        $total_del = 0;
        foreach ($t_delivery as $delvry) {
            if ($delvry->item_id == Request::input('item_id')['id']) {
                $total_del += $delvry->qty;
            }
        }
        // dd($total_del);
        $aval = $total_qty - $total_del;
        $add = $aval + $delivery->qty;
        $bal = $add - Request::input('qty');
        if ($bal >= 0) {
            $delivery->date = Request::input('date');
            $delivery->file_id = Request::input('file_id')['id'];
            $delivery->Cash_no = Request::input('Cash_no');
            $delivery->Vehicle_no = Request::input('Vehicle_no');
            $delivery->item_id = Request::input('item_id')['id'];
            $delivery->qty = Request::input('qty');
            $delivery->save();
            return Redirect::route('deliveries')->with('success', 'Item updated.');
        } else {
            return Redirect::back()->with('warning',  Request::input('item_id')['name'] . ' Out of stock ' . $add . ' Avalible Quantity');
        }
    }


    public function destroy(Delivery $delivery)
    {
        $delivery->delete();
        return Redirect::back()->with('success', 'Delivery deleted.');
    }


    public function deliveryReport(Delivery $delivery)
    {
        $items = Delivery::where('date', $delivery->date)->get()
            ->map(function ($item) {
                return [
                    'item' => $item->items->name,
                    'quantity' => $item->qty,
                ];
            });
        // dd($items);
        // $delivery = Delivery::where('id', $delivery->id)->get()
        $delivery = Delivery::where('id', $delivery->id)->get()
            ->map(function ($delivery) {
                return [
                    'code' => $delivery->files->file_code,
                    'no_of_pkgs' => $delivery->files->qty,
                    'importer' => $delivery->files->importers->name,
                    'descrip' => $delivery->files->description,
                    'file_no' => $delivery->files->file_no,
                    'index' => $delivery->files->index_no,
                    'vehicle_no' => $delivery->Vehicle_no,
                    'quantity' => $delivery->files->qty,
                ];
            });
        // dd($delivery);

        $pdf = App::make('dompdf.wrapper');
        // $pdf->loadView('invoice', compact('invoices','delivery'));
        $pdf->loadView('deliveryOrder', compact('delivery', 'items'));
        return $pdf->stream('v.pdf');

        // $invoices = File::where('id', $delivery->file_id)->get()
        //     ->map(function ($invoice) {
        //     return[
        //     'id' => $invoice->id,
        //     'file_no' => $invoice->file_no,
        //     'file_code' => $invoice->file_code,
        //     'qty' => $invoice->qty,
        //     'description' => $invoice->description,
        //     'amount' => $invoice->amount,
        //     's_tax' => $invoice->s_tax,
        //     'date_bond' => $invoice->date_bond,
        //     'importer' => $invoice->importers->name ? $invoice->importers->name : null,
        //     'stn_no' => $invoice->importers->stn_no ? $invoice->importers->stn_no : null,
        //     'agent' => $invoice->agents ? $invoice->agents->name : null,
        //     'bond_no' => $invoice->bond_no,
        //     'lc_no' => $invoice->lc_no,
        //     ];
        // });
    }
}
