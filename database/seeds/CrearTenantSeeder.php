<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Symfony\Component\Console\Output\ConsoleOutput;


class CrearTenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $hosts = '';

        foreach (range(1, 5) as $index) {

            // Register tenant

            $baseUrl = config('app.url_base');

            $tenantName = null;
            $fqdn = null;
            $tenantExist = true;

            while($tenantExist) {
                $tenantName = $faker->domainWord();
                $fqdn = "{$tenantName}.{$baseUrl}";
                $tenantExist = Hostname::where('fqdn', $fqdn)->exists();
            }

            $website = new Website;

            app(WebsiteRepository::class)->create($website);

            $hostname = new Hostname;
            $hostname->fqdn = $fqdn;

            app(HostnameRepository::class)->attach($hostname, $website);
            app(Environment::class)->hostname();
            app(Environment::class)->website();
            
            $hosts .= '127.0.0.1 ' . $fqdn . PHP_EOL;
        }
        
        $out = new ConsoleOutput();
        $out->writeln($hosts);
    }
}
