<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as Req;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Account;
use App\Models\Company;
use App\Models\Year;
use App\Models\Entry;
use Inertia\Inertia;
use Carbon\Carbon;
use Exception;
use PhpParser\Comment\Doc;

class DocumentController extends Controller
{
    public function index()
    {

        //Validating request
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:name,email']
        ]);

        $acc = Account::where('company_id', session('company_id'))->first();
        $doc_ty = DocumentType::where('company_id', session('company_id'))->first();
        if ($acc && $doc_ty) {

            //Searching request
            $query = Document::query();
            $query = Document::all()
                ->where('company_id', session('company_id'))
                // ->where('year_id', session('year_id'))
                ->map(function ($document) {

                    $date = new Carbon($document->date);

                    return [
                        'id' => $document->id,
                        'ref' => $document->ref,
                        'date' => $date->format('M d, Y'),
                        'description' => $document->description,
                        'type_id' => $document->type_id,
                        'company_id' => session('company_id'),
                        // 'year_id' => session('year_id'),
                        'delete' => Entry::where('document_id', $document->id)->first() ? false : true,
                    ];
                });

            $query = Document::query();

            $query
                ->where('company_id', session('company_id'))
                // ->where('year_id', session('year_id'))
                ->paginate(6)
                ->withQueryString()
                ->through(
                    fn ($document) =>
                    [
                        'id' => $document->id,
                        'ref' => $document->ref,

                        $date = new Carbon($document->date),
                        'date' => $date->format('M d, Y'),
                        'description' => $document->description,
                        'type_id' => $document->type_id,
                        'company_id' => session('company_id'),
                        'year_id' => session('year_id'),
                        'delete' => Entry::where('document_id', $document->id)->first() ? false : true,
                    ]
                );
            if (request('search')) {
                $query->where('description', 'LIKE', '%' . request('search') . '%');
            }
            //Ordering request
            if (request()->has(['field', 'direction'])) {
                $query->orderBy(
                    request('field'),
                    request('direction')
                );
            }
            
            return Inertia::render(
                'Documents/Index',
                [
                    'data' => $query->paginate(6),
                    'filters' => request()->all(['search', 'field', 'direction']),
                    // 'data' => Document::all()
                    //     ->where('company_id', session('company_id'))
                    //     ->where('year_id', session('year_id'))
                    //     ->map(function ($document) {

                    //         $date = new Carbon($document->date);

                    //         return [
                    //             'id' => $document->id,
                    //             'ref' => $document->ref,
                    //             'date' => $date->format('M d, Y'),
                    //             'description' => $document->description,
                    //             'type_id' => $document->type_id,
                    //             'company_id' => session('company_id'),
                    //             'year_id' => session('year_id'),
                    //             'delete' => Entry::where('document_id', $document->id)->first() ? false : true,
                    //         ];
                    //     }),

                    'companies' => Company::all()
                        ->map(function ($com) {
                            return [
                                'id' => $com->id,
                                'name' => $com->name,
                            ];
                        }),

                    'years' => Year::all()
                        ->where('company_id', session('company_id'))
                        ->map(function ($year) {
                            $begin = new Carbon($year->begin);
                            $end = new Carbon($year->end);

                            return [
                                'id' => $year->id,
                                'name' => $begin->format('M d, Y') . ' - ' . $end->format('M d, Y'),
                            ];
                        }),
                ]
            );
        } elseif($acc) {
            return Redirect::route('documenttypes')->with('warning', 'VOUCHER NOT FOUND, Please create voucher first.');
        }else{
            return Redirect::route('accounts')->with('warning', 'ACCOUNT NOT FOUND, Please create an account first.');
        }
    }

    public function create()
    {
        $account_first = \App\Models\Account::all()->where('company_id', session('company_id'))->map->only('id', 'name')->first();
        $doc_type_first = \App\Models\DocumentType::all()->where('company_id', session('company_id'))->map->only('id', 'name')->first();
        // $accounts = \App\Models\Account::all()->where('company_id', session('company_id'))->map->only('id', 'name');
        $accounts = \App\Models\Account::where('company_id', session('company_id'))
        // ->map('id', 'name')
        ->get();
        
   
        if($account_first && $doc_type_first){

            return Inertia::render('Documents/Create', [
           
                'accounts' => $accounts,
                'account_first' => $account_first,
                'doc_type_first' => $doc_type_first,
                'doc_types' => DocumentType::where('company_id', session('company_id'))->get(),
                // 'doc_types' => DocumentType::all()->where('company_id', session('company_id')),
            ]);
        }else {
        if ($doc_type_first) {
            return Redirect::route('accounts.create')->with('success', 'ACCOUNTS NOT FOUND, Please create an account first');
        } else {
            return Redirect::route('documenttypes.create')->with('success', 'VOUCHER NOT FOUND, Please create a voucher first');
        }
    
    }
}

    public function store(Req $request)
    {
        Request::validate([
            'type_id' => ['required'],
            'description' => ['required'],
            'date' => ['required', 'date'],

            'entries.*.account_id' => ['required'],
            'entries.*.debit' => ['required'],
            'entries.*.credit' => ['required'],
        ]);

        DB::transaction(function () use ($request) {
            $date = new Carbon($request->date);
            try {

                $prefix = \App\Models\DocumentType::where('id', $request->type_id)->first()->prefix;
                $date = $date->format('Y-m-d');
                $ref_date_parts = explode("-", $date);
                $reference = $prefix . "/" . $ref_date_parts[0] . "/" . $ref_date_parts[1] . "/" . $ref_date_parts[2];
     
                $doc = Document::create([
                    'type_id' => Request::input('type_id')['id'],
                    'company_id' => session('company_id'),
                    'description' => Request::input('description'),
                    'ref' => $reference,
                    'date' => $date,
                    'year_id' => session('year_id'),
                ]);
                $data = $request->entries;
                foreach ($data as $entry) {
                    Entry::create([
                        'company_id' => $doc->company_id,
                        'account_id' => $entry['account_id']['id'],
                        'year_id' => $doc->year_id,
                        'document_id' => $doc->id,
                        'debit' => $entry['debit'],
                        'credit' => $entry['credit'],
                    ]);
                }
            } catch (Exception $e) {
                return $e;
            }
        });

        return Redirect::route('documents')->with('success', 'Transaction created.');
    }

    public function edit(Document $document)
    {
        // dd($document->id);
        $accounts = \App\Models\Account::all()->map->only('id', 'name');

        $doc_types = \App\Models\DocumentType::all()->map->only('id', 'name');
        // $doc_types = \App\Models\DocumentType::all()->map->only('id', 'name')->first();
        $doc = \App\Models\Document::all()->where('id', $document->id)->map->only('id', 'ref')->first();

        $ref = Entry::all()->where('document_id', $document->id);
        $entrie = \App\Models\Entry::all()->where('document_id', $document->id)->toArray();
        // $ref = Document::all()->where('document_id', $document->id);
        // // $entrie = Document::all()->where('document_id', $document->id);
        // $entrie = Document::all()->where('document_id', 1);
        // // ->toArray();

        // dd($entrie);
        $i = 0;
        foreach ($entrie as $entry) {
            $entries[$i] = $entry;
            $i++;
        }
        // dd($entries);

        // $document =
        //     // $document,
        //     [
        //         'id' => $document->id,
        //         'ref' => $document->ref,
        //         'date' => $document->date,
        //         'description' => $document->description,
        //         'type_id' => $document->type_id,
        //         'entries' => $document->entries,
        //     ];
        //     'accounts' => $accounts,
        //     'doc_types' => $doc_types,
        //     'entries' => $entries,
        // ]
        // dd($document);
        // $document = Document::all()->where('document_id', $document->id);
        return Inertia::render(
            'Documents/Edit',
            [
                'document' =>
                // $document,
                [
                    'id' => $document->id,
                    'ref' => $document->ref,
                    'date' => $document->date,
                    'description' => $document->description,
                    'type_id' => $document->type_id,
                    'type_name' => $document->documentType->name,
                    'entries' => $document->entries,
                ],
                'accounts' => $accounts,
                'doc_types' => $doc_types,
                'entriess' => $entries,
                // 'entries' => $entries,
            ]
        );
    }

    // public function update(Document $document)
    public function update(
        Req $request,
        Document $document
        // Entry $entry
    ) {
        // dd($request->entries);
        // dd($entry);
        // dd($document->id);

        Request::validate([
            'type_id' => ['required'],
            'description' => ['required'],
            'date' => ['required', 'date'],

            'entries.*.account_id' => ['required'],
            'entries.*.debit' => ['required'],
            'entries.*.credit' => ['required'],
        ]);

        $preEntries = Entry::all()->where('document_id', $document->id);


        DB::transaction(function () use ($request, $document, $preEntries) {
            $date = new Carbon($request->date);
            try {

                foreach ($preEntries as $preEntry) {
                    $preEntry->delete();
                }
                // $prefix = \App\Models\DocumentType::where('id', $request->type_id)->first()->prefix;
                // $date = $date->format('Y-m-d');
                // $ref_date_parts = explode("-", $date);
                // $reference = $prefix . "/" . $ref_date_parts[0] . "/" . $ref_date_parts[1] . "/" . $ref_date_parts[2];

                // $doc = Document::create([
                //     'type_id' => Request::input('type_id'),
                //     'company_id' => session('company_id'),
                //     'description' => Request::input('description'),
                //     'ref' => $reference,
                //     'date' => $date,
                //     'year_id' => session('year_id'),
                // ]);
                $date = new carbon(Request::input('date'));

                $document->description = Request::input('description');
                $document->date = $date->format('Y-m-d');

                $document->save();

                $data = $request->entries;
                foreach ($data as $entry) {
                    Entry::create([
                        // 'company_id' => $document->company_id,
                        'company_id' => session('company_id'),
                        'account_id' => $entry['account_id'],
                        'year_id' => session('year_id'),
                        // 'year_id' => $document->year_id,
                        'document_id' => $document->id,
                        'debit' => $entry['debit'],
                        'credit' => $entry['credit'],
                    ]);
                }
            } catch (Exception $e) {
                return $e;
            }
        });

        // dd($request->entries);
        // dd(Request::input('ref'));
        // dd($document->type_id);


        // $data = $request->entries;
        // foreach ($data as $entry) {
        // Entry::create([
        // 'company_id' => $doc->company_id,
        // 'year_id' => $doc->year_id,
        // 'document_id' => $doc->id,

        // $entry->account_id = $entry->account_id;
        // $entry->debit = $entry->debit;
        // $entry->credit = $entry->credit;

        // $entry->save;

        // 'account_id' => $entry['account_id'],
        // 'debit' => $entry['debit'],
        // 'credit' => $entry['credit'],
        // ]);
        // }

        return Redirect::route('documents')->with('success', 'Transaction updated.');
    }


    public function destroy(Document $document)
    {
        $document->delete();
        return Redirect::back()->with('success', 'Transaction deleted.');
    }
}
