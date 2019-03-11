<?php

use Illuminate\Database\Seeder;

class OAuthSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->delete();
        $datetime = Carbon\Carbon::now();
        $clients = [
            'id' => 1,
            'user_id' => null,
            'name' => "Laravel Password Grant Client",
            'secret' => 'swSKeHoAnJqjPFDu6PkIK3RTL4hqBCDR0DywAHiT',
            'redirect' => 'http://localhost',
            'personal_access_client' => 0,
            'password_client' => 1,
            'revoked' => 0,
            'created_at' => $datetime,
            'updated_at' => $datetime
        ];

        DB::table('oauth_clients')->insert($clients);
    }
}
