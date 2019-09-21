<?php

namespace App\Http\Controllers;

use App\Enterprise;
use App\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


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
        return view('tenant.records.index',['records' => $records]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tenant.records.create');
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

        return view('tenant.records.edit',['id' => $record->id,
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
        
        return redirect()->back();
    }

    public function showRecordsInEnterprise($id)
    {
        $positive = 0;
        $negative = 0;

        $recordsEnterprises = Enterprise::findOrFail($id);
        $records = $recordsEnterprises->records()->where('created_at','>=',now()->format('Y-m-d'))->get();
        
        foreach ($records as $record){
            
            if($record->type == 'ingreso'){
                $positive += $record->mount; 
            }else{
                $negative += $record->mount;
            }
        }


        return view('tenant.records.index',['records' => $records,
                                            'enterprise_id' => $id,
                                            'positive' => $positive,
                                            'negative' => $negative]);
        
    }

    public function storeRecordsInEnterprise(Request $request,$id)
    {
        $request->validate([
            'type' => 'required',
            'mount' => 'required|numeric',
            'description' => 'required'
        ]);

        $record = Record::create(['type' => $request['type'],
                            'mount' => $request['mount'],
                            'description' => $request['description'],
                            'enterprise_id' => $id
                            ]);
        

        $website   = app(\Hyn\Tenancy\Environment::class)->website();
        $websiteId = $website->id;


        event(new \App\Events\NewMessage(['message'=>"Se han añadido nuevos registros, tipo de movimiento : {$request['type']},
                                                                                       monto del movimiento: {$request['mount']},
                                                                                       concepto: {$request['description']}",
                                          'tenant_id'=>$websiteId]));

        return redirect("/enterprises/{$id}/records")->with('success', "Record with id {$record->id} has been added.");
    }

    public function createRecordsInEnterprise($id)
    {
        
        return view('tenant.records.create',['enterprise_id' => $id]);
    }

    public function editRecordsInEnterprise($id,$rid)
    {

        $record = Record::findOrFail($rid);   

        return view('tenant.records.edit',['record' => $record, 
                                           'record_id' => $rid,
                                            'enterprise_id' => $id]);
    }

    public function updateRecordsInEnterprise(Request $request, $id, $rid)
    {
        $request->validate([
            'type' => 'required',
            'mount' => 'required|numeric',
            'description' => 'required'
        ]);
        
        $record = Record::findOrFail($rid);

        $record->type = $request['type'];
        $record->mount = $request['mount'];
        $record->description = $request['description'];
        $record->save();

        return redirect("/enterprises/{$id}/records")->with('success', "Record with id {$record->id} has been updated.");
    }

    public function downloadRecordsInEnterprise($id)
    {
        $folder = Storage::disk('tenant')->makeDirectory('enterprises/' . $id);

        $enterprise = Enterprise::findOrFail($id);
        $records = $enterprise->records()->get();

        $output = implode(',', ['id', 'type', 'mount', 'description', 'created_at', 'updated_at']) . PHP_EOL;

        foreach ($records as $record) {
            $output .=  implode(',', [$record['id'], $record['type'], $record['mount'], $record['description'], $record['created_at'], $record['updated_at']]) . PHP_EOL;
        }

        $file_records = 'enterprises/' . $id . '/records.csv';

        $full_path_file_records = Storage::disk('tenant')->path($file_records);

        Storage::disk('tenant')->put($file_records, $output);

        return response()->download($full_path_file_records, 'records_' . $id . '.csv', ['Content-Type' => 'text/csv']);
    }

    public function searchByDate(Request $request,$id){

        $positive = 0;
        $negative = 0;
        
        $recordsEnterprises = Enterprise::findOrFail($id);
        $records = $recordsEnterprises->records()->whereBetween('created_at',['init' => $request['init'],'last' => $request['last']])->get();

        foreach ($records as $record){
            
            if($record->type == 'ingreso'){
                $positive += $record->mount; 
            }else{
                $negative += $record->mount;
            }
        }

        return view('tenant.records.index',['records' => $records,
                                            'enterprise_id' => $id,
                                            'positive' => $positive,
                                            'negative' => $negative]);
        
    }
}
