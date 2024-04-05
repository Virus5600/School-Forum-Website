@props(['search' => ''])

<div class="input-group">
	<input type='search' name="search" placeholder="Press / to search" class="form-control" id="search" aria-label="Search" accesskey="/" value="{{ $search }}"/>
	<button type="submit" class="btn btn-it-secondary text-white" data-dos-action="icon-search">
		<i class="fas fa-search" aria-hidden="true"></i>
	</button>
</div>
