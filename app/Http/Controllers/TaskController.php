<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

use App\Services\TaskService;
use App\Services\MappingService;
use App\Services\MappingFieldService;
use App\Services\DataModelService;
use App\Services\DataModelFieldService;
use App\Services\EndpointService;
use App\Services\StepService;
use App\Services\RunService;

class TaskController extends Controller
{
    protected $taskService;
    protected $mappingService;
    protected $modelFieldService;
    protected $mappingFieldService;
    protected $modelService;
    protected $endpointService;
    protected $stepService;
    protected $runService;

    public function __construct(
        TaskService $taskService,
        MappingService $mappingService,
        MappingFieldService $mappingFieldService,
        DataModelFieldService $modelFieldService,
        DataModelService $modelService,
        EndpointService $endpointService,
        StepService $stepService,
        RunService $runService
    ) {
        $this->taskService = $taskService;
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
        $tasks = $this->taskService->findAllFromUser(auth()->user()->id);

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
            'title' => ['required', Rule::unique('tasks')->where('user_id', auth()->user()->id), 'max:255'],
            'description' => ['nullable']
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        $route = $this->taskService->store($validatedData);

        return redirect('/tasks')->with('success', 'Task with name "' . $task->title . '" has succesfully been created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        Gate::authorize('mutate_or_view_task', $task);

        $mapping = $this->mappingService->findByTaskId($task->id);
        $mappingFields = $this->mappingFieldService->findAllFromMapping($mapping->id);

        $models = $this->modelService->findAllFromUser(auth()->user()->id);

        $endpoints = $this->endpointService->findAllFromUser(auth()->user()->id);

        $steps = $this->stepService->findAllFromTask($task->id);

        $runs = $this->runService->findAllFromTask($task->id);

        if($mapping->output_endpoint != null) {
            $outputEndpoint = $this->endpointService->findById($mapping->output_endpoint);
            $outputModel = $this->modelService->findById($outputEndpoint->model_id);
            $outputModelFields = $this->modelFieldService->findAllFromModel($outputModel->id);

            $inputEndpoint = $this->endpointService->findById($mapping->input_endpoint);
            $inputModel = $this->modelService->findById($mapping->input_model);
            $inputModelFields = $this->modelFieldService->findAllFromModel($inputModel->id);

            return view('models.tasks.show', compact('task', 'mapping', 'mappingFields', 'models', 'endpoints','steps','outputModel','outputModelFields','inputModel','inputModelFields', 'runs'));
        }

        return view('models.tasks.show', compact('task', 'mapping', 'mappingFields','models', 'endpoints','steps', 'runs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        Gate::authorize('mutate_or_view_task', $task);

        return view('models.tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        Gate::authorize('mutate_or_view_task', $task);

        $validatedData = $request->validate([
            'title' => ['required', Rule::unique('tasks')->where('user_id', auth()->user()->id)->ignore($task->id), 'max:255'],
            'description' => ['nullable'],
            'active' => ['nullable']
        ]);

        // TODO: make sure the route cant be set to active if one of the endpoints in the mapping is not filled

        $task = $this->taskService->update($validatedData, $task);

        return redirect('/tasks/' . $task->id)->with('success', 'Task with name ' . $task->title . ' has successfully been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        Gate::authorize('mutate_or_view_task', $task);

        $this->taskService->delete($task);

        return redirect('/tasks')->with('success', 'Task with name "' . $task->title . '" has succesfully been deleted!');
    }
}
