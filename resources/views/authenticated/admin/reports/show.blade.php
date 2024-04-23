@extends('layouts.admin')

@section('title', 'Reported Contents')

@php
use App\Enums\ReportStatus;
use App\Enums\ReportAction;

$isDiscussion = $report->reportable_type == 'discussion';
@endphp

@section('content')
{{-- TITLE --}}
<h1>Reported Contents</h1>

{{-- BREADCRUMBS --}}
<hr>
{{ Breadcrumbs::render() }}

{{-- ACTUAL CONTENTS --}}
<article class="container-fluid mt-5">
	<div class="card {{ ($isDiscussion ? 'floating-header' : '') . ' floating-footer' }} shadow-lg">
		@if ($isDiscussion)
		<hgroup class="card-header header-center shadow-lg bg-white border rounded">
			<h2 class="card-title">
				{{ $report->reportable->title }}
			</h2>
		</hgroup>
		@endif

		<div class="card-body">
			<div class="vstack row-gap-7">
				{{-- General Information --}}
				<div class="row row-gap-5">
					{{-- Reporter Information --}}
					<section class="col-12 col-md-6">
						<div class="card floating-header shadow-lg h-100">
							<hgroup class="card-header header-center header-md-start shadow-lg bg-white border rounded">
								<h3 class="card-title m-0">
									Reporter Information
								</h3>
							</hgroup>

							<div class="card-body">
								<div class="row row-gap-3">
									<div class="col-12 col-md-4">
										<div class="d-flex w-100">
											{!! $report->reportedBy->getAvatar(useDefault: true, additionalClasses: 'avatar h-50 h-md-100 w-50 w-md-100 border rounded-circle shadow-lg') !!}
										</div>
									</div>

									<div class="col-12 col-md-8 vstack justify-content-center">
										<div class="list-group shadow-lg">
											{{-- Username --}}
											<div class="list-group-item d-flex flex-row justify-content-between align-items-center">
												<h6>Username</h6>

												<span>{{ $report->reportedBy->username }}</span>
											</div>

											{{-- Join Date --}}
											<div class="list-group-item d-flex flex-row justify-content-between align-items-center">
												<h6>Joined At</h6>

												<span>{{ $report->reportedBy->created_at->timezone('Asia/Manila')->format("(D) M d, Y h:i A") }}</span>
											</div>

											{{-- Last Auth --}}
											<div class="list-group-item d-flex flex-row justify-content-between align-items-center">
												<h6>Last Online</h6>

												<span>{{ $report->reportedBy->last_auth->timezone('Asia/Manila')->format("(D) M d, Y h:i A") }}</span>
											</div>

											{{-- Verified Email --}}
											<div class="list-group-item d-flex flex-row justify-content-between align-items-center">
												<h6>Verified Email</h6>

												<span>
													@if ($report->reportedBy->is_verified)
														<i class="fas fa-check-circle text-success me-2"></i>
														Verified
													@else
														<i class="fas fa-times-circle text-danger me-2"></i>
														Not Verified
													@endif
												</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>

					{{-- Content Information --}}
					<section class="col-12 col-md-6">
						<div class="card floating-header shadow-lg h-100">
							<hgroup class="card-header header-center header-md-end shadow-lg bg-white border rounded">
								<h3 class="card-title m-0">
									Content Information
								</h3>
							</hgroup>

							<div class="card-body vstack justify-content-center">
								<div class="list-group shadow-lg">
									{{-- Content Type --}}
									<div class="list-group-item d-flex flex-row justify-content-between align-items-center">
										<h6>Content Type</h6>

										<span>{{ ucwords($report->reportable_type) }}</span>
									</div>

									{{-- Reported On --}}
									<div class="list-group-item d-flex flex-row justify-content-between align-items-center">
										<h6>Reported On</h6>

										<span>{{ $report->created_at->timezone('Asia/Manila')->format("(D) M d, Y h:i A") }}</span>
									</div>

									{{-- Status --}}
									<div class="list-group-item d-flex flex-row justify-content-between align-items-center">
										<h6>Status</h6>

										<span class="badge rounded-pill text-bg-{{ ReportStatus::fromValue($report->status)->getColors(true, true) }}">
											{{ ucwords($report->status) }}
										</span>
									</div>

									{{-- Action Taken --}}
									<div class="list-group-item d-flex flex-row justify-content-between align-items-center">
										<h6>Action Taken</h6>

										<span class="badge rounded-pill text-bg-{{ ReportAction::fromValue($report->action_taken)->getColors(true, true) }}">
											{{ ucwords($report->action_taken) }}
										</span>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>

				{{-- Context Information --}}
				<section class="card floating-header">
					<hgroup class="card-header header-center shadow-lg bg-white border rounded">
						<h3 class="card-title">
							Context Information
						</h3>
					</hgroup>

					<div class="card-body">
						{{-- Reason --}}
						<div>
							<h6 class="card-title m-0">Reason</h6>

							<p class="card-text text-indent-5">
								{{ $report->reason }}
							</p>
						</div>

						<hr class="border-2">

						<div class="list-group border shadow-lg">
							{{-- Discussion --}}
							@if ($isDiscussion)
								{{-- Title --}}
								<div class="list-group-item d-flex flex-row justify-content-between">
									<h6>Title</h6>

									<a href="{{ route('discussions.show', [$report->reportable->category->slug, $report->reportable->slug]) }}" class="icon-link icon-link-hover" style="--bs-icon-link-transform: scale(1.125);" title="Open in new tab" target="_blank">
										<i class="fas fa-up-right-from-square bi transition-2"></i>
										{{ $report->reportable->title }}
									</a>
								</div>

								{{-- Category --}}
								<div class="list-group-item d-flex flex-row justify-content-between">
									<h6>Category</h6>

									<a href="@{{ route('') }}" class="icon-link icon-link-hover" style="--bs-icon-link-transform: scale(1.125);" title="Open in new tab" target="_blank">
										<i class="fas fa-up-right-from-square bi transition-2"></i>
										{{ ucwords($report->reportable->category->name) }}
									</a>
								</div>

								{{-- Posted By --}}
								<div class="list-group-item d-flex flex-row justify-content-between">
									<h6>Author</h6>

									<a href="@{{ route('') }}" class="icon-link icon-link-hover" style="--bs-icon-link-transform: scale(1.125);" title="Open in new tab" target="_blank">
										<i class="fas fa-up-right-from-square bi transition-2"></i>
										{{ $report->reportable->postedBy->username }}
									</a>
								</div>

							{{-- Comment --}}
							@else
								<div class="list-group-item d-flex flex-row justify-content-between">
								</div>
							@endif
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
</article>
@endsection

@push('css')
	<link rel="stylesheet" href="{{ mix('css/widget/card-widget.css') }}">
@endpush
