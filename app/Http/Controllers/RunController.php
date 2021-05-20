<?php

namespace App\Http\Controllers;

use App\Models\Run;
use Illuminate\Http\Request;

use App\Services\RunService;

class RunController extends Controller
{

    protected $runService;

    public function __construct(RunService $runService)
    {
        $this->runService = $runService;
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Run  $run
     * @return \Illuminate\Http\Response
     */
    public function show(Run $run)
    {
        return view('models.runs.show', compact('run'));
    }
}
