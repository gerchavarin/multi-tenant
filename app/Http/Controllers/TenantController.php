<?php

namespace App\Http\Controllers;

use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tenants = Hostname::all();

        return view('tenants.index', compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tenants.create');
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
        ]);

        $baseUrl = config('app.url_base');
        $tenantName = $request->get('name');
        $fqdn = "{$tenantName}.{$baseUrl}";

        $tenantExist = Hostname::where('fqdn', $fqdn)->exists();
        
        if (!$tenantExist) {
            $website = new Website;
            
            app(WebsiteRepository::class)->create($website);
    
            $hostname = new Hostname;
            $hostname->fqdn = $fqdn;

            app(HostnameRepository::class)->attach($hostname, $website);
            
            app(Environment::class)->hostname();
            app(Environment::class)->website();
        }
        
        return redirect('/tenants')->with('success', "Tenant with id {$hostname->id} has been added.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tenant = Hostname::find($id);

        return view('tenants.edit', compact('tenant'));
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
            'fqdn' => 'required',
        ]);

        $tenant = Hostname::find($id);
        $tenant->fqdn = $request->get('fqdn');
        $tenant->save();

        return redirect('/tenants')->with('success', "Tenant with id {$id} has been updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($tenant = Hostname::where('id', $id)->firstOrFail()) {
            app(HostnameRepository::class)->delete($tenant, true);
            app(WebsiteRepository::class)->delete($tenant->website, true);
            return redirect('/tenants')->with('success', "Tenant with id {$id} successfully deleted.");
        }

        return redirect('/tenants');
    }
}
