<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Models\UnitType;
use App\Models\Company;
use App\Models\Document;
use Inertia\Inertia;

class UnitTypeController extends Controller
{
    public function index()
    {
     
        return Inertia::render('UnitTypes/Index', [

            'data' => UnitType::all(),
                // ->where('company_id', session('company_id'))
                // ->map(function ($unit_type) {
                    // return [
                        // 'id' => $unit_type->id,
                        // 'name' => $unit_type->name,
                    // ];
                // }),


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
        return Inertia::render('UnitTypes/Create');
    }

    public function store()
    {
        Request::validate([
            'name' => ['required'],
        ]);
        
        UnitType::create([
            'name' => Request::input('name'),
        ]);

        return Redirect::route('unittypes')->with('success', 'Unit Type created.');
    }

    // public function show(DocumentType $documenttype)
    // {
    // }

    public function edit(UnitType $unittype)
    {
        return Inertia::render('UnitTypes/Edit', [
            'unittype' => [
                'id' => $unittype->id,
                'name' => $unittype->name,
            ],
        ]);
    }

    public function update(UnitType $unittype)
    {
        Request::validate([
            'name' => ['required'],
        ]);

        $unittype->name = Request::input('name');
        $unittype->save();

        return Redirect::route('unittypes')->with('success', 'Unit Type updated.');
    }

    public function destroy(UnitType $unittype)
    {
        $unittype->delete();
        return Redirect::back()->with('success', 'Unit Type deleted.');
    }
}
