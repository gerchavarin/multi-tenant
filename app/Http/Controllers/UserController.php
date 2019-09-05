<?php

namespace App\Http\Controllers;

use App\Enterprise;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorStore(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:tenant.users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'enterprise_ids' => ['nullable', 'array'],
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorUpdate(array $data, $id)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:tenant.users,email,' . $id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'enterprise_ids' => ['nullable', 'array'],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('tenant.users.index',['users' => $users]);
        return $users;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $enterprises = Enterprise::all();
        return view('tenant.users.create', compact('enterprises'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validatorStore($request->all())->validate();
        
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        if(isset($request['enterprise_ids'])) {
            $user->enterprises()->attach($request['enterprise_ids']);
        }

        return redirect('/users')->with('success', "User with id {$user->id} has been added.");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $enterprises = Enterprise::all();
        $user_enterprise_ids = $user->enterprises->pluck('id')->toArray();
        return view('tenant.users.edit', compact('user', 'enterprises', 'user_enterprise_ids'));
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
        $this->validatorUpdate($request->all(), $id)->validate();
        
        $user = User::findOrFail($id);

        $user->name = $request['name'];
        $user->email = $request['email'];

        $user->save();

        if(isset($request['enterprise_ids'])) {
            $user->enterprises()->sync($request['enterprise_ids']);
        }

        return redirect('/users')->with('success', "User with id {$id} has been updated.");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        foreach ($user->enterprises()->get() as $enterprise) {
            $user->enterprises()->detach($enterprise->id);
        }

        $user->destroy($id);

        return redirect('/users');
    }
}
