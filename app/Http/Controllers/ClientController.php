<?php

namespace App\Http\Controllers;

use App\Models\Client;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::withCount('bookings')->get();
        return view('clients.index', compact('clients'));
    }
}