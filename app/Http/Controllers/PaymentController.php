<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request as Req;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Payment;
use App\Models\Company;
use App\Models\Account;
use App\Models\Document;
use App\Models\Entry;
use Carbon\Carbon;
use Inertia\Inertia;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Validating request
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:file_id']
        ]);

        $query = Payment::query();

        //Searching request
        if (request('search')) {
            $query->where('payment_no', 'LIKE', '%' . request('search') . '%');
        }
        if (request('searche')) {
            $query->join('accounts', 'accounts.id', '=', 'account_id')
                ->select('payments.*')
                ->where('accounts.name', 'LIKE', '%' . request('searche') . '%');
        }

        if (request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        }

        return Inertia::render('Payments/Index', [
            'filters' => request()->all([
                'search', 'searche'
                //  'field', 'direction'
            ]),
            'balances' => $query->paginate(10)
                ->through(function ($payment) {
                    return [
                        'id' => $payment->id,
                        'payment_no' => $payment->payment_no,
                        'account_id' => $payment->accounts->name,
                        $date = $payment->date ? new Carbon($payment->date) : null,
                        'date' => $date->format('M d, Y'),
                        'description' => $payment->description,
                        'payee' => $payment->payee,
                        'cheque' => $payment->cheque,
                        'amount' => $payment->amount,
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function expenses_create()
    {
        // $group_first = \App\Models\AccountGroup::all('id', 'name')->first();
        $group_first = \App\Models\AccountGroup::all()->where('company_id', session('company_id'))->map->only('id', 'name')->first();



        if ($group_first) {

            return Inertia::render('Payments/ECreate', [
                'group_first' => $group_first,
            ]);
        } else {
            return Redirect::route('accountgroups.create')->with('success', 'ACCOUNTGROUP NOT FOUND, Please create account group first.');
        }
    }

    public function expenses_store()
    {

        Request::validate([
            'name' => ['required'],

        ]);

        $account = Account::where('company_id', session('company_id'))->where('group_id', 17)->get()->last();
        Account::create([
            'name' => Request::input('name'),
            'number' => $account->number + 1,
            'group_id' => 17,
            'company_id' => session('company_id'),
        ]);

        return Redirect::route('payments.create')->with('success', 'Expenses Type Created.');
    }


    public function create()
    {
        $accounts = Account::where('company_id', session('company_id'))->where('group_id', 17)->orwhere('group_id', 8)->get();

        // dd($accounts); // $accounts = Account::all();
        if ($accounts->first()) {
            return Inertia::render('Payments/Create', [
                'accounts' => $accounts,
            ]);
        } else {
            return Redirect::route('accounts.create')->with('warning', 'ACCOUNT NOT FOUND, Please create Account first.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Req $request)
    {
        Request::validate([
            'account_id' => ['required'],
            'description' => ['required'],
            'amount' => ['required'],
        ]);

        DB::transaction(function () use ($request) {


            $date = new Carbon($request->date);
            $prefix = \App\Models\DocumentType::where('id', 1)->first()->prefix;
            $date = $date->format('Y-m-d');
            $ref_date_parts = explode("-", $date);
            $reference = $prefix . "/" . $ref_date_parts[0] . "/" . $ref_date_parts[1] . "/" . $ref_date_parts[2];
            //--End.
            Document::create([
                'type_id' => 1,
                'ref' => $reference,
                'date' => $date,
                'description' => $request->description,
                'year_id' => session('year_id'),
                'company_id' => session('company_id'),
            ]);

            $document = Document::all()->last();

            $payment = Payment::all()->last();
            if ($payment) {
                Payment::create([
                    'date' => $request->date,
                    'account_id' => $request->account_id['id'],
                    'description' => $request->description,
                    'document_id' => $document->id,
                    'payment_no' => $payment->payment_no + 1,
                    'payee' => $request->payee,
                    'cheque' => $request->cheque,
                    'amount' => $request->amount,
                    'h_tax' => $request->h_tax,
                ]);
            } else {
                Payment::create([
                    'date' => $request->date,
                    'account_id' => $request->account_id['id'],
                    'description' => $request->description,
                    'document_id' => $document->id,
                    'payment_no' => 440000001,
                    'payee' => $request->payee,
                    'cheque' => $request->cheque,
                    'amount' => $request->amount,
                    'h_tax' => $request->h_tax,
                ]);
            }
            //Refrence  Genrate

            // dd($request->total);
            Entry::create([
                'company_id' => session('company_id'),
                'account_id' => $request->account_id['id'],
                'year_id' => session('year_id'),
                'document_id' => $document->id,
                'debit' => $request->total,
                'credit' => 0,
            ]);
            if ($request->p_status == 0) {
                Entry::create([
                    'company_id' => session('company_id'),
                    'account_id' => 14,
                    'year_id' => session('year_id'),
                    'document_id' => $document->id,
                    'debit' => 0,
                    'credit' => $request->amount,
                ]);
            } else {
                Entry::create([
                    'company_id' => session('company_id'),
                    'account_id' => 13,
                    'year_id' => session('year_id'),
                    'document_id' => $document->id,
                    'debit' => 0,
                    'credit' => $request->amount,
                ]);
            }

            if ($request->t_status != 0) {
                Entry::create([
                    'company_id' => session('company_id'),
                    'account_id' => 19,
                    'year_id' => session('year_id'),
                    'document_id' => $document->id,
                    'debit' => 0,
                    'credit' => $request->h_tax,
                ]);
            }
        });
        return Redirect::route('payments')->with('success', 'Payment Voucher Created');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        $accounts = Account::where('company_id', session('company_id'))->where('group_id', 17)->orwhere('group_id', 8)->get();
        return Inertia::render('Payments/Edit', [
            'accounts' => $accounts,
            'account' => Account::where('id', $payment->account_id)->first(),
            'payment' => [
                'id' => $payment->id,
                'document_id' => $payment->document_id,
                'date' => $payment->date,
                'payee' => $payment->payee,
                'account_id' => $payment->account_id,
                'description' => $payment->description,
                'cheque' => $payment->cheque,
                'amount' => $payment->amount,
                'h_tax' => $payment->h_tax,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Payment $payment, Req $request)
    {

        Request::validate([
            'amount' => ['required'],
        ]);
        $document = Document::where('id', $request->document_id)->get()->first();
        $entries = Entry::where('document_id', $request->document_id)->get();

        DB::transaction(function () use ($request, $payment, $document, $entries) {
            $payment->date = $request->date;
            $payment->payee = $request->payee;
            $payment->account_id = $request->account_id['id'];
            $payment->description = $request->description;
            $payment->cheque = $request->cheque;
            $payment->amount = $request->amount;
            $payment->h_tax = $request->h_tax;
            $payment->save();

            $date = new Carbon($request->date);
            $prefix = \App\Models\DocumentType::where('id', 1)->first()->prefix;
            $date = $date->format('Y-m-d');
            $ref_date_parts = explode("-", $date);
            $reference = $prefix . "/" . $ref_date_parts[0] . "/" . $ref_date_parts[1] . "/" . $ref_date_parts[2];
            // --End .
            $document->ref = $reference;
            $document->description = $request->description;
            $document->save();


            if ($request->h_tax == 0) {
                $entries[0]->account_id = $request->account_id['id'];
                $entries[0]->debit = $request->amount;
                $entries[1]->credit = $request->amount;
                $entries[0]->save();
                $entries[1]->save();
            } else {
                $entries[0]->account_id = $request->account_id['id'];
                $entries[0]->debit = $request->total;
                $entries[1]->credit = $request->amount;
                $entries[2]->credit = $request->h_tax;
                $entries[0]->save();
                $entries[1]->save();
                $entries[2]->save();
            }
        });

        return Redirect::route('payments')->with('success', 'Payment Voucher updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
