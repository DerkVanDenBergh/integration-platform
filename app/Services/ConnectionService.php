<?php

namespace App\Services;

use Illuminate\Support\Facades\Gate;

use App\Models\Connection;

class ConnectionService
{
    public function store(array $data)
    {
        $connection = Connection::create($data);

        if(array_key_exists('template', $data)) {
            Gate::authorize('manage_templates');

            $connection->template = true;
        }

        $connection->save();

        return $connection;
    }

    public function storeFromTemplate(array $data)
    {
        // Little bit ugly, TODO: see how this can be improved
        $connection = new Connection();

        $connection->title = $data['title'];
        $connection->user_id = auth()->user()->id;
        
        $template = Connection::find($data['template_id']);

        $connection->description = $template->description;
        $connection->base_url = $template->base_url;

        $connection->save();
        
        foreach($template->endpoints as $templateEndpoint) {
            $endpoint = $templateEndpoint->replicate();
            $endpoint->connection_id = $connection->id;
            $endpoint->save();
        }

        foreach($template->authentications as $templateAuthentication) {
            $authentication = $templateAuthentication->replicate();
            $authentication->connection_id = $connection->id;
            $authentication->save();
        }

        return $connection;
    }

    public function update(array $data, Connection $connection)
    {
        $connection->update($data);

        if(array_key_exists('template', $data)) {
            Gate::authorize('manage_templates');

            $connection->template = true;

            $connection->save();
        }

        return $connection;
    }

    public function delete(Connection $connection)
    {
       $connection->delete();

       return $connection;
    }

    public function findById($id)
    {
       $connection = Connection::find($id);

       return $connection;
    }

    public function findAll()
    {
       $connections = Connection::where('template', false);

       return $connections;
    }

    public function findAllFromUser($id)
    {
        $connections = Connection::where('user_id', $id)->where('template', false)->get();

        return $connections;
    }

    public function findAllTemplates()
    {
        $connections = Connection::where('template', true)->get();

        return $connections;
    }

    public function getTemplateSelection()
    {
        $connections = Connection::select('id', 'title')->where('template', true)->get();

        return $connections;
    }

    public function formatBaseUrl($url)
    {
        $count = substr_count($url, '://');

        if($count > 1) {
            return null;
        }
        
        if($count == 1) {
            $url = explode('://', $url)[1];
        }

        $url = rtrim($url, '/');
        
        return $url;
    }

    public function getOptions()
    {
        $options = collect([
            (object) [
                'option' => 'scratch',
                'label' => 'Create a connection from scratch'
            ],
            (object) [
                'option' => 'template',
                'label' => 'Create a connection from a template'
            ]
        ]);

        return $options;
    }
}
