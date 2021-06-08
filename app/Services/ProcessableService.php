<?php

namespace App\Services;

use App\Models\Processable;

use Illuminate\Support\Str;
use App\Services\LogService;

class ProcessableService
{
    protected $mappingService;
    protected $logService;

    public function __construct(MappingService $mappingService,  LogService $logService) {
        $this->mappingService = $mappingService;
        $this->logService = $logService;
    }

    public function store(array $data)
    {
        $data['active'] = array_key_exists('active', $data);
        $data['slug'] = Str::random(25);
        
        $processable = Processable::create($data);
    
        $processable->save();

        $this->mappingService->store([
            'processable_id' => $processable->id,
            'type' => 'task'
        ]);

        $this->logService->push('info','created processable with id ' . $processable->id . '.', json_encode($processable));

        return $processable;
    }

    public function update(array $data, Processable $processable)
    {
        $data['active'] = array_key_exists('active', $data);

        $processable->update($data);

        $processable->save();

        $this->logService->push('info','updated processable with id ' . $processable->id . '.', json_encode($processable));

        return $processable;
    }

    public function delete(Processable $processable)
    {
       $processable->delete();

       $this->logService->push('info','deleted processable with id ' . $processable->id . '.', json_encode($processable));

       return $processable;
    }

    public function findById($id)
    {
        $processable = Processable::find($id);

        if($processable) {
            $this->logService->push('info','requested processable with id ' . $processable->id . '.', json_encode($processable));
        } else {
            $this->logService->push('warning','requested processable with id ' . $id . ' but was not found.');
        }

        return $processable;
    }

    public function findBySlug($slug)
    {
        $processable = Processable::where('slug', $slug)->first();

        if($processable) {
            $this->logService->push('info','requested processable with slug ' . $slug . '.', json_encode($processable));
        } else {
            $this->logService->push('warning','requested processable with slug ' . $slug . ' but was not found.');
        }

        return $processable;
    }

    public function findAll()
    {
       $processables = Processable::all();

       $this->logService->push('info','requested all processables.', json_encode($processables));

       return $processables;
    }

    public function findAllFromUser($id)
    {
        $processables = Processable::where('user_id', $id)->get();

        $this->logService->push('info','requesteed all processables associated with user with id ' . $id . '.');

        return $processables;
    }

    public function findAllRoutesFromUser($id)
    {
        $processables = Processable::where('user_id', $id)->where('type_id', 1)->get();

        $this->logService->push('info','requesteed all processables associated with user with id ' . $id . '.');

        return $processables;
    }
}
