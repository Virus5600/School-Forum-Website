@extends('layouts.public')

@section('title', 'Lost & Found - ' . $item->item)

@section('content')
<div class="container-fluid body-container">
	{{-- BREADCRUMBS --}}
	{{ Breadcrumbs::render() }}

	<hr>

	<div class="row position-relative row-gap-3">
		{{-- CONTENTS --}}
		<article class="col-12 col-md-9 d-flex flex-column row-gap-3 row-gap-sm-5">
			{{-- HERO CONTENT --}}
			<hgroup class="d-flex flex-column row-gap-3 text-center">
				<h1 class="m-0 p-2 display-1">Lost Item: {{ Str::title($item->item_found) }}</h1>

				<img src="{{ $item->getImage("url") }}"
					alt="{{ $item->getImage("filename") }}"
					class="rounded mx-auto w-100 w-sm-50"
					draggable="false">
			</hgroup>

			{{-- Content --}}
			<section class="card floating-header text-dark">
				<div class="card-header border border-2 rounded bg-it-quaternary">
					<h2 class="m-0">Item Details</h2>
				</div>

				<div class="card-body border rounded bg-it-quaternary">
					<div class="row row-gap-3">
						{{-- Location --}}
						<div class="col-12 col-md-4 order-1 order-md-0">
							<h3>Found At</h3>
							<p>{{ $item->place_found }}</p>
						</div>

						{{-- Date Found --}}
						<div class="col-12 col-md-4 order-2 order-md-1">
							<h3>Date and Time Found</h3>
							<p>{{ Carbon::parse("{$item->date_found} {$item->time_found}")->format("(D) M d, Y h:i A") }}</p>
						</div>

						{{-- Item Details --}}
						<div class="col-12 order-0 order-md-3">
							<h3>Description</h3>
							<p>{{ $item->item_description }}</p>
						</div>
					</div>
				</div>
			</section>
		</article>

		{{-- Instructions to Receive --}}
		<section class="col-12 col-md-3 pb-4">
			<div class="card floating-header h-100">
				<div class="card-header border border-2 rounded bg-it-quaternary">
					<h2 class="m-0">Instructions</h2>
				</div>

				<div class="card-body border rounded bg-it-quaternary">
					{!! Str::of($instructions)->markdown() !!}
				</div>
			</div>
		</section>
	</div>
</div>
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ mix('css/widget/card-widget.css') }}">
@endpush
