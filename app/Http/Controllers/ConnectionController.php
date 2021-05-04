<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

use App\Services\ConnectionService;
use App\Services\AuthenticationService;
use App\Services\EndpointService;

class ConnectionController extends Controller
{

    protected $connectionService;
    protected $authService;
    protected $endpointService;

    public function __construct(
        ConnectionService $connectionService, 
        AuthenticationService $authService,
        EndpointService $endpointService
    ) {
        $this->connectionService = $connectionService;
        $this->authService = $authService;
        $this->endpointService = $endpointService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $connections = $this->connectionService->findAllFromUser(auth()->user()->id);

        return view('models.connections.index', compact('connections'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function templates()
    {
        $connections = $this->connectionService->findAllTemplates();

        return view('models.connections.index', compact('connections'));
    }

    /**
     * Show the form for selecting a new resource via the wizard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $options = $this->connectionService->getOptions();
        
        return view('models.connections.wizard', compact('options'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function wizard(Request $request)
    {
        $validatedData = $request->validate([
            'option' => ['required']
        ]);

        if($validatedData['option'] == 'template') {
            $templates = $this->connectionService->getTemplateSelection();

            return view('models.connections.templates', compact('templates'));
        } else {
            return view('models.connections.create');
        }
        
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
            'title' => ['required', Rule::unique('connections')->where('user_id', auth()->user()->id), 'max:255'],
            'description' => ['nullable'],
            'base_url' => ['required', 'max:255'],
            'template' => ['nullable']
        ]);

        // TODO error when fails
        $validatedData['base_url'] = $this->connectionService->formatBaseUrl($validatedData['base_url']);

        $validatedData['user_id'] = auth()->user()->id;

        $connection = $this->connectionService->store($validatedData);

        return redirect('/connections')->with('success', 'Connection with name "' . $connection->title . '" has succesfully been created!');
    }

    /**
     * Store a newly created resource in storage created from a template.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function template(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', Rule::unique('connections')->where('user_id', auth()->user()->id), 'max:255'],
            'description' => ['nullable'],
            'template_id' => ['required']
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        $connection = $this->connectionService->storeFromTemplate($validatedData);

        return redirect('/connections')->with('success', 'Connection with name "' . $connection->title . '" has succesfully been created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Connection  $connection
     * @return \Illuminate\Http\Response
     */
    public function show(Connection $connection)
    {
        Gate::authorize('mutate_or_view_connection', $connection);

        $authentications = $this->authService->findAllFromConnection($connection->id);
        
        $endpoints = $this->endpointService->findAllFromConnection($connection->id);

        return view('models.connections.show', compact('connection', 'authentications', 'endpoints'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Connection  $connection
     * @return \Illuminate\Http\Response
     */
    public function edit(Connection $connection)
    {
        Gate::authorize('mutate_or_view_connection', $connection);

        return view('models.connections.edit', compact('connection'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Connection  $connection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Connection $connection)
    {
        Gate::authorize('mutate_or_view_connection', $connection);

        $validatedData = $request->validate([
            'title' => ['required', Rule::unique('connections')->where('user_id', auth()->user()->id)->ignore($connection->id), 'max:255'],
            'description' => ['nullable'],
            'base_url' => ['required', 'max:255'],
            'template' => ['nullable']
        ]);

        // TODO error when fails
        $validatedData['base_url'] = $this->connectionService->formatBaseUrl($validatedData['base_url']);

        $validatedData['user_id'] = auth()->user()->id;

        $connection = $this->connectionService->update($validatedData, $connection);

        return redirect('/connections')->with('success', 'Connection with name "' . $connection->title . '" has succesfully been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Connection  $connection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Connection $connection)
    {
        Gate::authorize('mutate_or_view_connection', $connection);

        $this->connectionService->delete($connection);

        return redirect('/connections')->with('success', 'Connection with name "' . $connection->title . '" has succesfully been deleted!');
    }
}
