<!-- text input -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}: </label> <span>{{ old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '' }}</span>
    @include('crud::inc.field_translatable_icon')

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p> --}}
    @endif
</div>

{{-- FIELD EXTRA CSS  --}}
{{-- push things in the after_styles section --}}

    {{-- @push('crud_fields_styles')
        <!-- no styles -->
    @endpush --}}


{{-- FIELD EXTRA JS --}}
{{-- push things in the after_scripts section --}}

    {{-- @push('crud_fields_scripts')
        <!-- no scripts -->
    @endpush --}}


{{-- Note: you can use @if ($crud->checkIfFieldIsFirstOfItsType($field, $fields)) to only load some CSS/JS once, even though there are multiple instances of it --}}
