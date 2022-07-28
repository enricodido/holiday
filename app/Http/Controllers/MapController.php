<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poi;

class MapController extends Controller
{
    public function pois()
    {
        $pois = Poi::query()->orderBy('name','asc')->get();
        return $pois;
    }

    public function index()
    {
        
        $positions = Poi::query()->orderBy('name','asc')->get();

        return view('company.map.index', compact('positions'));
    }

}
