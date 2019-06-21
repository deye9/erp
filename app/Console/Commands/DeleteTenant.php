<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use Illuminate\Console\Command;

class DeleteTenant extends Command
{
    protected $signature = 'tenant:delete {name}';

    protected $description = 'Deletes a tenant of the provided name. Only available on the local environment e.g. php artisan tenant:delete andela'; // boise

    public function handle()
    {
        $name = $this->argument('name');
        $result = Tenant::deleteTenant($name);
        $this->info("Tenant {$name} successfully deleted.");
        $this->info($result);
    }
}
