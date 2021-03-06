<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as Req;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Models\UnitType;
use App\Models\Quantity;
use App\Models\Company;
use App\Models\Item;
use Inertia\Inertia;

class ItemController extends Controller
{
    public function index()
    {
        //Validating request
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:name']
        ]);

        //Searching request
        $query = Item::query();

        if (request('search')) {
            $query->where('name', 'LIKE', '%' . request('search') . '%');
        }


        if (request('searche')) {
            $query->where('hscode', 'LIKE', '%' . request('searche') . '%');
        }

        if (request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        } else {
            $query->orderBy(('name'), ('asc'));
        }
        // dd($query);


        return Inertia::render('Items/Index', [

            'filters' => request()->all(['search', 'searche', 'field', 'direction']),
            'balances' => $query->paginate(10)
                ->through(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'description' => $item->description,
                        'hscode' => $item->hscode,
                        'unit_id' => $item->unitTypes->name,
                        'delete' => Quantity::where('item_id', $item->id)->first() ? false : true,

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
        $unittype = \App\Models\UnitType::all()->map->only('id', 'name');

        if ($unittype->first()) {

            return Inertia::render('Items/Create', [
                'unittypes' => $unittype,
            ]);
        } else {
            return Redirect::route('unittypes.create')->with('warning', 'UNIT TYPE NOT FOUND, Please create unit type first.');
        }
    }

    public function store(Req  $request)
    {
        Request::validate([

            'items.*.name' => ['required', 'unique:items', 'max:255'],
            'items.*.hscode' => ['required', 'unique:items', 'max:255'],


        ]);

        $items = $request->items;
        // dd($accounts);
        foreach ($items as $item) {
            // dd($acc);
            Item::create([
                'name' => $item['name'],
                'description' => $item['description'],
                'hscode' => $item['hscode'],
                'unit_id' => $item['unit_id'],
                'file_id' => null,


            ]);
        }
        return Redirect::route('items')->with('success', 'Item created.');
    }

    // public function show(DocumentType $documenttype)
    // {
    // }

    public function edit(Item $item)
    {
        return Inertia::render('Items/Edit', [
            'item' => [
                'id' => $item->id,
                'name' => $item->name,
                'description' => $item->description,
                'hscode' => $item->hscode,
                // 'unit_id' =>$item->unit_id,

            ],
        ]);
    }

    public function update(Item $item)
    {
        Request::validate([
            'name' => ['required', 'max:255'],
            'hscode' => ['required', 'max:255'],

        ]);

        $item->name = Request::input('name');
        $item->description = Request::input('description');
        $item->hscode = Request::input('hscode');
        $item->save();

        return Redirect::route('items')->with('success', 'Item updated.');
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return Redirect::back()->with('success', 'Item deleted.');
    }
}
