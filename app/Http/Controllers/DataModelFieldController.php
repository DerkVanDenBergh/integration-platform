<?php

namespace App\Http\Controllers;

use App\Models\DataModelField;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

use App\Services\DataModelFieldService;

class DataModelFieldController extends Controller
{

    protected $fieldService;

    public function __construct(DataModelFieldService $fieldService) {
        $this->fieldService = $fieldService;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($model)
    {
        $fields = $this->fieldService->findAllParentsFromModel($model);

        $fields->prepend((object) ['id' => '', 'name' => '']);

        $node_types = $this->fieldService->getNodeTypes();

        $data_types = $this->fieldService->getDataTypes();
        
        return view('models.fields.create', compact('model', 'fields', 'node_types', 'data_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($model, Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', Rule::unique('data_model_fields')->where('model_id', $model)->where('parent_id', $request->get('parent_id')), 'max:255'],
            'parent_id' => ['nullable'],
            'node_type' => ['required'],
            'data_type' => ['required_if:node_type,==,attribute']
        ]);

        if(($validatedData['node_type'] != 'attribute') && ($request->get('data_type') != null)) {
            throw ValidationException::withMessages(['data_type' => 'Fill in data type only when using attributes.']);
        }

        $validatedData['model_id'] = $model;

        $field = $this->fieldService->store($validatedData);

        return redirect('/models/' . $field->model_id)->with('success', 'Field with name "' . $field->name . '" has succesfully been created!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DataModelField  $field
     * @return \Illuminate\Http\Response
     */
    public function edit(DataModelField $field)
    {
        Gate::authorize('mutate_or_view_data_model_field', $field);

        $fields = $this->fieldService->findAllParentsFromModel($field->model_id);

        $fields->prepend((object) ['id' => '', 'name' => '']);

        $node_types = $this->fieldService->getNodeTypes();

        $data_types = $this->fieldService->getDataTypes();
        
        return view('models.fields.edit', compact('field', 'fields', 'node_types', 'data_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DataModelField  $field
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DataModelField $field)
    {
        Gate::authorize('mutate_or_view_data_model_field', $field);

        $validatedData = $request->validate([
            'name' => ['required', Rule::unique('data_model_fields')->where('model_id', $field->model_id)->where('parent_id', $request->get('parent_id'))->ignore($field->id), 'max:255'],
            'parent_id' => ['nullable'],
            'node_type' => ['required'],
            'data_type' => ['required_if:node_type,==,attribute']
        ]);

        if(($validatedData['node_type'] != 'attribute') && ($request->get('data_type') != null)) {
            throw ValidationException::withMessages(['data_type' => 'Fill in data type only when using attributes.']);
        }

        $validatedData['model_id'] = $field->model_id;

        $field = $this->fieldService->update($validatedData);

        return redirect('/models/' . $field->model_id)->with('success', 'Field with name "' . $field->name . '" has succesfully been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DataModelField  $field
     * @return \Illuminate\Http\Response
     */
    public function destroy(DataModelField $field)
    {
        Gate::authorize('mutate_or_view_data_model_field', $field);

        $this->fieldService->delete($field);

        return redirect('/models/' . $field->model_id)->with('success', 'Field with name "' . $field->name . '" has succesfully been deleted!');
    }
}
