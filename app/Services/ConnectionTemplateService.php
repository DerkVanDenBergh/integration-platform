<?php

namespace App\Services;

use App\Models\ConnectionTemplate;

class ConnectionTemplateService
{
    public function store(array $data)
    {
        $connectionTemplate = ConnectionTemplate::create($data);

        $connectionTemplate->save();

        return $connectionTemplate;
    }

    public function update(array $data, ConnectionTemplate $connectionTemplate)
    {
        $connectionTemplate->update($data);

        $connectionTemplate->save();

        return $connectionTemplate;
    }

    public function delete(ConnectionTemplate $connectionTemplate)
    {
       $connectionTemplate->delete();

       return $connectionTemplate;
    }

    public function findById($id)
    {
       $connectionTemplate = ConnectionTemplate::find($id);

       return $connectionTemplate;
    }

    public function findAll()
    {
       $connectionTemplates = ConnectionTemplate::all();

       return $connectionTemplates;
    }
}
