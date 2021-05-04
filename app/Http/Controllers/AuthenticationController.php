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
        $options = collect([
            (object) [
                'option' => 'key',
                'label' => 'Create an API key authentication.'
            ],
            (object) [
                'option' => 'token',
                'label' => 'Create an API token authentication.'
            ],
            (object) [
                'option' => 'basic',
                'label' => 'Create an username and password authentication.'
            ]
        ]);
        
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
        
        switch($type) {
            case 'key':
                $view = 'key';
                break;
            case 'token':
                $view = 'token';
                break;
            case 'basic':
                $view = 'basic';
                break;
            default:
                $view = 'basic';
                break;
        };

        return view('models.authentications.forms.create.' . $view, compact('connection', 'type'));
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
            'username' => ['required_if:type,==,basic', 'nullable'],
            'password' => ['required_if:type,==,basic', 'nullable'],
            'key' => ['required_if:type,==,key', 'nullable'],
            'token' => ['required_if:type,==,token', 'nullable']
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

        switch($authentication->type) {
            case 'key':
                $view = 'key';
                break;
            case 'token':
                $view = 'token';
                break;
            case 'basic':
                $view = 'basic';
                break;
            default:
                $view = 'basic';
                break;
        };

        return view('models.authentications.forms.edit.' . $view, compact('authentication'));
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
            'username' => ['required_if:type,==,basic', 'nullable'],
            'password' => ['required_if:type,==,basic', 'nullable'],
            'key' => ['required_if:type,==,key', 'nullable'],
            'token' => ['required_if:type,==,token', 'nullable'],
            'connection_id' => ['required']
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
