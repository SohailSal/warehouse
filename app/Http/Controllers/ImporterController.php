<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;


use Inertia\Inertia;
use Illuminate\Http\Request as Req;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use Illuminate\Database\Seeder;
use App\Models\Importer;
use App\Models\Account;
use App\Models\AccountGroup;
use Artisan;

class ImporterController extends Controller
{
    
    public function index()
    {
        //Validating request
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:name,email']
        ]);

        //IMPORTER data
        $query = Importer::paginate(6)
            ->withQueryString()
            ->through(
                fn ($impo) =>
                [
                    'id' => $impo->id,
                    'name' => $impo->name,
                    'email' => $impo->email,
                    'address' => $impo->address,
                    'phone_no' => $impo->phone_no,
                    'stn_no' => $impo->stn_no,
                    'ntn_no' => $impo->ntn_no,
                ],
            );
     
     
        //Searching request
        $query = Importer::query();
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
     
        return Inertia::render('Importers/Index', [
            'companies' => Company::all(),
            'importer' => Importer::first(),
            'balances' => $query->paginate(12),
            'filters' => request()->all(['search', 'field', 'direction'])
        ]);
    }

    public function create()
    {
        $checkacc = Account::where('company_id' , session('company_id'));

        if(!$checkacc->first()){
            $exitCode = Artisan::call('db:seed', [
                '--class' => 'DatabaseSeeder',
            ]);
        }
  
        return Inertia::render('Importers/Create');
    }

    public function store(Req $request)
    {
        Request::validate([
            'name' => ['required'],
        ]);
        DB::transaction(function () use ($request) {
            // dd($request->name);
            Importer::create([
                'name' => strtoupper($request->name),
                'email' => $request->email,
                'address' => $request->address,
                'stn_no' => $request->stn_no,
                'phone_no' => $request->phone_no,
                'ntn_no' => $request->ntn_no,

            ]);

            $accgroup = AccountGroup::where('company_id' , session('company_id'))->get()->first();
            $accnumber = Account::where('group_id' , $accgroup->id)->get()->last();

            Account::create([
                'number' => $accnumber->number + 1,
                'name' => strtoupper($request->name),
                'group_id' => $accgroup->id,
                'company_id' => session('company_id'),
            ]);


        });
        return Redirect::route('importers')->with('success', 'Importer created');
    }

    public function edit(Importer $importer)
    {
        return Inertia::render('Importers/Edit', [
            'importer' => [
                'id' => $importer->id,
                'name' => $importer->name,
                'email' => $importer->email,
                'address' => $importer->address,
                'stn_no' => $importer->stn_no,
                'phone_no' => $importer->phone_no,
                'ntn_no' => $importer->ntn_no,
            ],
        ]);
    }

    public function update(Importer $importer)
    {
        Request::validate([
            'name' => ['required'],
            'email' => ['nullable'],
            'address' => ['nullable'],
            'stn_no' => ['nullable'],
            'phone_no' => ['nullable'],
            'ntn_no' => ['nullable'],
        ]);

        $importer->name = strtoupper(Request::input('name'));
        $importer->email = Request::input('email');
        $importer->address = Request::input('address');
        $importer->stn_no = Request::input('stn_no');
        $importer->phone_no = Request::input('phone_no');
        $importer->ntn_no = Request::input('ntn_no');

        $importer->save();

        return Redirect::route('importers')->with('success', 'Importer updated.');
    }

    public function destroy(Importer $importer)
    {
        $importer->delete();
        return Redirect::back()->with('success', 'Importer deleted.');
    }
}   