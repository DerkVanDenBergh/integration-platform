<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

use App\Models\Endpoint;
use App\Models\Connection;

use App\Services\EndpointService;
use App\Services\ConnectionService;
use App\Services\DataModelService;
use App\Services\DataModelFieldService;
use App\Services\AuthenticationService;

class EndpointController extends Controller
{
    protected $endpointService;
    protected $connectionService;
    protected $dataModelService;
    protected $fieldService;
    protected $authenticationService;

    public function __construct(
        EndpointService $endpointService, 
        ConnectionService $connectionService, 
        DataModelService $dataModelService,
        DataModelFieldService $fieldService,
        AuthenticationService $authenticationService
    ) {
        $this->endpointService = $endpointService;
        $this->connectionService = $connectionService;
        $this->dataModelService = $dataModelService;
        $this->fieldService = $fieldService;
        $this->authenticationService = $authenticationService;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($connection)
    {
        $options = $this->endpointService->getProtocols();
        
        return view('models.endpoints.wizard', compact('connection', 'options'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function wizard($connection, Request $request)
    {
        $validatedData = $request->validate([
            'option' => ['required']
        ]);

        $type = $validatedData['option'];

        $methods = $this->endpointService->getMethods($type);

        $authentications = $this->authenticationService->findAllFromUser(auth()->user()->id);
        $authentications->prepend((object) ['id' => '', 'title' => '']);

        return view('models.endpoints.forms.create.' . strtolower($type), compact('connection', 'type', 'methods', 'authentications'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($connection, Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', 
                        Rule::unique('endpoints')
                            ->where('connection_id', $connection)
                            ->where('protocol', $request->get('protocol'))
                            ->where('method', $request->get('method')), 
                        'max:255'],
            'endpoint' => ['required', 
                        Rule::unique('endpoints')
                            ->where('connection_id', $connection)
                            ->where('protocol', $request->get('protocol'))
                            ->where('method', $request->get('method')), 
                        'max:255'],
            'protocol' => ['required'],
            'method' => ['required'],
            'authentication_id' => ['required'], // TODO add rule where it checks if user owns auth
            'port' => ['required_if:protocol,==,tcp|nullable', 'integer']
        ]);

        // TODO error when fails
        $validatedData['endpoint'] = $this->endpointService->formatEndpointUrl($validatedData['endpoint']);

        $validatedData['connection_id'] = $connection;

        $endpoint = $this->endpointService->store($validatedData);

        return redirect('/connections/' . $endpoint->connection_id)->with('success', 'Endpoint with name "' . $endpoint->title . '" has succesfully been created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Endpoint  $endpoint
     * @return \Illuminate\Http\Response
     */
    public function show(Endpoint $endpoint)
    {
        Gate::authorize('mutate_or_view_endpoint', $endpoint);

        // TODO: deze naar model

        $connection = $this->connectionService->findById($endpoint->connection_id);

        $fields = $this->fieldService->findAllFromModel($endpoint->model_id);

        $authentications = $this->authenticationService->findAllFromUser(auth()->user()->id);
        $authentications->prepend((object) ['id' => '', 'title' => '']);

        return view('models.endpoints.show', compact('endpoint', 'connection', 'fields', 'authentications'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Endpoint  $endpoint
     * @return \Illuminate\Http\Response
     */
    public function edit(Endpoint $endpoint)
    {
        Gate::authorize('mutate_or_view_endpoint', $endpoint);

        // TODO deze naar model
        
        $methods = $this->endpointService->getMethods($endpoint->protocol);

        $authentications = $this->authenticationService->findAllFromUser(auth()->user()->id);
        $authentications->prepend((object) ['id' => '', 'title' => '']);

        return view('models.endpoints.forms.edit.' . strtolower($endpoint->protocol), compact('endpoint', 'methods', 'authentications'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Endpoint  $endpoint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Endpoint $endpoint)
    {
        Gate::authorize('mutate_or_view_endpoint', $endpoint);

        $validatedData = $request->validate([
            'title' => ['required', 
                        Rule::unique('endpoints')
                            ->where('connection_id', $endpoint->connection_id)
                            ->where('protocol', $request->get('protocol'))
                            ->where('method', $request->get('method'))
                            ->ignore($endpoint->id), 
                        'max:255'],
            'endpoint' => ['required', 
                        Rule::unique('endpoints')
                            ->where('connection_id', $endpoint->connection_id)
                            ->where('protocol', $request->get('protocol'))
                            ->where('method', $request->get('method'))
                            ->ignore($endpoint->id), 
                        'max:255'],
            'protocol' => ['required'],
            'method' => ['required'],
            'authentication_id' => ['required'], // TODO add rule where it checks if user owns auth
            'port' => ['required_if:protocol,==,tcp|nullable' ,'integer']
        ]);

        // TODO error when fails
        $validatedData['endpoint'] = $this->endpointService->formatEndpointUrl($validatedData['endpoint']);

        $endpoint = $this->endpointService->update($validatedData, $endpoint);

        return redirect('/connections/' . $endpoint->connection_id)->with('success', 'Endpoint with name "' . $endpoint->title . '" has succesfully been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Endpoint  $endpoint
     * @return \Illuminate\Http\Response
     */
    public function destroy(Endpoint $endpoint)
    {
        Gate::authorize('mutate_or_view_endpoint', $endpoint);

        $this->endpointService->delete($endpoint);

        return redirect('/connections/' . $endpoint->connection_id)->with('success', 'Endpoint with name "' . $endpoint->title . '" has succesfully been deleted!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Endpoint  $endpoint
     * @return \Illuminate\Http\Response
     */
    public function model_edit(EndPoint $endpoint)
    {
        $models = $this->dataModelService->findAllFromUser(auth()->user()->id);

        return view('models.endpoints.model', compact('endpoint', 'models'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Endpoint  $endpoint
     * @return \Illuminate\Http\Response
     */
    public function model_update(Request $request, Endpoint $endpoint)
    {
        $validatedData = $request->validate([
            'option' => ['required']
        ]);

        $endpoint = $this->endpointService->updateModel($validatedData['option'], $endpoint);

        return redirect('/endpoints/' . $endpoint->id)->with('success', 'Endpoint with name "' . $endpoint->title . '" has succesfully been updated!');
    }
}
