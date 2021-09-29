<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Models\Account;
use App\Models\Company;
use App\Models\Entry;
use App\Models\AccountGroup;
use Inertia\Inertia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class AccountController extends Controller
{
    public function index()
    {
        if (AccountGroup::where('company_id', session('company_id'))->first()) {
            
        // //Validating request
        // request()->validate([
        //     'direction' => ['in:asc,desc'],
        //     'field' => ['in:name,email']
        // ]);

        //Searching request
        $query = Account::query();
        if (request('search')) {
            $query->where('name', 'LIKE', '%' . request('search') . '%');
        }
        // // Ordering request
        // if (request()->has(['field', 'direction'])) {
        //     $query->orderBy(
        //         request('field'),
        //         request('direction')
        //     );
        // }

        $balances = $query
            ->where('company_id', session('company_id'))
            ->paginate(15)
            ->through(
                function ($account) {
                    return
                        [
                            'id' => $account->id,
                            'name' => $account->name,
                            'group_id' => $account->group_id,
                            'group_name' => $account->accountGroup->name,
                            'delete' => Entry::where('account_id', $account->id)->first() ? false : true,
                        ];
                }
            );
            return Inertia::render('Accounts/Index', [
                // 'data' => $query->paginate(6),
                'filters' => request()->all(['search', 'field', 'direction']),
                'balances' => $balances,
                'companies' => Company::all()
                    ->map(function ($com) {
                        return [
                            'id' => $com->id,
                            'name' => $com->name,
                        ];
                    }),
                // 'data' => Account::all()
                //     ->where('company_id', session('company_id'))
                //     ->map(function ($account) {
                //         return [
                //             'id' => $account->id,
                //             'name' => $account->name,
                //             'group_id' => $account->group_id,
                //             'group_name' => $account->accountGroup->name,
                //             'delete' => Entry::where('account_id', $account->id)->first() ? false : true,

                //         ];
                //     }),
            ]);
        } else {
            return Redirect::route('accountgroups')->with('warning', 'ACCOUNTGROUP NOT FOUND, Please create account group first.');
        }
    }

    public function create()
    {
        $groups = \App\Models\AccountGroup::all()->where('company_id', session('company_id'))->map->only('id', 'name');
        // $group_first = \App\Models\AccountGroup::all('id', 'name')->first();
        $group_first = \App\Models\AccountGroup::all()->where('company_id', session('company_id'))->map->only('id', 'name')->first();

        if ($group_first) {

            return Inertia::render('Accounts/Create', [
                'groups' => $groups, 
                'group_first' => $group_first,
            ]);
        } else {
            return Redirect::route('accountgroups.create')->with('success', 'ACCOUNTGROUP NOT FOUND, Please create account group first.');
        }
    }

    public function store()
    {
        // dd(Request::input('group'));
        Request::validate([
            'name' => ['required'],
            'number' => ['nullable'],
            'group' => ['required'],
        ]);

        Account::create([
            'name' => Request::input('name'),
            'number' => Request::input('number'),
            'group_id' => Request::input('group')['id'],
            'company_id' => session('company_id'),
        ]);

        return Redirect::route('accounts')->with('success', 'Account created.');
    }

    // public function show(AccountGroup $accountgroup)
    // {
    // }

    public function edit(Account $account)
    {
        $groups = \App\Models\AccountGroup::all()->where('company_id', session('company_id'))->map->only('id', 'name');
    
        $group_first = AccountGroup::where('id', $account->group_id)->first();
        
        return Inertia::render('Accounts/Edit', [
            'account' => [
                'id' => $account->id,
                'company_id' => $account->company_id,
                'group_id' => $account->group_id,
                'name' => $account->name,
                'number' => $account->number,
            ],
            'groups' => $groups,
            'group_first' => $group_first,
        ]);
    }

    public function update(Account $account)
    {
        Request::validate([
            'group' => ['required'],
            'number' => ['nullable'],
            'name' => ['required'],
        ]);
        $account->group_id = Request::input('group')['id'];
        $account->company_id = session('company_id');
        $account->number = Request::input('number');
        $account->name = Request::input('name');
        $account->save();

        return Redirect::route('accounts')->with('success', 'Account updated.');
    }

    public function destroy(Account $account)
    {
        $account->delete();
        return Redirect::back()->with('success', 'Account deleted.');
    }
}
