<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

use App\Models\Endpoint;
use App\Models\Connection;

use App\Services\EndpointService;

class EndpointController extends Controller
{
    protected $endpointService;

    public function __construct(EndpointService $endpointService) {
        $this->endpointService = $endpointService;
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

        return view('models.endpoints.forms.create.' . strtolower($type), compact('connection', 'type', 'methods'));
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

        $connection = Connection::find($endpoint->connection_id);

        return view('models.endpoints.show', compact('endpoint', 'connection'));
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

        $methods = $this->endpointService->getMethods($endpoint->protocol);

        return view('models.endpoints.forms.edit.' . strtolower($endpoint->protocol), compact('endpoint', 'methods'));
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
}
