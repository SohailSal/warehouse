<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Models\UnitType;
use App\Models\Company;
use App\Models\Document;
use App\Models\Item;
use Inertia\Inertia;

class UnitTypeController extends Controller
{
    public function index()
    {
        //Validating request
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:name,email']
        ]);

        //Searching request
        $query = UnitType::query();

        if (request('search')) {
            $query->where('name', 'LIKE', '%' . request('search') . '%');
        }

        //Ordering request
        if (request()->has(['field', 'direction'])) {
            $query->orderBy(
                request('field'),
                request('direction')
            );
        }


        return Inertia::render('UnitTypes/Index', [

            'balances' => $query->paginate(12)
                ->through(
                    fn ($unittype) =>
                    [
                        'id' => $unittype->id,
                        'name' => $unittype->name,
                        'delete' => Item::where('unit_id', $unittype->id)->first() ? false : true,
                    ]
                ),
            'filters' => request()->all(['search', 'field', 'direction']),
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

            'name' => ['required', 'unique:unit_types', 'max:255'],

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
            'name' => ['required', 'max:255'],
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
