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
use App;

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
                        $date = $invoice->date ? new Carbon($invoice->date) : null,
                        'date' => $date->format('M d, Y'),
                        'amount' => $invoice->amount,
                        's_tax' => $invoice->s_tax,
                        'total' => $invoice->amount + $invoice->s_tax . '.00',

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

        // dd($request);

        DB::transaction(function () use ($request) {

            Invoice::create([
                'file_id' => Request::input('file_id')['id'],
                'date' => Request::input('date'),
                'amount' => Request::input('amount'),
                's_tax' => Request::input('s_tax'),
            ]);


            $file = File::where('id', $request->file_id['id'])->get()->first();
            $importer = Importer::where('id', $file->importer_id)->get()->first();

            //Refrence  Genrate
            $date = new Carbon($request->date);
            $prefix = \App\Models\DocumentType::where('id', 2)->first()->prefix;
            $date = $date->format('Y-m-d');
            $ref_date_parts = explode("-", $date);
            $reference = $prefix . "/" . $ref_date_parts[0] . "/" . $ref_date_parts[1] . "/" . $ref_date_parts[2];
            //--End.
            Document::create([
                'type_id' => 2,
                'ref' => $reference,
                'date' => $date,
                'description' => 'Invoice to ' . $importer->accounts->name,
                'year_id' => session('year_id'),
                'company_id' => session('company_id'),
            ]);



            $document = Document::all()->last();
            Entry::create([
                'company_id' => session('company_id'),
                'account_id' => $importer->account_id,
                'year_id' => session('year_id'),
                'document_id' => $document->id,
                'debit' => $request->total,
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

            if ($request->s_tax != 0) {

                Entry::create([
                    'company_id' => session('company_id'),
                    'account_id' => 20,
                    'year_id' => session('year_id'),
                    'document_id' => $document->id,
                    'debit' => 0,
                    'credit' => $request->s_tax,
                ]);
            }
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

    public function pdf($invoice)
    {
        $files = Invoice::where('id', $invoice)->get()
            ->map(function ($invoice) {

                $date = explode("-", $invoice->date);
                $startMonth = $date[1];
                $endMonth = $date[1] + 1;
                if ($endMonth == 13) {
                    $endMonth = 1;
                }

                $startMonthDays = $date[2];
                $endMonthDays = $date[2] - 1;

                if ($endMonthDays == 31) {
                    $endMonthDays = 1;
                }

                $startYear = $date[0];
                $endYear = 0;
                if ($startMonth < 12) {
                    $startYear =  $date[0];
                    $endYear = $date[0];
                } else {
                    $startYear = $endYear;
                    $endYear = $date[0] + 1;
                }


                $endDate = $endYear . '-'  . $endMonth . '-' . $endMonthDays;

                $date = new Carbon($invoice->date);
                $endDate = new Carbon($endDate);
                return [
                    'id' => $invoice->id,
                    'file_no' => $invoice->files->file_no,
                    'qty' => $invoice->files->qty,
                    'description' => $invoice->files->description,
                    'amount' => $invoice->amount,
                    's_tax' => $invoice->s_tax,
                    'date_bond' => $date->format('M d, Y'),
                    'end_date' => $endDate->format('M d, Y'),
                    'importer' => $invoice->files->importers->name,
                    'stn_no' => $invoice->files->importers->stn_no,
                    'agent' => $invoice->files->agents ? $invoice->files->agents->name : "",
                    'bond_no' => $invoice->files->bond_no,
                    'lc_no' => $invoice->files->lc_no,
                ];
            });

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('invoice', compact('files'));
        return $pdf->stream('v.pdf');
    }
}
