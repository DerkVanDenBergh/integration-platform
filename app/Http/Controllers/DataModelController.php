<?php

namespace App\Http\Controllers;

use App\Models\DataModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

use App\Services\DataModelService;
use App\Services\DataModelFieldService;

class DataModelController extends Controller
{

    protected $dataModelService;
    protected $fieldService;

    public function __construct(DataModelService $dataModelService, DataModelFieldService $fieldService) {
        $this->dataModelService = $dataModelService;
        $this->fieldService = $fieldService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = $this->dataModelService->findAllFromUser(auth()->user()->id);
        
        return view('models.datamodels.index', compact('models'));
    }

   /**
    * Show the form for selecting a new resource via the wizard.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
       $options = $this->dataModelService->getOptions();
       
       return view('models.datamodels.wizard', compact('options'));
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

        return view('models.datamodels.' . $validatedData['option']);
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
            'title' => ['required', Rule::unique('data_models')->where('user_id', auth()->user()->id), 'max:255'],
            'description' => ['required', 'string', 'max:255']
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        $model = $this->dataModelService->store($validatedData);

        return redirect('/models/' . $model->id)->with('success', 'Model with name "' . $model->title . '" has succesfully been created!');
    }

    /**
     * Store a newly created resource in storage created from a template.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function definition(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', Rule::unique('data_models')->where('user_id', auth()->user()->id), 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'definition' => ['required', 'json']
        ]);

        $validatedData['user_id'] = auth()->user()->id;
        
        $model = $this->dataModelService->store($validatedData);

        $this->fieldService->createFieldsFromDefinition($validatedData['definition'], $model);

        return redirect('/model/' . $model->id)->with('success', 'Model with name "' . $model->title . '" has succesfully been created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DataModel  $model
     * @return \Illuminate\Http\Response
     */
    public function show(DataModel $model)
    {
        Gate::authorize('mutate_or_view_data_model', $model);

        $fields = $this->fieldService->findAllFromModel($model->id);

        return view('models.datamodels.show', compact('model', 'fields'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DataModel  $model
     * @return \Illuminate\Http\Response
     */
    public function edit(DataModel $model)
    {
        Gate::authorize('mutate_or_view_data_model', $model);

        return view('models.datamodels.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DataModel  $model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DataModel $model)
    {
        Gate::authorize('mutate_or_view_data_data_model', $model);

        $validatedData = $request->validate([
            'title' => ['required', Rule::unique('data_models')->where('user_id', auth()->user()->id)->ignore($model->id), 'max:255'],
            'description' => ['required', 'string', 'max:255']
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        $model = $this->dataModelService->update($validatedData, $model);

        return redirect('/models')->with('success', 'Model with name "' . $model->title . '" has succesfully been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DataModel  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy(DataModel $model)
    {
        Gate::authorize('mutate_or_view_data_model', $model);

        $this->dataModelService->delete($model);

        return redirect('/models')->with('success', 'Model with name "' . $model->title . '" has succesfully been deleted!');
    }
}
