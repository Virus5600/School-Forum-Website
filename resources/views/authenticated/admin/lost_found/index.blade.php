@extends('layouts.admin')

@section('title', 'Lost & Found')

@php
	$user = auth()->user();
	$allowed = [
		"create" => $user->hasPermission('lost_and_found_tab_create'),
		"edit" => $user->hasPermission('lost_and_found_tab_edit'),
		"status" => $user->hasPermission('lost_and_found_tab_status'),
		"archive" => $user->hasPermission('lost_and_found_tab_archive'),
		"unarchive" => $user->hasPermission('lost_and_found_tab_unarchive'),
		"delete" => $user->hasPermission('lost_and_found_tab_delete'),
	]
@endphp

@section('content')
<div class="vstack min-h-100 table-responsive-container">
	{{-- HEADER --}}
	<div class="row">
		<div class="col-12 my-3">
			<div class="row">
				{{-- Title --}}
				<div class="col-12 col-md-4">
					<h1>Lost and Found</h1>
				</div>

				{{-- Controls --}}
				<div class="col-12 col-md-8 hstack column-gap-1 column-gap-md-3 justify-content-center justify-content-md-end">
					{{-- ADD --}}
					@if ($allowed['create'])
					<x-admin.add-item route="{{ route('admin.lost-and-found.create') }}" />
					@endif

					{{-- SEARCH --}}
					<x-admin.search route="{{ url()->full() }}" search="{{ $search }}" />
				</div>
			</div>
		</div>
	</div>

	<hr>

	{{-- TABLE --}}
	<x-admin.table columns="{!! json_encode($columns) !!}" sortable="true">
		@forelse($items as $i)
		<tr>
			{{-- ITEM --}}
			<td>{{ $i->item_found }}</td>

			{{-- DESCRIPTION --}}
			<td>{{ Str::limit($i->item_description, 25) }}</td>

			{{-- FOUNDER --}}
			<td>{{ $i->founder_name }}</td>

			{{-- FOUND AT --}}
			<td>{{ $i->place_found }}</td>

			{{-- FOUND ON --}}
			<td>{{ Carbon::parse("{$i->date_found} {$i->time_found}")->format("(D) M d, Y h:i A") }}</td>

			{{-- OWNER --}}
			<td>{{ $i->owner_name }}</td>

			{{-- STATUS --}}
			<td>
				@if ($i->trashed())
				<span class="badge bg-secondary">Archived</span>
				@else
					@if ($i->status === 'found')
					<span class="badge bg-success">Claimed</span>
					@else
					<span class="badge bg-danger">Unclaimed</span>
					@endif
				@endif
			</td>

			{{-- ACTION(S) --}}
			<td>
				<div class="dropdown">
					<button class="btn btn-it-primary btn-sm text-light dropdown-toggle" type="button" data-bs-toggle="dropdown" id="dropdown-{{ $i->id }}" aria-haspopup="true" aria-expanded="false">
						Actions
					</button>

					<div class="dropdown-menu dropdown-menu-right bg-it-secondary" aria-labelledby="dropdown-{{ $i->id }}">
						{{-- VIEW --}}
						<a href="{{ route('admin.lost-and-found.show', [$i->id]) }}" class="dropdown-item text-light"><i class="fas fa-eye me-2"></i>View</a>

						{{-- EDIT --}}
						@if ($allowed['edit'])
						@endif

						{{-- STATUS --}}
						@if ($allowed['status'])
						@endif

						{{-- ARCHIVE --}}
						@if ($allowed['archive'])
						@endif

						{{-- UNARCHIVE --}}
						@if ($allowed['unarchive'])
						@endif

						{{-- DELETE --}}
						@if ($allowed['delete'])
						<div class="dropdown-item text-light">
							<form action="{{ route('admin.lost-and-found.destroy', [$i->id]) }}" method="POST">
								@csrf
								@method('DELETE')

								<input type="hidden" name="search" value="{{ $search }}">
								<input type="hidden" name="page" value="{{ $page }}">
								<input type="hidden" name="sort" value="{{ $sort }}">
								<input type="hidden" name="direction" value="{{ $direction }}">

								<button type="submit" class="a remove-button-style">
									<i class="fas fa-trash me-2"></i>Delete
								</button>
							</form>
						</div>
						@endif
					</div>
				</div>
			</td>
		</tr>
		@empty
		<tr>
			<td colspan="{{ count($columns) }}" class="text-center">No items found.</td>
		</tr>
		@endforelse

		@slot('pagination')
			{{ $items->links() }}
		@endslot
	</x-admin.table>
</div>
@endsection
