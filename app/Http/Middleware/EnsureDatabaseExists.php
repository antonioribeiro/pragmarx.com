<?php

namespace App\Http\Middleware;

use DB;
use Artisan;
use Closure;
use App\Data\Entities\User;
use Illuminate\Database\SQLiteConnection;

class EnsureDatabaseExists
{
    private function createDatabase()
    {
        if (($connection = DB::connection()) instanceof SQLiteConnection) {
            $this->createDatabaseFile($connection->getDatabaseName());
        }

        Artisan::call('migrate');
    }

    private function createDatabaseFile($database)
    {
        touch($database);
    }

    private function databaseExists()
    {
        try {
            User::first();
        } catch (\Exception $exception) {
            return false;
        }

        return true;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Closure|\Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (! $this->databaseExists()) {
            $this->createDatabase();
        }

        return $next($request);
    }
}
