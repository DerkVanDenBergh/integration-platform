<?php

namespace App\Services;

use App\Models\DataModel;
use App\Models\StepArgument;

use App\Services\LogService;

class StepArgumentService
{
    protected $logService;

    public function __construct(
        LogService $logService
    ) {
        $this->logService = $logService;
    }
    
    public function store(array $data)
    {
        $stepArgument = StepArgument::create($data);

        $stepArgument->save();

        $this->logService->push('info','created stepArgument with id ' . $stepArgument->id . '.', json_encode($stepArgument));

        return $stepArgument;
    }

    public function update(array $data, StepArgument $stepArgument)
    {
        $stepArgument->update($data);

        $this->logService->push('info','updated stepArgument with id ' . $stepArgument->id . '.', json_encode($stepArgument));

        return $stepArgument;
    }

    public function delete(StepArgument $stepArgument)
    {
       $stepArgument->delete();

       $this->logService->push('info','deleted stepArgument with id ' . $stepArgument->id . '.', json_encode($stepArgument));

       return $stepArgument;
    }

    public function deleteAllFromRoute($id)
    {
        $stepArguments = StepArgument::where('route_id', $id)->get();
        
        foreach($stepArguments as $stepArgument) {
            $this->delete($stepArgument);
        }
    }

    public function findById($id)
    {
       $stepArgument = StepArgument::find($id);

       $this->logService->push('info','requested stepArgument with id ' . $stepArgument->id . '.', json_encode($stepArgument));

       return $stepArgument;
    }

    public function findAll()
    {
       $stepArguments = StepArgument::all();

       $this->logService->push('info','requested all stepArguments.');

       return $stepArguments;
    }
}
