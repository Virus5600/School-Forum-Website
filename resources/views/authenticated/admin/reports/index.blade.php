@extends('layouts.admin')

@section('title', 'Reported Contents')

@php
	use App\Enums\ReportAction;
	use App\Enums\ReportStatus;

	$user = auth()->user();
	$allowed = [
		'status' => $user->hasPermission('reports_tab_status'),
		'action' => $user->hasPermission('reports_tab_action'),
	];
@endphp

@section('content')
	<div class="vstack min-h-100 h-100 table-responsive-container">
		{{-- HEADER --}}
		<div class="row">
			<div class="col-12 my-3">
				<div class="row">
					{{-- Title --}}
					<div class="col-12 col-md-4">
						<h1>Reported Contents</h1>
					</div>

					{{-- Controls --}}
					<div class="col-12 col-md-8 hstack column-gap-1 column-gap-md-3 justify-content-center justify-content-md-end">
						{{-- SEARCH --}}
						<x-admin.search route="{{ url()->full() }}" search="{{ $search }}" />
					</div>
				</div>
			</div>
		</div>

		<hr>

		{{-- TABLE --}}
		<x-admin.table columns="{!! json_encode($columns) !!}" sortable="true">
			@forelse ($reports as $r)
				<tr>
					{{-- TYPE --}}
					<td>{{ ucwords($r->reportable_type) }}</td>

					{{-- REPORTED BY --}}
					<td>{{ $r->reportedBy->username }}</td>

					{{-- REASON --}}
					<td>{{ Str::limit($r->reason, 25) }}</td>

					{{-- STATUS --}}
					<td>
						<i class="fas fa-circle text-{{ ReportStatus::fromValue($r->status)->getColors(true, true) }} me-2"></i>
						{{ ucwords($r->status) }}
					</td>

					{{-- ACTION TAKEN --}}
					<td>
						<i class="fas fa-circle text-{{ ReportAction::fromValue($r->action_taken)->getColors(true, true) }} me-2"></i>
						{{ ucwords($r->action_taken) }}
					</td>

					{{-- REPORTED ON --}}
					<td>{{ Carbon::parse($r->created_at)->format('(D) M d, Y h:i A') }}</td>

					{{-- ACTIONS --}}
					<td>
						<div class="dropdown">
							<button class="btn btn-it-primary btn-sm text-light dropdown-toggle" type="button" data-bs-toggle="dropdown"
								id="dropdown-{{ $r->uuid }}" aria-haspopup="true" aria-expanded="false">
								Actions
							</button>

							<div class="dropdown-menu dropdown-menu-end bg-it-secondary" aria-labelledby="{{ $r->uuid }}">
								{{-- VIEW --}}
								<a href="{{ route('admin.reports.show', [$r->uuid]) }}" class="dropdown-item text-light">
									<i class="fas fa-eye me-2"></i>View
								</a>

								{{-- UPDATE STATUS --}}
								@if ($allowed['status'])
									<a href="{{ route('admin.reports.status', [$r->uuid]) }}" class="dropdown-item text-light">
										<i class="fas fa-magnifying-glass me-2"></i>Update Status
									</a>
								@endif

								{{-- UPDATE ACTION --}}
								@if ($allowed['action'])
									<a href="{{ route('admin.reports.action', [$r->uuid]) }}" class="dropdown-item text-light">
										<i class="fas fa-gavel me-2"></i>Update Action
									</a>
								@endif
							</div>
						</div>
					</td>
				</tr>
			@empty
				<tr>
					<td colspan="{{ count($columns) + 1 }}" class="text-center">No reports found.</td>
				</tr>
			@endforelse

			@slot('pagination')
				{{ $reports->links() }}
			@endslot
		</x-admin.table>
	</div>
@endsection
