<?php

namespace App\Http\Controllers;

use App\Models\Authentication;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

use App\Services\AuthenticationService;

class AuthenticationController extends Controller
{
    protected $authService;

    public function __construct(AuthenticationService $authService) {
        $this->authService = $authService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authentications = $this->authService->findAllFromUser(auth()->user()->id);

        return view('models.authentications.index', compact('authentications'));
    }

    /**
     * Show the form for selecting a new resource via the wizard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($connection)
    {
        $options = $this->authService->getAuthTypes();
        
        return view('models.authentications.wizard', compact('options', 'connection'));
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

        return view('models.authentications.create', compact('connection', 'type'));
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
            'title' => ['required', Rule::unique('authentications')->where('connection_id', $connection), 'max:255'],
            'type' => ['required', 'string', 'max:50'],
            'username' => ['required_if:type,==,basic|nullable'],
            'password' => ['required_if:type,==,basic|nullable'],
            'token' => ['required_if:type,==,token|nullable'],
            'oauth1_consumer_key' => ['required_if:type,==,oauth1|nullable'],
            'oauth1_consumer_secret' => ['required_if:type,==,oauth1|nullable'],
            'oauth1_token' => ['required_if:type,==,oauth1|nullable'],
            'oauth1_token_secret' => ['required_if:type,==,oauth1|nullable']

        ]);

        $validatedData['connection_id'] = $connection;

        $authentication = $this->authService->store($validatedData);

        return redirect('/connections/' . $authentication->connection_id)->with('success', 'Authentication with name "' . $authentication->title . '" has succesfully been created!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Authentication  $authentication
     * @return \Illuminate\Http\Response
     */
    public function edit(Authentication $authentication)
    {
        Gate::authorize('mutate_or_view_authentication', $authentication);

        return view('models.authentications.edit', compact('authentication'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Authentication  $authentication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Authentication $authentication)
    {
        Gate::authorize('mutate_or_view_authentication', $authentication);

        $validatedData = $request->validate([
            'title' => ['required', Rule::unique('authentications')->where('connection_id', $authentication->connection_id)->ignore($authentication->id), 'max:255'],
            'type' => ['required', 'string', 'max:50'],
            'username' => ['required_if:type,==,basic|nullable'],
            'password' => ['required_if:type,==,basic|nullable'],
            'token' => ['required_if:type,==,token|nullable'],
            'oauth1_consumer_key' => ['required_if:type,==,oauth1|nullable'],
            'oauth1_consumer_secret' => ['required_if:type,==,oauth1|nullable'],
            'oauth1_token' => ['required_if:type,==,oauth1|nullable'],
            'oauth1_token_secret' => ['required_if:type,==,oauth1|nullable']
        ]);

        $authentication = $this->authService->update($validatedData, $authentication);

        return redirect('/connections/' . $authentication->connection_id)->with('success', 'Authentication with name "' . $authentication->title . '" has succesfully been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Authentication  $authentication
     * @return \Illuminate\Http\Response
     */
    public function destroy(Authentication $authentication)
    {
        Gate::authorize('mutate_or_view_authentication', $authentication);

        $this->authService->delete($authentication);

        redirect('/connections/' . $authentication->connection_id)->with('success', 'Authentication with name "' . $authentication->title . '" has succesfully been deleted!');
    }
}
