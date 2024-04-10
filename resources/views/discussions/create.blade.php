@extends('layouts.public', ['noCarousel' => true])

@section('title', 'Discussions - Create New')

@section('content')
<div class="container-fluid body-container">
	<div class="d-flex flex-column flex-lg-row justify-content-start align-items-center gap-3">
		<a href="{{ $url }}" class="link-body-emphasis icon-link icon-link-hover text-decoration-none" style="--bs-icon-link-transform: translateX(-.25rem);">
			<i class="fas fa-chevron-left bi"></i>
			Go back to {{ $url == route('discussions.index') ? 'Discussions' : ($url == route('discussions.categories.index') ? 'Category' : ucwords($category) . " Category") }}
		</a>

		<div class="vr"></div>

		{{ Breadcrumbs::render() }}
	</div>

	<hr>

	{{-- HERO CONTENT --}}
	<hgroup class="d-flex flex-column">
		<h1 class="m-0 p-0 display-1">
			Start a new discussion
		</h1>
	</hgroup>

	{{-- FORM --}}
	<form action="{{ route('discussions.store') }}" class="card my-5" method="POST" enctype="multipart/form-data">
		@csrf
		@method('POST')

		{{-- BODY --}}
		<div class="card-body">
			{{-- Title --}}
			<div class="form-group my-3">
				<label for="title" class="form-label required-after">Title</label>

				<input type="text" name="title" id="title" class="form-control {{ $errors->count() > 0 ? ($errors->has('title') ? 'is-invalid' : 'is-valid') : '' }}" value="{{ old("title") }}" required>

				<x-forms.validation-error field="title" />
			</div>

			{{-- Category --}}
			<div class="form-group my-3 ui-widget">
				<label for="category" class="form-label required-after">Category</label>

				<input type="text" name="category" id="category" class="form-control autocomplete {{ $errors->count() > 0 ? ($errors->has('title') ? 'is-invalid' : 'is-valid') : '' }}"
					value="{{ old('category') ?? ucwords($category) }}"
					{{-- list="categories" --}}
					data-autocomplete-source="#categories"
					required
					>

				<datalist id="categories">
					@foreach ($categories as $category)
					<option>{{ ucwords($category->name) }}</option>
					@endforeach
				</datalist>

				<x-forms.validation-error field="category" />
			</div>

			{{-- Content --}}
			<div class="form-group my-3">
				{{-- Label --}}
				<label for="content" class="form-label required-after">Content</label>

				{{-- Editor - Content --}}
				<div id="editor" class="h-100 p-0 form-control {{ $errors->count() > 0 ? ($errors->has('content') ? 'is-invalid' : 'is-valid') : '' }}"
					data-ui-placeholder="Start a Discussion..."
					>
					{!! nl2br(old("content")) !!}
				</div>

				{{-- Actual Input --}}
				<textarea name="content" id="content-input" class="visually-hidden" required>{!! nl2br(old("content")) !!}</textarea>

				{{-- Error Message --}}
				<x-forms.validation-error field="content" />
			</div>
		</div>

		{{-- FOOTER --}}
		<div class="card-footer">
			<div class="hstack justify-content-end column-gap-3">
				{{-- SUBMIT --}}
				<button type="submit" class="btn btn-it-primary" data-dos-action="submit" data-dos-disabled-label="Posting">Post</button>

				{{-- CANCEL --}}
				<button class="btn btn-it-secondary text-light" data-cl-leave data-cl-leave-href="{{ route("discussions.index") }}">Cancel</button>
			</div>
		</div>
	</form>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{ mix('views/discussions/autocomplete.js') }}"></script>
<script type="text/javascript" src="{{ mix('views/discussions/show-text-editor.js') }}"></script>
<script type="text/javascript" src="{{ mix('js/util/confirm-leave.js') }}"></script>
<script type="text/javascript" src="{{ mix('js/util/disable-on-submit.js') }}"></script>
@endpush
