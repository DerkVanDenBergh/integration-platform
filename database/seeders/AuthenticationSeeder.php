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
            'API key', 
            'Key', 
            '',
            '',
            'dfsgjijehhbfaijfjsaibhndkj#@42kjmn3iu2ghjbnaiudas==',
            '', 
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
            '', 
            1001
        ));

        $authentication_basic->save();

        \Illuminate\Support\Facades\DB::statement("ALTER SEQUENCE authentications_id_seq RESTART 11000;");
    }

    private function definition($id, $title, $type, $username, $password, $key, $token, $connection_id)
    {
        $parameters = [
            'id' => $id,
            'title' => $title,
            'type' => $type,
            'username' => $username,
            'password' => $password,
            'key' => $key,
            'token' => $token,
            'connection_id' => $connection_id
        ];

        return $parameters;
    }
}
