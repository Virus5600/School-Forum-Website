@extends('layouts.admin')

@section('title', 'Reported Contents')

@php
$isDiscussion = $report->reportable_type == 'discussion';
@endphp

@section('content')
{{-- TITLE --}}
<h1>Reported Contents</h1>

{{-- BREADCRUMBS --}}
<hr>
{{ Breadcrumbs::render() }}

{{-- ACTUAL CONTENTS --}}

<div class="container-fluid mt-5">
	<div class="card {{ ($isDiscussion ? 'floating-header' : '') . ' floating-footer' }}">
		@if ($isDiscussion)
		<div class="card-header bg-white border rounded">
			<h2 class="card-title">
				{{ $report->reportable->title }}
			</h2>
		</div>
		@endif

		<div class="card-body">
			{{-- TODO: ADD THE CONTENTS --}}
		</div>
	</div>
</div>
@endsection

@push('css')
	<link rel="stylesheet" href="{{ mix('css/widget/card-widget.css') }}">
@endpush
