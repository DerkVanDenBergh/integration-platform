<?php

namespace App\Http\Controllers;

use App\Models\Endpoint;
use Illuminate\Http\Request;

use App\Services\EndpointService;

class EndpointController extends Controller
{
    protected $endpointService;

    public function __construct(EndpointService $endpointService) {
        $this->endpointService = $endpointService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $endpoints = $this->endpointService->findAllFromUser(auth()->user()->id);
        
        return view('models.endpoints.index', compact('endpoints'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($connection)
    {
        return view('models.endpoints.create', compact('connection'));
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
            'title' => ['required', Rule::unique('endpoints')->where('connection_id', $endpoint->connection_id), 'max:255'],
            'endpoint' => ['required', Rule::unique('endpoints')->where('connection_id', $endpoint->connection_id), 'max:255'],
            'protocol' => ['required'],
            'method' => ['required']
        ]);

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

        return view('models.endpoints.view', compact('endpoint'));
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

        return view('models.endpoints.edit', compact('endpoint'));
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
            'title' => ['required', Rule::unique('endpoints')->where('connection_id', $endpoint->connection_id)->ignore($endpoint->id), 'max:255'],
            'endpoint' => ['required', Rule::unique('endpoints')->where('connection_id', $endpoint->connection_id)->ignore($endpoint->id), 'max:255'],
            'protocol' => ['required'],
            'method' => ['required'],
            'connection_id' => ['required']
        ]);

        $endpoint = $this->endpointService->update($validatedData);

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

        redirect('/connections/' . $endpoint->connection_id)->with('success', 'Endpoint with name "' . $endpoint->title . '" has succesfully been deleted!');
    }
}
