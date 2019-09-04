<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Record;
class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Record::all();
        return view('records.index',['records' => $records]);
        //return $records;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('records.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'mount' => 'required|numeric',
            'description' => 'required'
        ]);

        $record = Record::create(['type' => $request['type'],
                            'mount' => $request['mount'],
                            'description' => $request['description']
                            ]);

        return redirect('/records')->with('success', "Record with id {$record->id} has been added.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record = Record::findOrFail($id);
        return $enterprise;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = Record::findOrFail($id);

        return view('records.edit',['id' => $record->id,
                                    'record' => $record]);
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
        $request->validate([
            'type' => 'required',
            'mount' => 'required|numeric',
            'description' => 'required'
        ]);
        
        $record = Record::findOrFail($id);

        $record->type = $request['type'];
        $record->mount = $request['mount'];
        $record->description = $request['description'];
        $record->save();

        return redirect('/records')->with('success', "Record with id {$record->id} has been updated.");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Record::findOrFail($id);
        $record->destroy($id);
        
        return redirect('/records');
    }
}
