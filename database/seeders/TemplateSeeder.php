<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Connection;
use App\Models\Endpoint;
use App\Models\Authentication;
use App\Models\DataModel;
use App\Models\DataModelField;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Discord
        $this->createConnection(1000, 'Discord API', 'A connection to the Discord API. Here you can add webhooks to easily send messages to servers and chats.', 'discordapp.com/api', 1);
        $this->createModel(1000, 'Discord - Message', 'A model for a discord message.', 1, 1000);
        $this->createField(1000, 1000, null, 'content', 'attribute', 'string');
        $this->createField(1001, 1000, null, 'username', 'attribute', 'string');
        $this->createField(1002, 1000, null, 'avatar_url', 'attribute', 'string');
        $this->createEndpoint(1000, 'Discord - Send message', '/webhooks/{webhook-id}/{webhook-token}', 'HTTP', 'POST', 1000, null, 1000);

        // Twitter
        $this->createConnection(1001, 'Twitter API', 'A connection to the Twitter API. Here you can send tweets.', 'api.twitter.com', 1);
        $this->createModel(1001, 'Twitter - Tweet', 'A model for a tweet.', 1, 1001);
        $this->createField(1003, 1001, null, 'status', 'attribute', 'string');
        $this->createAuthentication(1000, 'Twitter oauth token', 'oauth1', null, null, null, null, null, null, null, 1001);
        $this->createEndpoint(1001, 'Twitter - Send tweet', '/1.1/statuses/update.json', 'HTTP', 'POST', 1001, 1000, 1001);

        // Travis
        $this->createConnection(1002, 'Travis CI API', 'A connection to the Travis CI API. Here you can manage builds.', 'api.travis-ci.com', 1);
        $this->createModel(1002, 'Travis - Build', 'A model for a finished build.', 1, 1002);
        $this->createField(1004, 1002, null, 'payload', 'set', null);
            $this->createField(1005, 1002, 1004, 'number', 'attribute', 'string');
            $this->createField(1006, 1002, 1004, 'type', 'attribute', 'string');
            $this->createField(1007, 1002, 1004, 'state', 'attribute', 'string');
            $this->createField(1008, 1002, 1004, 'build_url', 'attribute', 'string');

        // Github
        $this->createConnection(1003, 'Github API', 'A connection to the Github API. Here you can manage your github repo metadata.', 'api.github.com', 1);
        $this->createModel(1003, 'Github - Star', 'A model for a github star.', 1, 1003);
        $this->createField(1009, 1003, null, 'action', 'attribute', 'string');
        $this->createField(1010, 1003, null, 'repository', 'set', null);
            $this->createField(1011, 1003, 1010, 'full_name', 'attribute', 'string');
            $this->createField(1012, 1003, 1010, 'owner', 'set', null);
                $this->createField(1013, 1003, 1012, 'login', 'attribute', 'string');
            $this->createField(1014, 1003, 1010, 'stargazers_count', 'attribute', 'string');
        $this->createField(1015, 1003, null, 'sender', 'set', null);
            $this->createField(1016, 1003, 1015, 'login', 'attribute', 'string');

    }

    private function createConnection($id, $title, $description, $base_url, $user_id, $template = true)
    {
        $parameters = [
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'base_url' => $base_url,
            'user_id' => $user_id,
            'template' => $template
        ];

        $connection = Connection::create($parameters);

        return $connection;
    }

    private function createAuthentication($id, $title, $type, $username, $password, $token, $oauth1_consumer_key, $oauth1_consumer_secret, $oauth1_token, $oauth1_token_secret, $connection_id)
    {
        $parameters = [
            'id' => $id,
            'title' => $title,
            'type' => $type,
            'username' => $username,
            'password' => $password,
            'oauth1_consumer_key' => $oauth1_consumer_key,
            'oauth1_consumer_secret' => $oauth1_consumer_secret,
            'oauth1_token' => $oauth1_token,
            'oauth1_token_secret' => $oauth1_token_secret,
            'token' => $token,
            'connection_id' => $connection_id
        ];

        $authentication = Authentication::create($parameters);

        return $authentication;
    }

    private function createEndpoint($id, $title, $endpoint, $protocol, $method, $connection_id, $authentication_id, $model_id)
    {
        $parameters = [
            'id' => $id,
            'title' => $title,
            'endpoint' => $endpoint,
            'protocol' => $protocol,
            'method' => $method,
            'connection_id' => $connection_id,
            'authentication_id' => $authentication_id,
            'model_id' => $model_id
        ];

        $endpoint = Endpoint::create($parameters);

        return $endpoint;
    }

    private function createModel($id, $title, $description, $user_id, $template_id)
    {
        $parameters = [
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'user_id' => $user_id,
            'template_id' => $template_id
        ];

        $model = DataModel::create($parameters);

        return $model;
    }

    private function createField($id, $model_id, $parent_id, $name, $node_type, $data_type)
    {
        $parameters = [
            'id' => $id,
            'model_id' => $model_id,
            'parent_id' => $parent_id,
            'name' => $name,
            'node_type' => $node_type,
            'data_type' => $data_type,
        ];

        $field = DataModelField::create($parameters);

        return $field;
    }
}
