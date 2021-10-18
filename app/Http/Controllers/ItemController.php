<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as Req;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Models\UnitType;
use App\Models\Company;
use App\Models\Item;
use Inertia\Inertia;

class ItemController extends Controller
{
    public function index()
    {
     

        return Inertia::render('Items/Index', [
            'data' =>Item::all()
            ->map(function ($item){
                return[
                    'id' => $item->id,
                    'name' => $item->name,
                    'description' => $item->description,
                    'hscode' => $item->hscode,
                    'unit_id' => $item->unitTypes->name,
                    
    
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

            'items.*.name' => 'required',
            

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
                'description' =>$item->description,
                'hscode' =>$item->hscode,
                // 'unit_id' =>$item->unit_id,

            ],
        ]);
    }

    public function update(Item $item)
    {
        Request::validate([
            'name' => ['required'],
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
