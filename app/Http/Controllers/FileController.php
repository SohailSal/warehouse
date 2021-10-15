<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

use App\Models\Company;
use App\Models\File;
use App\Models\Agent;
use App\Models\Importer;
use App\Models\Client;


class FileController extends Controller
{
    
    public function index()
    {

        $importer = Importer::first();
        // $client = Client::first();
        // $agent = Agent::first();

        if($importer){
        // if($importer && $client && $agent){
            //Validating request
            request()->validate([
                'direction' => ['in:asc,desc'],
                'field' => ['in:name,email']
            ]);

            // Client data query
            $query = File::paginate(6)
                ->withQueryString()
                ->through(
                    fn ($file) =>
                    [
                        'id' => $file->id,
                        'name' => $file->name,
                        'email' => $file->email,
                        'address' => $file->address,
                        'phone_no' => $file->phone_no,
                        'ntn_no' => $file->ntn_no,
                    ],
                );
        
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
                'file' => File::first(),
                'balances' => $query->paginate(12),
                'filters' => request()->all(['search', 'field', 'direction'])
            ]);
        }else{
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

        Request::validate([
            'file_no' => ['required'],
        ]);
            $file = File::create([
                // 'name' => strtoupper(Request::input('name')),
                'file_no' => Request::input('file_no'),
                'gd_no' => Request::input('gd_no'),
                'bond_no' => Request::input('bond_no'),
                'date_bond' => Request::input('date_bond'),
                'description' => Request::input('description'),
                'vessel' => Request::input('vessel'),
                'gross_wt' => Request::input('gross_wt'),
                'net_wt' => Request::input('net_wt'),
                'bl_no' => Request::input('bl_no'),
                'insurance' => Request::input('insurance'),
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
                'gd_no' => $file->gd_no,
                'bond_no' => $file->bond_no,
                'date_bond' => $file->date_bond,
                'description' => $file->description,
                'vessel' => $file->vessel,
                'gross_wt' => $file->gross_wt,
                'net_wt' => $file->net_wt,
                'bl_no' => $file->bl_no,
                'insurance' => $file->insurance,
                'agent_id' => $file->agent_id,
                'importer_id' => $file->importer_id,
                'client_id' => $file->client_id,
            ],
            'agents' => Agent::all(),
            'importers' => Importer::all(),
            'clients' => Client::all(),
        ]);
    }

    public function update(File $file)
    {
        Request::validate([
            'file_no' => ['required'],
        ]);

        
        $file->file_no = Request::input('file_no');
        $file->gd_no = Request::input('gd_no');    
        $file->bond_no = Request::input('bond_no');
        $file->date_bond = Request::input('date_bond');
        $file->description = Request::input('description');
        $file->vessel = Request::input('vessel');
        $file->gross_wt = Request::input('gross_wt');
        $file->net_wt = Request::input('net_wt');
        $file->bl_no = Request::input('bl_no');
        $file->insurance = Request::input('insurance');
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
