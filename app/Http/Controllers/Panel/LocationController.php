<?php

namespace App\Http\Controllers\Panel;

use App\Models\Location;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {

        return view('locations.index')->with([
            'locations' => Location::without('images')->get(),
        ]);
    }
}
