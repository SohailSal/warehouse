<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountGroup;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\Year;
use App\Models\Setting;
use Egulias\EmailValidator\Warning\Warning;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;


use App;
use App\Models\AccountType;
use App\Models\Document;
use App\Models\Entry;
use App\Models\DocumentType;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;


class DashboardController extends Controller
{

    public function index()
    {
        $companies = Company::all();
        // $roles = Role::all();

        return Inertia::render('Dashboard', [
            'companies' => $companies,
            // 'roles' => $roles,
            // 'can' => [
            //     'edit' => auth()->user()->can('edit'),
            //     'create' => auth()->user()->can('create'),
            //     'delete' => auth()->user()->can('delete'),
            //     'read' => auth()->user()->can('read'),
            // ],

        ]);
    }

    public function roleassign()
    {
        $data['email'] = Request::input('email');
        $data['role'] = Request::input('role');

        Request::validate([
            'email' => ['required'],
            'role' => ['required'],
        ]);

        $userexist = User::where('email',$data['email'])->first('id');

        if($userexist){
            $userexist->roles()->detach();
            $userexist->assignRole($data['role']);
        }else{
            return Redirect::back()->with('warning', 'User email doesn\'t exists');
        }

        return Redirect::back()->with('success', 'Role assigned.'); 
    }

    public function create()
    {

    }

    public function store()
    {
        Request::validate([
            'email' => ['required'],
            'company_id' => ['required'],
            'role' => ['required'],
        ]);
       
        return Redirect::route('companies')->with('success', 'Company created');
    }

    public function edit(Company $company)
    {
        return Inertia::render('Company/Edit', [
            'company' => [
                'id' => $company->id,
                'name' => $company->name,
                'address' => $company->address,
                'email' => $company->email,
                'web' => $company->web,
                'phone' => $company->phone,
                'fiscal' => $company->fiscal,
                'incorp' => $company->incorp,
            ],
        ]);
    }

    public function update(Company $company)
    {
        Request::validate([
            'name' => ['required'],
            'address' => ['nullable'],
            'email' => ['nullable'],
            'web' => ['nullable'],
            'phone' => ['nullable'],
            'fiscal' => ['required'],
            'incorp' => ['nullable'],
        ]);

        $company->name = Request::input('name');
        $company->address = Request::input('address');
        $company->email = Request::input('email');
        $company->web = Request::input('web');
        $company->phone = Request::input('phone');
        $company->fiscal = Request::input('fiscal');

        $incorp = new carbon(Request::input('incorp'));
        $company->incorp = $incorp->format('Y-m-d');

        $company->save();

        return Redirect::route('companies')->with('success', 'Company updated.');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return Redirect::back()->with('success', 'Company deleted.');
    }

    //TO CHANGE THE COMPANY IN SESSION FROM DROPDOWN
    public function coch($id)
    {
        $active_co = Setting::where('user_id', Auth::user()->id)->where('key', 'active_company')->first();

        $active_co->value = $id;

        $active_co->save();
        session(['company_id' => $id]);

        if (Year::where('company_id', $id)->latest()->first()) {
            $active_yr = Setting::where('user_id', Auth::user()->id)->where('key', 'active_year')->first();
            $active_yr->value = Year::where('company_id', $id)->latest()->first()->id;
            $active_yr->save();
            session(['year_id' => $active_yr->value]);
            // $active_co->save();
            // session(['company_id' => $id]);
            return Redirect::back();
        } else {
            session(['year_id' => null]);
            return Redirect::route('years.create')->with('success', 'YEAR NOT FOUND. Please create an Year for selected Company.');
        }
    }
}
