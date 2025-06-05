@props([
    'name',
    'id' => null,
    'options' => [],
    'value' => null,
    'required' => false,
    'disabled' => false,
])

<select
    name="{{ $name }}"
    @if($id) id="{{ $id }}" @endif
    @if($required) required @endif
    @if($disabled) disabled @endif
    {{ $attributes->merge(['class' => 'rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full']) }}
>
    @foreach($options as $optionValue => $optionLabel)
        <option value="{{ $optionValue }}" @selected($optionValue == $value)>{{ $optionLabel }}</option>
    @endforeach
</select>
