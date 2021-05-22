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
            1000, 
            'API token', 
            'Token', 
            '',
            '',
            'dfsgjijehhbfaijfjsaibhndkj#@42kjmn3iu2ghjbnaiudas==',
            1000
        ));
        
        $authentication_key->save();
        
        $authentication_basic = new Authentication($this->definition(
            1001, 
            'API key', 
            'Basic', 
            'test_user_account',
            'VerySecurePassword123!',
            '', 
            1001
        ));

        $authentication_basic->save();
    }

    private function definition($id, $title, $type, $username, $password, $token, $connection_id)
    { // TODO add oauth parameters
        $parameters = [
            'id' => $id,
            'title' => $title,
            'type' => $type,
            'username' => $username,
            'password' => $password,
            'token' => $token,
            'connection_id' => $connection_id
        ];

        return $parameters;
    }
}
