<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request as Req;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use App\Models\Company;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Entry;
use App\Models\Importer;
use Carbon\Carbon;
use \App\Models\File;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    public function index()
    {


        return Inertia::render('Invoices/Index', [

            'data' => Invoice::all()
                ->map(function ($invoice) {
                    return [
                        'id' => $invoice->id,
                        'file_id' => $invoice->files->file_no,
                        'date' => $invoice->date,
                        'amount' => $invoice->amount,
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

        $files = File::all();
        if ($files->first()) {
            return Inertia::render('Invoices/Create', [
                'files' => $files,
            ]);
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
            Invoice::create([
                'file_id' => Request::input('file_id')['id'],
                'date' => Request::input('date'),
                'amount' => Request::input('amount'),
                's_tax' => Request::input('s_tax'),
            ]);

            $file = File::where('id', $request->file_id['id'])->get()->first();
            $importer = Importer::where('id', $file->importer_id)->get()->first();
            // dd($importer->name);
            $date = new Carbon($request->date);
            $prefix = \App\Models\DocumentType::where('id', 2)->first()->prefix;
            $date = $date->format('Y-m-d');
            $ref_date_parts = explode("-", $date);
            $reference = $prefix . "/" . $ref_date_parts[0] . "/" . $ref_date_parts[1] . "/" . $ref_date_parts[2];
            Document::create([
                'type_id' => 2,
                'ref' => $reference,
                'date' => $date,
                'description' => 'Invoice to ' . $importer->accounts->name,
                'year_id' => session('year_id'),
                'company_id' => session('company_id'),
            ]);

            $total = $request->amount + $request->s_tax;
            // $file = File::where('id', $request->file_id['id'])->get()->first();
            // $importer = Importer::where('id', $file->importer_id)->get()->first();
            $document = Document::all()->last();
            Entry::create([
                'company_id' => session('company_id'),
                'account_id' => $importer->account_id,
                'year_id' => session('year_id'),
                'document_id' => $document->id,
                'debit' => $total,
                'credit' => 0,
            ]);


            Entry::create([
                'company_id' => session('company_id'),
                'account_id' => 17,
                'year_id' => session('year_id'),
                'document_id' => $document->id,
                'debit' => 0,
                'credit' => $request->amount,
            ]);

            Entry::create([
                'company_id' => session('company_id'),
                'account_id' => 20,
                'year_id' => session('year_id'),
                'document_id' => $document->id,
                'debit' => 0,
                'credit' => $request->s_tax,
            ]);
        });

        return Redirect::route('invoices')->with('success', 'Invoice created.');
    }

    // public function show(DocumentType $documenttype)
    // {
    // }

    public function edit(Invoice $invoice)
    {
        return Inertia::render('Invoices/Edit', [
            'invoice' => [
                'id' => $invoice->id,
                'date' => $invoice->date,
                'amount' => $invoice->amount,
            ],
        ]);
    }

    public function update(Invoice $invoice)
    {
        Request::validate([
            'amount' => ['required'],
        ]);

        $invoice->date = Request::input('date');
        $invoice->amount = Request::input('amount');
        $invoice->save();

        return Redirect::route('invoices')->with('success', 'Invoice updated.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return Redirect::back()->with('success', 'Invoice deleted.');
    }
}
