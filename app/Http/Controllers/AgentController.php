<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

use App\Models\Company;
use App\Models\Agent;
use App\Models\File;


class AgentController extends Controller
{

    public function index()
    {
        //Validating request
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:name']
        ]);

        // Client data query
        $query = Agent::paginate(6)
            ->withQueryString()
            ->through(
                fn ($agent) =>
                [
                    'id' => $agent->id,
                    'name' => $agent->name,
                    'delete' => File::where('agent_id', $agent->id)->first() ? false : true,
                ],
            );


        //Searching request
        $query = Agent::query();
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

        return Inertia::render('Agents/Index', [
            'companies' => Company::all(),
            'agent' => Agent::first(),
            'balances' => $query->paginate(12),
            'filters' => request()->all(['search', 'field', 'direction'])
        ]);
    }

    public function create()
    {
        return Inertia::render('Agents/Create');
    }

    public function store()
    {
        Request::validate([
            'name' => ['required', 'unique:agents', 'max:255'],

        ]);
        $agent = Agent::create([
            'name' => strtoupper(Request::input('name')),
        ]);

        return Redirect::route('agents')->with('success', 'Agent created');
    }

    public function edit(Agent $agent)
    {
        return Inertia::render('Agents/Edit', [
            'agent' => [
                'id' => $agent->id,
                'name' => $agent->name,
            ],
        ]);
    }

    public function update(Agent $agent)
    {
        Request::validate([
            'name' => ['required', 'max:255'],
        ]);

        $agent->name = strtoupper(Request::input('name'));

        $agent->save();

        return Redirect::route('agents')->with('success', 'Agent updated.');
    }

    public function destroy(Agent $agent)
    {
        $agent->delete();
        return Redirect::back()->with('success', 'Agent deleted.');
    }
}
