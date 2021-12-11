<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Entry;
use FontLib\Table\Type\name;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

use App;
use App\Models\Account;
use Illuminate\Http\Request as Req;
use Illuminate\Support\Facades\Auth;
use App\Models\Year;
use App\Models\Setting;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\User;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class LedgerController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {

        // $transaction = Document::where('company_id', session('company_id'))->where('year_id', session('year_id'))->first();
        // if($transaction){

        $account_first = null;
        $accounts = \App\Models\Account::where('company_id', session('company_id'))->get();
        if ($request->account_id) {
            $account_first = \App\Models\Account::all()->where('company_id', session('company_id'))->where('id', $request->account_id)->map->only('id', 'name')->first();
        }

        if ($request) {

            $start = new Carbon($request->input('date_start'));
            $end = new Carbon($request->input('date_end'));
            $account = $request->input('account_id');

            $start = $start->format('Y-m-d');
            $end = $end->format('Y-m-d');

            $data['start'] = $start;

            $data['entries'] = DB::table('documents')
                ->join('entries', 'documents.id', '=', 'entries.document_id')
                ->whereDate('documents.date', '>=', $start)
                ->whereDate('documents.date', '<=', $end)
                ->where('documents.company_id', session('company_id'))
                ->select('entries.account_id', 'entries.debit', 'entries.credit', 'documents.ref', 'documents.date', 'documents.description')
                ->where('entries.account_id', '=', $account)
                ->get();

            $data['previous'] = DB::table('documents')
                ->join('entries', 'documents.id', '=', 'entries.document_id')
                ->whereDate('documents.date', '<', $start)
                ->where('documents.company_id', session('company_id'))
                ->select('entries.debit', 'entries.credit')
                ->where('entries.account_id', '=', $account)
                ->get();

            $data['acc'] = Account::where('id', '=', $account)->where('company_id', session('company_id'))->first();
            // $data['period'] = "From " . strval($start) . " to " . strval($end);


            //----------------------------------------------- WORKING OF VUE ---------------------------------------------
            $prebal = 0;
            $data['lastbalance'] = 0;
            $ite = 0;
            $data['debits'] = 0;
            $data['credits'] = 0;
            if ($data['previous']->count()) {
                foreach ($data['previous'] as $value) {
                    $prebal = $data['lastbalance'] + floatval($value->debit) - floatval($value->credit);
                    $data['lastbalance'] = $prebal;
                    $ite++;
                }
            }
            $balance = [];
            $ite = 0;
            foreach ($data['entries'] as $value) {
                $balance[$ite] = $data['lastbalance'] + floatval($value->debit) - floatval($value->credit);
                $data['lastbalance'] = $balance[$ite];
                $ite++;
            }
        }

        foreach ($data['entries'] as $entry) {
            //     {{$entry->ref}}
            //     {{$entry->date}}
            //     {{$entry->description}}
            //     {{str_replace(['Rs.','.00'],'',$fmt->formatCurrency($entry->debit,'Rs.'))}}
            //     {{str_replace(['Rs.','.00'],'',$fmt->formatCurrency($entry->credit,'Rs.'))}}
            //     {{str_replace(['Rs.','.00'],'',$fmt->formatCurrency($balance[$loop->index],'Rs.'))}}

            $data['debits'] = $data['debits'] + $entry->debit;
            $data['credits'] = $data['credits'] + $entry->credit;
        }

        return Inertia::render('Ledgers/Index', [
            'companies' => Company::all(),
            'account_first' => $account_first,
            'accounts' => $accounts,

            'date_start' => $start,
            'date_end' => $end,
            'entries' => $data['entries'],
            'debits' => $data['debits'],
            'credits' => $data['credits'],
            'balance' => $balance,
            'prebal' => $prebal,
        ]);
    }

    public function getledger($id)

    {
        dd($id);
        if ($id) {
            $account_first = \App\Models\Account::all()->where('account_id', request('account_id'))->map->only('id', 'name')->first();
        } else {
            $account_first = \App\Models\Account::all()->where('company_id', session('company_id'))->map->only('id', 'name')->first();
        }

        $accounts = \App\Models\Account::all()->where('company_id', session('company_id'))->map->only('id', 'name');

        $entries = Entry::all()->where('company_id', session('company_id'))->where('account_id', $id)
            ->map(function ($entry) {
                return [
                    'ref' => $entry->document->ref,
                    'date' => $entry->document->date,
                    'description' => $entry->document->description,
                    'debit' => 'debit',
                    'credit' => 'credit',
                ];
            });

            return Inertia::render('Ledgers/Index', [
            'enteries' => $entries,
            // 'account_first' => $request->account_id,
            'companies' => Company::all(),
            'accounts' => $accounts,
        ]);
    }


    public function __invoke(Request $request)
    {
    }
}
