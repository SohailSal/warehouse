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
use App\Models\Invoice;
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
                        'receipt_no' => $receipt->receipt_no,
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
                'description' => 'Receipt to ' . $request->file_id['file_no'],
                'year_id' => session('year_id'),
                'company_id' => session('company_id'),
            ]);

            $document = Document::all()->last();
            $receipt = Receipt::all()->last();
            if ($receipt)
                Receipt::create([
                    'file_id' => Request::input('file_id')['id'],
                    'receipt_no' => $receipt->receipt_no + 1,
                    'date' => Request::input('date'),
                    'document_id' => $document->id,
                    'tax_status' => Request::input('tax_status'),
                    'amount' => Request::input('amount'),
                    'i_tax' => Request::input('i_tax'),
                    's_tax' => Request::input('s_tax'),
                    'com' => Request::input('com'),
                ]);
            else {
                Receipt::create([
                    'file_id' => Request::input('file_id')['id'],
                    'receipt_no' => 330000001,
                    'date' => Request::input('date'),
                    'document_id' => $document->id,
                    'tax_status' => Request::input('tax_status'),
                    'amount' => Request::input('amount'),
                    'i_tax' => Request::input('i_tax'),
                    's_tax' => Request::input('s_tax'),
                    'com' => Request::input('com'),
                ]);
            }

            //Refrence  Genrate

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
                    'account_id' => 18,
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

        $files = \App\Models\File::all()->map(function ($file) {
            return
                [
                    'id' => $file->id,
                    'file_no' => $file->importers->name,
                    'account_id' => $file->importers->accounts->id,
                ];
        })->first();
        return Inertia::render('Receipts/Edit', [
            'receipt' => [
                'files' => $files,
                'id' => $receipt->id,
                'date' => $receipt->date,
                'document_id' => $receipt->document_id,
                'tax_status' => $receipt->tax_status,
                'file_id' => $receipt->file_id,
                'amount' => $receipt->amount,
                'i_tax' => $receipt->i_tax,
                's_tax' => $receipt->s_tax,
                'com' => $receipt->com,
                'total' => $receipt->amount + $receipt->i_tax,
            ],
        ]);
    }

    public function update(Receipt $receipt, Req $request)
    {


        Request::validate([
            'file_id' => ['required'],
            'date' => ['required'],
            'amount' => ['required'],
        ]);
        $document = Document::where('id', $request->document_id)->get()->first();
        $entries = Entry::where('document_id', $request->document_id)->get();
        DB::transaction(function () use ($request, $receipt, $document, $entries) {

            $receipt->date = $request->date;
            $receipt->tax_status = $request->tax_status;
            $receipt->amount = $request->amount;
            $receipt->i_tax = $request->i_tax;
            $receipt->com = $request->com;
            $receipt->save();

            $date = new Carbon($request->date);
            $prefix = \App\Models\DocumentType::where('id', 4)->first()->prefix;
            $date = $date->format('Y-m-d');
            $ref_date_parts = explode("-", $date);
            $reference = $prefix . "/" . $ref_date_parts[0] . "/" . $ref_date_parts[1] . "/" . $ref_date_parts[2];
            //--End.
            $document->ref = $reference;
            $document->date = $request->date;
            $document->description = 'Invoice to ' . $request->file_id['file_no'];
            $document->save();

            // dd($request);
            if ($request->tax_status == 2) {
                // $entries[0]->account_id = $request->file_id['account_id'];
                $entries[0]->credit = $request->amount;
                $entries[1]->debit = $request->amount;
                $entries[2]->delete();
                $entries[0]->save();
                $entries[1]->save();
            } else {
                // $entries[0]->account_id = $request->file_id['account_id'];
                $entries[0]->credit = $request->total;
                $entries[1]->debit = $request->amount;
                if (count($entries) == 2) {
                    Entry::create([
                        'company_id' => session('company_id'),
                        'account_id' => 18,
                        'year_id' => session('year_id'),
                        'document_id' => $document->id,
                        'debit' => $request->i_tax,
                        'credit' => 0,
                    ]);
                } else {
                    $entries[2]->debit = $request->i_tax;
                    $entries[2]->save();
                }
                $entries[0]->save();
                $entries[1]->save();
            }
        });

        return Redirect::route('receipts')->with('success', 'Receipt updated.');
    }

    public function destroy(Receipt $receipt)
    {
        $receipt->delete();
        return Redirect::back()->with('success', 'Receipt deleted.');
    }
}
