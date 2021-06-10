<?php

namespace App\Http\Controllers;

use App\Models\Processable;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

use App\Services\ProcessableService;
use App\Services\MappingService;
use App\Services\MappingFieldService;
use App\Services\DataModelService;
use App\Services\DataModelFieldService;
use App\Services\EndpointService;
use App\Services\StepService;
use App\Services\RunService;

class TaskController extends Controller
{
    protected $processableService;
    protected $mappingService;
    protected $modelFieldService;
    protected $mappingFieldService;
    protected $modelService;
    protected $endpointService;
    protected $stepService;
    protected $runService;

    public function __construct(
        ProcessableService $processableService,
        MappingService $mappingService,
        MappingFieldService $mappingFieldService,
        DataModelFieldService $modelFieldService,
        DataModelService $modelService,
        EndpointService $endpointService,
        StepService $stepService,
        RunService $runService
    ) {
        $this->processableService = $processableService;
        $this->mappingService = $mappingService;
        $this->modelFieldService = $modelFieldService;
        $this->mappingFieldService = $mappingFieldService;
        $this->modelService = $modelService;
        $this->endpointService = $endpointService;
        $this->stepService = $stepService;
        $this->runService = $runService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = $this->processableService->findAllProcessablesFromUserByType(auth()->user()->id, Processable::TASK);

        return view('models.tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('models.tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', Rule::unique('processables')->where('user_id', auth()->user()->id), 'max:255'],
            'interval' => ['nullable', 'integer'],
            'description' => ['nullable']
        ]);

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['type_id'] = Processable::TASK;

        $task = $this->processableService->store($validatedData);

        return redirect('/tasks')->with('success', 'Task with name "' . $task->title . '" has succesfully been created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Processable  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Processable $task)
    {
        Gate::authorize('mutate_or_view_processable', $task);

        $mapping = $this->mappingService->findByProcessableId($task->id);
        $mappingFields = $this->mappingFieldService->findAllFromMapping($mapping->id);

        $models = $this->modelService->findAllFromUser(auth()->user()->id);

        $endpoints = $this->endpointService->findAllFromUser(auth()->user()->id);

        $steps = $this->stepService->findAllFromProcessable($task->id);

        $runs = $this->runService->findAllFromProcessable($task->id);

        if($mapping->output_endpoint != null) {
            $outputEndpoint = $this->endpointService->findById($mapping->output_endpoint);
            $outputModel = $this->modelService->findById($outputEndpoint->model_id);
            
            if($outputModel) {
                $outputModelFields = $this->modelFieldService->findAllFromModel($outputModel->id);
            } else {
                $inputModelFields = null;
            }

            $inputEndpoint = $this->endpointService->findById($mapping->input_endpoint);
            $inputModel = $this->modelService->findById($inputEndpoint->model_id);

            if($inputModel) {
                $inputModelFields = $this->modelFieldService->findAllFromModel($inputModel->id);
            } else {
                $inputModelFields = null;
            }
            

            return view('models.tasks.show', compact('task', 'mapping', 'mappingFields', 'models', 'endpoints','steps','outputModel','outputModelFields','inputModel','inputModelFields', 'runs'));
        }

        return view('models.tasks.show', compact('task', 'mapping', 'mappingFields','models', 'endpoints','steps', 'runs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Processable  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Processable $task)
    {
        Gate::authorize('mutate_or_view_processable', $task);

        return view('models.tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Processable  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Processable $task)
    {
        Gate::authorize('mutate_or_view_processable', $task);

        $validatedData = $request->validate([
            'title' => ['required', Rule::unique('processables')->where('user_id', auth()->user()->id)->ignore($task->id), 'max:255'],
            'description' => ['nullable'],
            'interval' => ['nullable', 'integer'],
            'active' => ['nullable']
        ]);

        // TODO: make sure the task cant be set to active if one of the endpoints in the mapping is not filled

        $task = $this->processableService->update($validatedData, $task);

        return redirect('/tasks/' . $task->id)->with('success', 'Task with name ' . $task->title . ' has successfully been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Processable  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Processable $task)
    {
        Gate::authorize('mutate_or_view_processable', $task);

        $this->processableService->delete($task);

        return redirect('/tasks')->with('success', 'Task with name "' . $task->title . '" has succesfully been deleted!');
    }

    /**
     * Execute the specified task.
     *
     * @param  \App\Models\Processable  $task
     * @return \Illuminate\Http\Response
     */
    public function execute(Processable $task)
    {
        Gate::authorize('mutate_or_view_processable', $task);

        $response = $this->processableService->executeTask($task);

        if($response->getStatusCode() == 200) {
            return redirect('/tasks/' . $task->id)->with('success', 'Task with name "' . $task->title . '" has succesfully executed!');
        } else {
            return redirect('/tasks/' . $task->id)->with('error', 'Task with name "' . $task->title . '" has encountered an error during execution. Check run for more details!');
        }

        
    }
}
