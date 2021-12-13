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
use App\Models\Supplier;
use App\Models\Account;
use App\Models\AccountGroup;
use Artisan;

class SupplierController extends Controller
{

    public function index()
    {
        //Validating request
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:name,email']
        ]);

        //IMPORTER data
        $query = Supplier::paginate(6)
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
                    'delete' => Account::where('id', $impo->id)->first() ? false : true,

                ],
            );


        //Searching request
        $query = Supplier::query();
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

        return Inertia::render('Suppliers/Index', [
            'companies' => Company::all(),
            'supplier' => Supplier::first(),
            'balances' => $query->paginate(12),
            'filters' => request()->all(['search', 'field', 'direction'])
        ]);
    }

    public function create()
    {
        return Inertia::render('Suppliers/Create');
    }

    public function store(Req $request)
    {
        Request::validate([
            'name' => ['required', 'unique:suppliers', 'max:255'],
            'email' => ['required', 'email', 'unique:suppliers,email'],
        ]);
        DB::transaction(function () use ($request) {
            $accgroup = \App\Models\AccountGroup::where('name', 'Trade-Creditors')->where('company_id', session('company_id'))->first()->id;
            $accnumber = Account::where('group_id', $accgroup)->get()->last();
            if ($accnumber) {
                Account::create([
                    'number' => $accnumber->number + 1,
                    'name' => strtoupper($request->name),
                    'group_id' => $accgroup,
                    'company_id' => session('company_id'),
                ]);
            } else {
                Account::create([
                    'number' => 2001001,
                    'name' => strtoupper($request->name),
                    'group_id' => $accgroup,
                    'company_id' => session('company_id'),
                ]);
            }


            $account = Account::all()->last();

            Supplier::create([
                'name' => strtoupper($request->name),
                'email' => $request->email,
                'address' => $request->address,
                'stn_no' => $request->stn_no,
                'phone_no' => $request->phone_no,
                'ntn_no' => $request->ntn_no,
                'account_id' => $account->id,

            ]);
        });
        return Redirect::route('suppliers')->with('success', 'Supplier created');
    }

    public function edit(Supplier $supplier)
    {
        return Inertia::render('Suppliers/Edit', [
            'supplier' => [
                'id' => $supplier->id,
                'name' => $supplier->name,
                'email' => $supplier->email,
                'address' => $supplier->address,
                'stn_no' => $supplier->stn_no,
                'phone_no' => $supplier->phone_no,
                'ntn_no' => $supplier->ntn_no,
                'account_id' => $supplier->account_id,
            ],
        ]);
    }

    public function update(Supplier $supplier, Req $request)
    {
        // dd($request);
        Request::validate([
            'name' => ['required',  'max:255'],
            'email' => ['required', 'email'],
            'address' => ['nullable'],
            'stn_no' => ['nullable'],
            'phone_no' => ['nullable'],
            'ntn_no' => ['nullable'],
        ]);
        DB::transaction(function () use ($request, $supplier) {
            // dd($request);
            $supplier->name = strtoupper($request->name);
            $supplier->email = $request->email;
            $supplier->address = $request->address;
            $supplier->stn_no = $request->stn_no;
            $supplier->phone_no = $request->phone_no;
            $supplier->ntn_no = $request->ntn_no;
            $supplier->save();
            $account = Account::where('id', $request->account_id)->first();
            $account->name = strtoupper($request->name);
            $account->save();
        });


        return Redirect::route('suppliers')->with('success', 'Supplier updated.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return Redirect::back()->with('success', 'Supplier deleted.');
    }
}
