<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Poi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PoiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('company.poi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.poi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company = Auth::user()->company_id;

        $fields = [
            'company_id' => $company,
            'name' => $request->name,
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ];

        $poi= Poi::query()->create($fields);

        if($poi)
            flash('Operazione completata con successo')->success();
        else
            flash('Si è verificato un errore')->error();

        return redirect(route('company.poi.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $poi = Poi::find($id);
        return view('company.poi.show', compact('poi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $poi = Poi::find($id);

        $visible = ($request->has('visible')) ? true : false;

        $fields = [
            'name' => $request->name,
            'description' => $request->description,
            'visible' => $visible,
        ];

        $poi->update($fields);

        if($poi)
            flash('Operazione completata con successo')->success();
        else
            flash('Si è verificato un errore')->error();

        return redirect(route('company.poi.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete(Request $request){

        foreach ($request->ids as $id) {

            $poi = Poi::find($id);
            if($poi == null) continue;

            //Delete
            $poi->delete();

        }

        flash('Operazione completata con successo')->success();
        return response()->json(['success' => true]);

    }

    public function listDataTable()
    {
        $user = Auth::user();
        return datatables(Poi::where('company_id', $user->company_id))->toJson();
    }
}
