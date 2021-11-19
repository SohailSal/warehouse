<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as Req;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Models\Receipt;
use App\Models\Company;
use App\Models\Entry;
use App\Models\Document;
use Inertia\Inertia;

class ReceiptController extends Controller
{
    public function index()
    {


        return Inertia::render('Receipts/Index', [

            'data' => Receipt::all()
                ->map(function ($receipt) {
                    return [
                        'id' => $receipt->id,
                        'file_id' => $receipt->files->file_no,
                        'date' => $receipt->date,
                        'amount' => $receipt->amount,
                        'i_tax' => $receipt->i_tax,
                        's_tax' => $receipt->s_tax,
                        'com' => $receipt->com,
                        'total' => $receipt->amount + $receipt->i_tax . '.00',
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

        $invoice = \App\Models\File::all()->map(function ($file) {
            $bal = Entry::where('account_id', $file->importers->accounts->id)->get();
            $debit = 0;
            $credit = 0;
            foreach ($bal as $item) {
                $debit += $item->debit;
                $credit += $item->credit;
            }
            $res = $debit - $credit;
            return
                [
                    'id' => $file->id,
                    'file_no' => $file->importers->name . ' - Rs. ' . $res,
                    'account_id' => $file->importers->accounts->id,
                    'res' => $res,
                ];
        });
        $files = null;
        $i = 0;
        foreach ($invoice as $item) {
            if ($item['res'] != 0) {
                $files[$i] = $item;
                $i++;
            }
        }
        if ($invoice->first()) {
            if ($files != null) {
                return Inertia::render('Receipts/Create', [
                    'files' => $files,
                ]);
            } else {
                return Redirect::route('invoices.create')->with('success', 'Invoice Not Found, Please create Invoice first.');
            }
        } else {
            return Redirect::route('files.create')->with('warning', 'File NOT FOUND, Please create File first.');
        }
    }

    public function store(Req $request)
    {

        Request::validate([
            'file_id' => ['required'],
            'date' => ['required'],
            'amount' => ['required'],
        ]);

        DB::transaction(function () use ($request) {

            Receipt::create([
                'file_id' => Request::input('file_id')['id'],
                'date' => Request::input('date'),
                'amount' => Request::input('amount'),
                'i_tax' => Request::input('i_tax'),
                's_tax' => Request::input('s_tax'),
                'com' => Request::input('com'),
            ]);


            //Refrence  Genrate
            $date = new Carbon($request->date);
            $prefix = \App\Models\DocumentType::where('id', 4)->first()->prefix;
            $date = $date->format('Y-m-d');
            $ref_date_parts = explode("-", $date);
            $reference = $prefix . "/" . $ref_date_parts[0] . "/" . $ref_date_parts[1] . "/" . $ref_date_parts[2];
            //--End.
            Document::create([
                'type_id' => 4,
                'ref' => $reference,
                'date' => $date,
                'description' => 'Invoice to ' . $request->file_id['file_no'],
                'year_id' => session('year_id'),
                'company_id' => session('company_id'),
            ]);
            $document = Document::all()->last();
            // dd($request->);
            Entry::create([
                'company_id' => session('company_id'),
                'account_id' => $request->file_id['account_id'],
                'year_id' => session('year_id'),
                'document_id' => $document->id,
                'debit' => 0,
                'credit' => $request->total,
            ]);


            Entry::create([
                'company_id' => session('company_id'),
                'account_id' => 13,
                'year_id' => session('year_id'),
                'document_id' => $document->id,
                'debit' => $request->amount,
                'credit' => 0,
            ]);

            if ($request->i_tax != 0) {

                Entry::create([
                    'company_id' => session('company_id'),
                    'account_id' => 34,
                    'year_id' => session('year_id'),
                    'document_id' => $document->id,
                    'debit' => $request->i_tax,
                    'credit' => 0,
                ]);
            }
        });
        return Redirect::route('receipts')->with('success', 'Receipt created.');
    }


    public function edit(Receipt $receipt)
    {
        // dd($receipt);

        return Inertia::render('Receipts/Edit', [
            'receipt' => [
                'id' => $receipt->id,
                'date' => $receipt->date,
                'amount' => $receipt->amount,
                'i_tax' => $receipt->i_tax,
                's_tax' => $receipt->s_tax,
                'com' => $receipt->com,
            ],
        ]);
    }

    public function update(Receipt $receipt)
    {
        Request::validate([
            'amount' => ['required'],
        ]);

        $receipt->date = Request::input('date');
        $receipt->amount = Request::input('amount');
        $receipt->i_tax = Request::input('i_tax');
        $receipt->s_tax = Request::input('s_tax');
        $receipt->com = Request::input('com');
        $receipt->save();
        return Redirect::route('receipts')->with('success', 'Receipt updated.');
    }

    public function destroy(Receipt $receipt)
    {
        $receipt->delete();
        return Redirect::back()->with('success', 'Receipt deleted.');
    }
}
