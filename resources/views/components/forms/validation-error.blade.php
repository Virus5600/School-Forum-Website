@props(['field'])

@error($field)
<span class="small badge text-bg-danger w-100 fs-2xs">
	{{ $message }}
</span>
@enderror
