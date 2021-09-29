<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request as Req;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Year;
use App\Models\Setting;
use App\Models\Company;
use App\Models\Document;
use App\Models\DocumentType;
use Inertia\Inertia;
use Carbon\Carbon;

class YearController extends Controller
{
    public function index()
    {

        return Inertia::render('Years/Index', [
            'data' => Year::all()
                ->where('company_id', session('company_id'))
                ->map(function ($year) {
                    return [
                        $begin = new Carbon($year->begin),
                        $end = new Carbon($year->end),
                        'id' => $year->id,
                        'begin' => $begin->format('F,j Y'),
                        'end' => $end->format('F,j Y'),
                        'company_name' => $year->company->name,
                        'company_id' => $year->company_id,
                        'delete' => Document::where('year_id', $year->id)->first() || $year->id == Year::where('company_id', session('company_id'))->first()->id ? false : true,
                        // 'delete' => Document::where('year_id', $year->id)->first() || $year == Year::where('company_id', session('company_id'))->first() ? false : true,
                    ];
                }),

            'companies' => Company::all()
                ->map(function ($com) {
                    return [
                        'id' => $com->id,
                        'name' => $com->name,
                    ];
                }),
        ]);
    }

    // public function create()
    // {
    //     return Inertia::render('Years/Create');
    // }
    public function create()
    {
        $year = Year::where('company_id', session('company_id'))->latest()->first();
        $begin = explode('-', $year->begin);
        $begin[0]++;
        $end = explode('-', $year->end);
        $end[0]++;
        $newBegin = implode('-', $begin);
        $newEnd = implode('-', $end);


        // dd($newBegin);
        Year::create([
            'begin' => $newBegin,
            'end' => $newEnd,
            'company_id' => session('company_id'),

        ]);

        $year = Year::where('company_id', session('company_id'))->latest()->first();
        // Storage::makedirectory('/public/' . $year->company->id . '/' . $year->id);


        return Redirect::back()->with('success', 'Year created.');
    }

    // public function store(Req $request)
    // {
    //     Request::validate([
    //         'begin' => ['required', 'date'],
    //         'end' => ['required', 'date'],
    //     ]);

    //     $year = Year::create([
    //         'begin' => $request->begin,
    //         'end' => $request->end,
    //         'company_id' => session('company_id'),
    //     ]);

    //     Setting::create([
    //         'key' => 'active_year',
    //         'value' => $year->id,
    //         'user_id' => Auth::user()->id,
    //     ]);

    //     session(['year_id' => $year->id]);
    //     return Redirect::route('years')->with('success', 'Year created.');
    // }

    public function edit(Year $year)
    {
        return Inertia::render('Years/Edit', [
            'year' => [
                'id' => $year->id,
                'begin' => $year->begin,
                'end' => $year->end,
                'company_id' => session('company_id'),
            ],
        ]);
    }

    public function update(Year $year)
    {
        Request::validate([
            'begin' => ['required', 'date'],
            'end' => ['required', 'date'],
        ]);

        $begin = new carbon(Request::input('begin'));
        $end = new carbon(Request::input('end'));

        $year->begin = $begin->format('Y-m-d');
        $year->end = $end->format('Y-m-d');
        $year->company_id = session('company_id');
        $year->save();

        return Redirect::route('years')->with('success', 'Year updated.');
    }

    public function destroy(Year $year)
    {
        // if (Document::where('year_id', $year->id)->first()) {
        //     return Redirect::back()->with('success', 'Can\'t DELETE this Year.');
        // } else {
        $year->delete();
        if (Year::where('company_id', session('company_id'))->first()) {
            return Redirect::back()->with('success', 'Year deleted.');
        } else {
            session(['year_id' => null]);
            return Redirect::route('years.create')->with('success', 'YEAR NOT FOUND. Please create an Year for selected Company.');
        }
        // }
    }

    public function yrch($id)
    {

        $active_yr = Setting::where('user_id', Auth::user()->id)->where('key', 'active_year')->first();

        $active_yr->value = $id;
        $active_yr->save();
        session(['year_id' => $id]);

        return Redirect::back();
    }
}
