<?php

namespace App\Services;

use App\Models\Run;

use App\Services\LogService;

class RunService
{
    protected $logService;

    public function __construct(
        LogService $logService
    ) {
        $this->logService = $logService;
    }
    
    public function store(array $data)
    {
        $run = Run::create($data);

        return $run;
    }

    public function update(array $data, Run $run)
    {
        $run->update($data);

        return $run;
    }

    public function delete(Run $run)
    {
       $run->delete();

       return $run;
    }

    public function findById($id)
    {
       $run = Run::find($id);

       return $run;
    }

    public function findAll()
    {
       $runs = Run::all();

       return $runs;
    }

    public function findAllFromRoute($id)
    {
       $runs = Run::orderBy('created_at', 'desc')->where('type', 'route')->where('process_id', $id)->get();

       return $runs;
    }
}
