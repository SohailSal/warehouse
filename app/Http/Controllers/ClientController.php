<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

use App\Models\Company;
use App\Models\Client;


class ClientController extends Controller
{

    public function index()
    {
        //Validating request
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:name,email']
        ]);

        // Client data query
        $query = Client::paginate(6)
            ->withQueryString()
            ->through(
                fn ($client) =>
                [
                    'id' => $client->id,
                    'name' => $client->name,
                    'email' => $client->email,
                    'address' => $client->address,
                    'phone_no' => $client->phone_no,
                    'ntn_no' => $client->ntn_no,
                ],
            );


        //Searching request
        $query = Client::query();
        if (request('search')) {
            $query->where('name', 'LIKE', '%' . request('search') . '%');
        }
        //Ordering request
        if (request()->has(['field', 'direction'])) {
            $query->orderBy(
                request('field'),
                request('direction')
            );
        }

        return Inertia::render('Clients/Index', [
            'companies' => Company::all(),
            'client' => Client::first(),
            'balances' => $query->paginate(12),
            'filters' => request()->all(['search', 'field', 'direction'])
        ]);
    }

    public function create()
    {
        return Inertia::render('Clients/Create');
    }

    public function store()
    {
        Request::validate([
            'name' => ['required', 'unique:clients', 'max:255'],
            'email' => ['required', 'email', 'unique:clients,email'],
        ]);
        $client = Client::create([
            'name' => strtoupper(Request::input('name')),
            'email' => Request::input('email'),
            'address' => Request::input('address'),
            'phone_no' => Request::input('phone_no'),
            'ntn_no' => Request::input('ntn_no'),
        ]);

        return Redirect::route('clients')->with('success', 'Client created');
    }

    public function edit(Client $client)
    {
        return Inertia::render('Clients/Edit', [
            'client' => [
                'id' => $client->id,
                'name' => $client->name,
                'email' => $client->email,
                'address' => $client->address,
                'phone_no' => $client->phone_no,
                'ntn_no' => $client->ntn_no,
            ],
        ]);
    }

    public function update(Client $client)
    {
        Request::validate([

            'name' => ['required', 'unique:clients', 'max:255'],
            'email' => ['required', 'email', 'unique:clients,email'],
            'address' => ['nullable'],
            'phone_no' => ['nullable'],
            'ntn_no' => ['nullable'],
        ]);

        $client->name = strtoupper(Request::input('name'));
        $client->email = Request::input('email');
        $client->address = Request::input('address');
        $client->phone_no = Request::input('phone_no');
        $client->ntn_no = Request::input('ntn_no');

        $client->save();

        return Redirect::route('clients')->with('success', 'Client updated.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return Redirect::back()->with('success', 'Client deleted.');
    }
}
