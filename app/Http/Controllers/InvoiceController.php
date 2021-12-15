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
use App\Models\Quantity;

use function PHPSTORM_META\map;

class InvoiceController extends Controller
{
    public function index()
    {
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:file_id']
        ]);

        $query = Invoice::query();


        if (request('searche')) {
            // $query->where('file_id', 'LIKE', '%' . request('search') . '%');
            $query->join('files', 'files.id', '=', 'file_id')
                ->select('invoices.*')
                ->where('files.file_no', 'LIKE', '%' . request('searche') . '%');
        }

        if (request('search')) {
            $query->where('invoice_no', 'LIKE', '%' . request('search') . '%');
        }

        if (request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        } else {
            $query->orderBy(('invoices.file_id'), ('asc'));
        }

        return Inertia::render('Invoices/Index', [
            'filters' => request()->all([
                'search', 'searche'
                //  'field', 'direction'
            ]),
            // $balances = $query->paginate(10)
            'balances' => $query->paginate(10)
                ->through(function ($invoice) {
                    return [
                        'id' => $invoice->id,
                        'file_id' => $invoice->files->file_no,
                        'invoice_no' => $invoice->invoice_no,
                        $date = $invoice->date ? new Carbon($invoice->date) : null,
                        'date' => $date->format('M d, Y'),
                        'amount' => $invoice->amount,
                        's_tax' => $invoice->s_tax,
                        'total' => $invoice->amount + $invoice->s_tax . '.00',

                    ];
                }),
            // dd($balances),

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

            $invoice = Invoice::all()->last();
            if ($invoice) {
                Invoice::create([
                    'file_id' => Request::input('file_id')['id'],
                    'invoice_no' => $invoice->invoice_no + 1,
                    'date' => Request::input('date'),
                    'amount' => Request::input('amount'),
                    'document_id' => $document->id,
                    'tax_status' => Request::input('tax_status'),
                    'document_id' => $document->id,
                    's_tax' => Request::input('s_tax'),
                ]);
            } else {
                Invoice::create([
                    'file_id' => Request::input('file_id')['id'],
                    'invoice_no' => 220000001,
                    'date' => Request::input('date'),
                    'amount' => Request::input('amount'),
                    'tax_status' => Request::input('tax_status'),
                    'document_id' => $document->id,
                    's_tax' => Request::input('s_tax'),
                ]);
            }
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
                    'account_id' => 22,
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
                'file_id' => $invoice->file_id,
                'tax_status' => $invoice->tax_status,
                'amount' => $invoice->amount,
                's_tax' => $invoice->s_tax,
                'document_id' => $invoice->document_id,
                'total' => $invoice->amount + $invoice->s_tax . '.00',

            ],
        ]);
    }

    public function update(Invoice $invoice, Req $request)
    {
        // dd($request);
        Request::validate([
            'amount' => ['required'],
        ]);
        $document = Document::where('id', $request->document_id)->get()->first();
        $entries = Entry::where('document_id', $request->document_id)->get();
        $file = File::where('id', $request->file_id)->get()->first();
        DB::transaction(function () use ($request, $invoice, $document, $entries, $file) {

            $invoice->date = $request->date;
            $invoice->tax_status = $request->tax_status;
            $invoice->amount = $request->amount;
            $invoice->s_tax = $request->s_tax;
            $invoice->save();

            $date = new Carbon($request->date);
            $prefix = \App\Models\DocumentType::where('id', 4)->first()->prefix;
            $date = $date->format('Y-m-d');
            $ref_date_parts = explode("-", $date);
            $reference = $prefix . "/" . $ref_date_parts[0] . "/" . $ref_date_parts[1] . "/" . $ref_date_parts[2];
            //--End.
            $document->ref = $reference;
            $document->date = $request->date;
            $document->description = 'Invoice to ' . $file->importers->name;
            $document->save();

            // dd($request);
            if ($request->tax_status == 2) {
                // $entries[0]->account_id = $request->file_id['account_id'];
                $entries[0]->debit = $request->amount;
                $entries[1]->credit = $request->amount;
                $entries[2]->delete();
                $entries[0]->save();
                $entries[1]->save();
            } else {
                // $entries[0]->account_id = $request->file_id['account_id'];
                $entries[0]->debit = $request->total;
                $entries[1]->credit = $request->amount;
                if (count($entries) == 2) {
                    Entry::create([
                        'company_id' => session('company_id'),
                        'account_id' => 22,
                        'year_id' => session('year_id'),
                        'document_id' => $document->id,
                        'debit' => 0,
                        'credit' => $request->s_tax,
                    ]);
                } else {
                    $entries[2]->credit = $request->s_tax;
                    $entries[2]->save();
                }
                $entries[0]->save();
                $entries[1]->save();
            }
        });


        // $invoice->date = Request::input('date');
        // $invoice->amount = Request::input('amount');
        // $invoice->save();

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

                //Total Qty Receive
                $quantity = Quantity::where('file_id', $invoice->files->id)->get();
                $quanty = 0;
                foreach ($quantity as $qtyy) {
                    $quanty += $qtyy->qty;
                }

                return [
                    'id' => $invoice->id,
                    'file_no' => $invoice->files->file_no,
                    'invoice_no' => $invoice->invoice_no,
                    'description' => $invoice->files->description,
                    'amount' => $invoice->amount,
                    'qty' => $quanty,
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
