<?php

namespace App\Services;

use Illuminate\Support\Facades\Gate;

use App\Models\Connection;
use App\Services\LogService;

class ConnectionService
{
    
    protected $logService;

    public function __construct(
        LogService $logService
    ) {
        $this->logService = $logService;
    }

    public function store(array $data)
    {
        $connection = Connection::create($data);

        if(array_key_exists('template', $data)) {
            Gate::authorize('manage_templates');

            $connection->template = true;
        }

        $connection->save();

        $this->logService->push('info','created connection with id ' . $connection->id . '.', json_encode($connection));

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
        
        if($template->endpoints()->get()) {
            foreach($template->endpoints()->get() as $templateEndpoint) {
                $endpoint = $templateEndpoint->replicate();
                $endpoint->connection_id = $connection->id;
                $endpoint->save();
            }
        }
        
        if($template->authentications()->get()) {
            foreach($template->authentications()->get() as $templateAuthentication) {
                $authentication = $templateAuthentication->replicate();
                $authentication->connection_id = $connection->id;
                $authentication->save();
            }
        }

        if($template->modelTemplates()->get()) {
            foreach($template->modelTemplates()->get() as $modelTemplate) {
                $model = $modelTemplate->replicate();
                $model->user_id = auth()->user()->id;
                $model->template_id = null;
                $model->save();
                if($modelTemplate->fields()->get()) {
                    $this->replicateChildren($modelTemplate->fields()->where('parent_id', null)->get(), null, $model->id);
                }
            }
        }

        $this->logService->push('info','created connection with id ' . $connection->id . ' from a template with id ' . $data['template_id'] . '.', json_encode($connection));

        return $connection;
    }

    private function replicateChildren($fields, $parent_id, $model_id)
    {
        foreach($fields as $fieldTemplate) {
            if($fieldTemplate->type == 'attribute') {
                $field = $fieldTemplate->replicate();
                $field->model_id = $model_id;
                $field->parent_id = $parent_id;
                $field->save();
            } else {
                $field = $fieldTemplate->replicate();
                $field->parent_id = $parent_id;
                $field->model_id = $model_id;
                $field->save();

                $this->replicateChildren($fieldTemplate->children()->get(), $field->id, $model_id);
            }
        }
    }

    public function update(array $data, Connection $connection)
    {
        $connection->update($data);

        if(array_key_exists('template', $data)) {
            Gate::authorize('manage_templates');

            $connection->template = true;

            $connection->save();
        }

        $this->logService->push('info','updated connection with id ' . $connection->id . '.', json_encode($connection));

        return $connection;
    }

    public function delete(Connection $connection)
    {
       $connection->delete();

       $this->logService->push('info','deleted connection with id ' . $connection->id . '.', json_encode($connection));

       return $connection;
    }

    public function findById($id)
    {
       $connection = Connection::find($id);

       $this->logService->push('info','requested connection with id ' . $connection->id . '.', json_encode($connection));

       return $connection;
    }

    public function findAll()
    {
       $connections = Connection::where('template', false);

       $this->logService->push('info','requested all connections.');

       return $connections;
    }

    public function findAllFromUser($id)
    {
        $connections = Connection::where('user_id', $id)->where('template', false)->get();

        $this->logService->push('info','requested all connections associated with user with id ' . $id . '.');

        return $connections;
    }

    public function findAllTemplates()
    {
        $connections = Connection::where('template', true)->get();

        $this->logService->push('info','requested all templates.');

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
