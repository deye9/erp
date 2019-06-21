<?php

namespace App\Models;

use DB;
use App\Models\User;
use App\Models\Hosts;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

/**
 * @property Customer customer
 * @property Website website
 * @property Hostname hostname
 * @property User admin
*/
class Tenant extends Model
{
    public function __construct(Hosts $host = null, string $hostname = null, User $admin = null)
    {
        $this->host = $host;
        $this->admin = $admin;
        $this->hostname = $hostname;
    }

    public static function tenantExists($name)
    {
        $name = $name . '.' . env('APP_URL_BASE');
        return Hosts::where('fqdn', $name)->exists();
    }

    public static function deleteTenant($name)
    {
        if (static::tenantExists($name)) {
            $name = $name . '.' . env('APP_URL_BASE');

            // Get the Tenant and all Admins.
            $tenant = Hosts::where('fqdn', $name)->first();

            static::notifyAdmins($tenant->website_id, 'goodbye');

            $deletedRows = Hosts::where('fqdn', $name)->delete();

            DB::beginTransaction();
            DB::statement("DROP USER \"$tenant->website_id\"");
            DB::commit();

            DB::statement("DROP DATABASE \"$tenant->website_id\"");
            return new Tenant($tenant, $name, $tenant);
        }
    }

    public static function registerTenant(string $name, string $email, string $password): Tenant
    {
        // Convert all to lowercase
        $name = strtolower($name);
        $email = strtolower($email);
        $baseUrl = env('APP_URL_BASE');

        $tenant = Hosts::create([
            'fqdn' => "{$name}.{$baseUrl}",
            'redirect_to' => null,
            'force_https' => true,
            'under_maintenance_since' => null
        ]);

        $website = static::createTenantDB($tenant->website_id);

        if($website === 0) {
            static::performMigrations($tenant->website_id);
        }

        // Make the registered user the default Admin of the site.
        $admin = static::makeAdmin($name, $email, $password);

        return new Tenant($tenant, "{$name}.{$baseUrl}", $admin);
    }

    // Behaviours
    private static function setTenantConnection($tenantID)
    {
        Config::set("database.connections.\"$tenantID\"", array(
            'driver' => 'pgsql',
            'host' => env('DB_HOST'),
            'port' => env('DB_PORT'),
            'database' => $tenantID,
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ));

        DB::connection("\"$tenantID\"");
        DB::reconnect();
    }

    private static function notifyAdmins(string $tenantID, string $mailType)
    {
        // goodbye, welcome
                // // Notify Admin
        // $tenant->admin->notify(new TenantCreated($tenant->hostname));
        // $this->info("Admin {$email} can log in using password {$password}");
        // $user = DB::select("select * from dblink('dbname=$tenant->website_id', 'select email, name from users where id = 1 limit 1') as t1 (email text, name text)");
    }

    private static function createTenantDB(string $tenantID)
    {
        return Artisan::call('db:create', ['tenantID' => $tenantID]);
    }

    private static function performMigrations(string $tenantID)
    {
        static::setTenantConnection($tenantID);

        // Perform Migrations
        Artisan::call('migrate', [
            '--database' => "\"$tenantID\"", '--path' => '/database/migrations/tenants'
        ]);
    }

    private static function makeAdmin(string $name, string $email, string $password): User
    {
        // Create the user
        $admin = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        // // Assign the guard and Role.
        // $admin->guard_name = 'web';
        // $admin->assignRole('admin');
        static::notifyAdmins($tenantID, 'welcome');
        return $admin;
    }
}
