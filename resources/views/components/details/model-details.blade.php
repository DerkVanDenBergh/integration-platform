

<div class="grid grid-cols-4 gap-4">
    {{ $fields }}
</div>

<x-buttons.link :active="__(true)" :action="__('/' . $resource . '/' . $model->id . '/edit')" :caption="__('Edit')" :icon="__('edit')"/>