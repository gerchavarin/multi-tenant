<?php

use Illuminate\Database\Seeder;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;

class CrearTenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $website = new Website;
        //$website->uuid = "tenant_test_1";
        //$website->managed_by_database_connection = 'tenant1';
        app(WebsiteRepository::class)->create($website);
        
        $hostname = new Hostname;
        $hostname->fqdn = 'tenant1.demo.test';
        $hostname = app(HostnameRepository::class)->create($hostname);
        app(HostnameRepository::class)->attach($hostname, $website);
        
        $hostname = app(\Hyn\Tenancy\Environment::class)->hostname();
        $website = app(\Hyn\Tenancy\Environment::class)->website();
        
        $website = new Website;
        //$website->uuid = "tenant_test_2";
        //$website->managed_by_database_connection = 'tenant2';
        app(WebsiteRepository::class)->create($website);
        
        $hostname = new Hostname;
        $hostname->fqdn = 'tenant2.demo.test';
        $hostname = app(HostnameRepository::class)->create($hostname);
        app(HostnameRepository::class)->attach($hostname, $website);
        
        $hostname = app(\Hyn\Tenancy\Environment::class)->hostname();
    	$website = app(\Hyn\Tenancy\Environment::class)->website();
    }
}
