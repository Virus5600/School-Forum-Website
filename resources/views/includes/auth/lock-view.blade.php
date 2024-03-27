@php
$posAbs = "position-absolute posabs-vertical-middle posabs-outerright ";
if (!isset($absolutePosition)) $absolutePosition = true;
@endphp

{{-- LOCK/UNLOCK VIEW --}}
<span id="lock-view" class="{{ $absolutePosition ? $posAbs : "" }}fs-5 ms-auto my-auto p-3 unlocked">
	{{-- UNLOCK ICON --}}
	<button class="remove-button-style p-3 fa-lock-open" type="button" data-bs-title="Toggle to lock view" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="it-tooltip" aria-title="Toggle to lock view">
		<i class="fas fa-lock-open"></i>
	</button>

	{{-- LOCK ICON --}}
	<button class="remove-button-style p-3 fa-lock"  type="button" data-bs-title="Toggle to unlock view" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="it-tooltip" aria-title="Toggle to unlock view">
		<i class="fas fa-lock"></i>
	</button>
</span>

@push('css')
	<link rel="stylesheet" type="text/css" href="{{ mix('views/includes/lock-view/lock-view.css') }}" nonce="{{ csp_nonce() }}">
@endpush

@push('scripts')
	<script type="text/javascript" src="{{ mix('views/includes/lock-view/lock-view.js') }}" nonce="{{ csp_nonce() }}"></script>
@endpush
