<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    //
    public function index()
    {
        $data = User::all();
        return Inertia::render('Users/Index', ['data' => $data]);
    }
}
