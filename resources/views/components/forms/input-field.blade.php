@props(['name', 'type' => 'text', 'value' => '', 'required' => false])

@php ($required = $required == "true" ? true : false)

<input
	type="{{ $type }}"
	class="form-control py-1 {{ $errors->count() > 0 ? ($errors->has($name) ? 'is-invalid' : 'is-valid') : '' }}"
	name="{{ $name }}"
	id="{{ $name }}"
	value="{{ $value }}"
	{{ $required ? 'required' : '' }}
	>
