@props(['route', 'search' => ""])

<div class="text-center text-md-right my-2 my-md-auto d-flex">
	<form method="GET" action="{{ $route }}" enctype="multipart/form-data">
		<div class="input-group">
			<input type='search' name="search" placeholder="Press / to search" class="form-control" id="search" aria-label="Search" accesskey="/" value="{{ $search }}"/>
			<button type="submit" class="btn btn-it-secondary text-white" data-dos-action="icon-search">
				<i class="fas fa-search" aria-hidden="true"></i>
			</button>
		</div>
	</form>
</div>

@push('scripts')
<script type="text/javascript" src="{{ mix('js/util/disable-on-submit.js') }}"></script>
@endpush
