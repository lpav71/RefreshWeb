<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\UserAccess;
use Illuminate\Support\ServiceProvider;

class UserCommon extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(UserCommon::class, function ($app) {
            return new UserCommon($app);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    public static function UsersFind($searchUser, $club_id)
    {
        return Client::where('login', 'ILIKE', '%'.$searchUser.'%')->where('club_id', $club_id)->get()->toArray();
    }

    public static function getPermissions($user_id, $club_id)
    {
        return UserAccess::where('club_id', $club_id)->where('user_id', $user_id)->first();
    }
}
