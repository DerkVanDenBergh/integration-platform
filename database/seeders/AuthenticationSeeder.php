<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Authentication;

class AuthenticationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $authentication_key = new Authentication($this->definition(
            2000, 
            'API token', 
            'Token', 
            '',
            '',
            'dfsgjijehhbfaijfjsaibhndkj#@42kjmn3iu2ghjbnaiudas==',
            '',
            '',
            '',
            '',
            2000
        ));
        
        $authentication_key->save();
        
        $authentication_basic = new Authentication($this->definition(
            2001, 
            'API key', 
            'Basic', 
            'test_user_account',
            'VerySecurePassword123!',
            '', 
            '',
            '',
            '',
            '',
            2001
        ));

        $authentication_basic->save();
    }

    private function definition($id, $title, $type, $username, $password, $token, $oauth1_consumer_key, $oauth1_consumer_secret, $oauth1_token, $oauth1_token_secret, $connection_id)
    {
        $parameters = [
            'id' => $id,
            'title' => $title,
            'type' => $type,
            'username' => $username,
            'password' => $password,
            'token' => $token,
            'connection_id' => $connection_id,
            'oauth1_consumer_key' => $oauth1_consumer_key,
            'oauth1_consumer_secret' => $oauth1_consumer_secret,
            'oauth1_token' => $oauth1_token,
            'oauth1_token_secret' => $oauth1_token_secret
        ];

        return $parameters;
    }
}
