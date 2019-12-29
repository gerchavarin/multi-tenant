<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enterprise;
use Auth;
use App\User;
class EnterpriseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$enterprises = Enterprise::all();
        
        $enterprises = User::findOrFail(Auth::id())->enterprises;
        return view('tenant.enterprises.index',['enterprises' => $enterprises]);
        return $enterprises;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tenant.enterprises.create');
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
            'name' => 'required',
            'rfc' => 'required',
            'description' => 'required'
        ]);

        $enterprise = Enterprise::create(['name' => $request['name'],
                            'rfc' => $request['rfc'],
                            'description' => $request['description']
                            ]);

        return redirect('/enterprises')->with('success', "Enterprise with id {$enterprise->id} has been added.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $enterprise = Enterprise::findOrFail($id);
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
        $enterprise = Enterprise::findOrFail($id);
        return view('tenant.enterprises.edit',compact('enterprise'));
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
        $enterprise = Enterprise::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'rfc' => 'required',
            'description' => 'required'
        ]);
        
        $enterprise->name = $request['name'];
        $enterprise->rfc = $request['rfc'];
        $enterprise->description = $request['description'];

        $enterprise->save();

        return redirect('/enterprises')->with('success', "Enterprise with id {$id} has been updated.");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $enterprise = Enterprise::findOrFail($id);
        $enterprise->destroy($id);

        return redirect('/enterprises');
    }
}
