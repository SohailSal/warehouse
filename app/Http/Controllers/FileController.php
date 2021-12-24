<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use Illuminate\Http\Request as Req;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App;
use Carbon\Carbon;
use App\Models\Company;
use App\Models\File;
use App\Models\Agent;
use App\Models\Importer;
use App\Models\Client;
use App\Models\Invoice;

class FileController extends Controller
{

    public function index()
    {

        $importer = Importer::first();
        // $client = Client::first();
        // $agent = Agent::first();

        if ($importer) {
            
            //Validating request
            request()->validate([
                'direction' => ['in:asc,desc'],
                'field' => ['in:name,email']
            ]);

            //Searching request
            $query = File::query();

            if (request('search')) {
                $query->where('file_no', 'LIKE', '%' . request('search') . '%');
            }

            //Ordering request
            if (request()->has(['field', 'direction'])) {
                $query->orderBy(
                    request('field'),
                    request('direction')
                );
            }

            return Inertia::render('Files/Index', [
                'companies' => Company::all(),
                'balances' => $query->paginate(12)
                ->through(
                    fn ($file) =>
                    [
                        'id' => $file->id,
                        'file_no' => $file->file_no,
                        'file_code' => $file->file_code,
                        'gd_no' => $file->gd_no,
                        'bond_no' => $file->bond_no,
                        'date_bond' => $file->date_bond,
                        'description' => $file->description,
                        'vessel' => $file->vessel,
                        'gross_wt' => $file->gross_wt,
                        'net_wt' => $file->net_wt,
                        'bl_no' => $file->bl_no,
                        'vir_no' => $file->vir_no,
                        'index_no' => $file->index_no,
                        'insurance' => $file->insurance,
                        'lc_no' => $file->lc_no,
                        'amount' => $file->amount,
                        's_tax' => $file->s_tax,
                        'qty' => $file->qty,
                        'importer' => $file->importers ? $file->importers->name : null,
                        'client' => $file->clients ? $file->clients->name : null,
                        'agent' => $file->agents ? $file->agents->name : null,
                        'delete' => Invoice::where('file_id', $file->id)->first() ? false : true,
                    ],
                ),
                'filters' => request()->all(['search', 'field', 'direction'])
            ]);
        } else {
            // if($importer){
            //     if($client){
            //         return Redirect::route('agents.create')->with('warning', 'Agent not found please create an Agent.');
            //     }else{
            //         return Redirect::route('clients.create')->with('warning', 'Client not found please create an Client.');
            //     }
            // }else{
            return Redirect::route('importers.create')->with('warning', 'Importer not found please create an Importer.');
            // }
        }
    }

    public function create()
    {
        return Inertia::render('Files/Create', [
            'agents' => Agent::all(),
            'importers' => Importer::all(),
            'clients' => Client::all(),
        ]);
    }

    public function store()
    {

        // dd(Request::input('file_code'));
        // dd(Request::input('vir_no'));
        // dd(Request::input('index_no'));
        // dd(Request::input('lc_no'));
        // dd(Request::input('amount'));
        // dd(Request::input('s_tax'));
        // dd(Request::input('qty'));
        Request::validate([
            'file_no' => ['required', 'unique:files', 'max:255'],
            'importer_id' => ['required'],
        ]);

        $file = File::create([
            'file_no' => Request::input('file_no'),
            'file_code' => Request::input('file_code'),
            'gd_no' => Request::input('gd_no'),
            'bond_no' => Request::input('bond_no'),
            'date_bond' => Request::input('date_bond'),
            'description' => Request::input('description'),
            'vessel' => Request::input('vessel'),
            'gross_wt' => Request::input('gross_wt'),
            'net_wt' => Request::input('net_wt'),
            'bl_no' => Request::input('bl_no'),
            'vir_no' => Request::input('vir_no'),
            'index_no' => Request::input('index_no'),

            'insurance' => Request::input('insurance'),
            'lc_no' => Request::input('lc_no'),
            'amount' => Request::input('amount'),
            's_tax' => Request::input('s_tax'),
            'qty' => Request::input('qty'),


            // 'lc_no' => Request::input('lc_no'),
            // 'amount' => Request::input('amount'),
            // 's_tax' => Request::input('s_tax'),
            // 'qty' => Request::input('qty'),
            'agent_id' => Request::input('agent_id') ? Request::input('agent_id')['id'] : null,
            'importer_id' => Request::input('importer_id') ? Request::input('importer_id')['id'] : null,
            'client_id' => Request::input('client_id') ? Request::input('client_id')['id'] : null,
        ]);

        return Redirect::route('files')->with('success', 'File created');
    }

    public function edit(File $file)
    {
        return Inertia::render('Files/Edit', [
            'file' => [
                'id' => $file->id,
                'file_no' => $file->file_no,
                'file_code' => $file->file_code,
                'gd_no' => $file->gd_no,
                'bond_no' => $file->bond_no,
                'date_bond' => $file->date_bond,
                'description' => $file->description,
                'vessel' => $file->vessel,
                'gross_wt' => $file->gross_wt,
                'net_wt' => $file->net_wt,
                'bl_no' => $file->bl_no,
                'vir_no' => $file->vir_no,
                'index_no' => $file->index_no,
                'insurance' => $file->insurance,
                'lc_no' => $file->lc_no,
                'amount' => $file->amount,
                's_tax' => $file->s_tax,
                'qty' => $file->qty,
                'agent_id' => $file->agent_id,
                'importer_id' => $file->importer_id,
                'client_id' => $file->client_id,
            ],
            'agent' => Agent::where('id', $file->agent_id)->first(),
            'importer' => Importer::where('id', $file->importer_id)->first(),
            'client' => Client::where('id', $file->client_id)->first(),
            'agents' => Agent::all(),
            'importers' => Importer::all(),
            'clients' => Client::all(),
        ]);
    }

    public function update(File $file)
    {
        Request::validate([
            'file_no' => ['required', 'max:255'],
            'importer_id' => ['required'],
        ]);


        $file->file_no = Request::input('file_no');
        $file->file_code = Request::input('file_code');
        $file->gd_no = Request::input('gd_no');
        $file->bond_no = Request::input('bond_no');
        $file->date_bond = Request::input('date_bond');
        $file->description = Request::input('description');
        $file->vessel = Request::input('vessel');
        $file->gross_wt = Request::input('gross_wt');
        $file->net_wt = Request::input('net_wt');
        $file->bl_no = Request::input('bl_no');

        $file->vir_no = Request::input('vir_no');
        $file->index_no = Request::input('index_no');

        $file->insurance = Request::input('insurance');

        $file->lc_no = Request::input('lc_no');
        $file->amount = Request::input('amount');
        $file->s_tax = Request::input('s_tax');
        $file->qty = Request::input('qty');

        $file->agent_id = Request::input('agent_id') ? Request::input('agent_id')['id'] : null;
        $file->importer_id = Request::input('importer_id') ? Request::input('importer_id')['id'] : null;
        $file->client_id = Request::input('client_id') ? Request::input('client_id')['id'] : null;

        $file->save();

        return Redirect::route('files')->with('success', 'File updated.');
    }

    public function destroy(File $file)
    {
        $file->delete();
        return Redirect::back()->with('success', 'File deleted.');
    }
}
