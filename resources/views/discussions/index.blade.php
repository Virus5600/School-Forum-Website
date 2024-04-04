@extends('layouts.public')

@section('title', 'Lost & Found')

@section('content')
<div class="container-fluid body-container">
	{{ Breadcrumbs::render() }}
	<hr>

	{{-- HERO CONTENT --}}
	<hgroup class="d-flex flex-column">
		<h1 class="m-0 p-2 display-1">Discussions</h1>
	</hgroup>

	{{-- TOP PAGINATOR --}}
	{{ $discussions->onEachSide(-1)->links() }}

	{{-- DISCUSSIONS --}}
	<div class="row row-cols-1 {{ request()->has('category') ? '' : 'row-cols-lg-2' }} row-gap-3 my-3">
		@if ($hasCat)
			<x-discussions.discussions :value="$discussions" category="{{ $category }}"/>
		@else
			@forelse($discussions as $value)
				@if (!$value->discussions->isEmpty())
				<x-discussions.categories :value="$value"/>
				@endif
			@empty
			<div class="col w-100">
				<div class="card text-bg-dark">
					<img src="{{ asset("uploads/discussions/default.png") }}" alt="Lost and Found's default background image." class="card-img brightness-1">
					<div class="card-img-overlay has-backdrop-blur active d-flex flex-column justify-content-center align-items-center">
						<i class="fas fa-box-open fa-3x"></i>
						<h3 class="card-title m-0">No Discussions Yet...</h3>
					</div>
				</div>
			</div>
			@endforelse
		@endif
	</div>

	{{-- BOT PAGINATOR --}}
	{{ $discussions->onEachSide(-1)->links() }}
</div>
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ mix('css/widget/card-widget.css') }}">
@endpush
