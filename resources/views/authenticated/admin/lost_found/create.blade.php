@extends('layouts.admin')

@section('title', 'Lost & Found')

@section('content')
<div class="row">
	<div class="col-12 col-md mt-3">
		<h1>
			<button type="button" class="link-body-emphasis text-dark text-decoration-none fw-normal remove-button-style" data-cl-leave data-cl-leave-href="{{ route('admin.lost-and-found.index') }}">
				<i class="fas fa-chevron-left me-2"></i>Lost and Found
			</button>
		</h1>
	</div>
</div>

<hr class="border-3">

<form action="{{ route('admin.lost-and-found.store') }}" method="POST" class="form required-affect-all required-danger" enctype="multipart/form-data">
	@csrf

	{{-- HIDDEN PARAMS --}}
	<input type="hidden" name="search" value="{{ $search }}">
	<input type="hidden" name="page" value="{{ $page }}">
	<input type="hidden" name="sort" value="{{ $sort }}">
	<input type="hidden" name="direction" value="{{ $direction }}">


	{{-- FOUND INFORMATION --}}
	<div class="container-fluid py-3">
		<div class="card floating-header">
			<div class="card-header bg-light rounded border">
				<h2 class="card-title">Found Information</h2>
			</div>

			<div class="card-body">
				<p class="card-text">
					Information relating to where, when, and who found the item.
				</p>

				<div class="row gap-3 gap-md-0">
					{{-- FOUNDER NAME --}}
					<div class="col-12 col-md-6 form-group">
						<label for="founder_name" class="form-label required-after">Found By</label>
						<input type="text" name="founder_name" id="founder_name" class="form-control {{ $errors->count() > 0 ? ($errors->has('founder_name') ? 'is-invalid' : 'is-valid') : '' }}" value="{{ old('founder_name') }}" required>
						<x-forms.validation-error field="founder_name"></x-forms.validation-error>
					</div>

					{{-- DATE FOUND --}}
					<div class="col-12 col-md-3 form-group">
						<label for="date_found" class="form-label required-after">Found Date</label>
						<input type="date" name="date_found" id="date_found" class="form-control {{ $errors->count() > 0 ? ($errors->has('date_found') ? 'is-invalid' : 'is-valid') : '' }}" value="{{ old('date_found') }}" required>
						<x-forms.validation-error field="date_found"/>
					</div>

					{{-- TIME FOUND --}}
					<div class="col-12 col-md-3 form-group">
						<label for="time_found" class="form-label required-after">Found Time</label>
						<input type="time" name="time_found" id="time_found" class="form-control {{ $errors->count() > 0 ? ($errors->has('time_found') ? 'is-invalid' : 'is-valid') : '' }}" value="{{ old('time_found') }}" required>
						<x-forms.validation-error field="time_found"/>
					</div>

					{{-- PLACE FOUND --}}
					<div class="col-12 form-group">
						<label for="place_found" class="form-label required-after">Found At</label>
						<input type="text" name="place_found" id="place_found" class="form-control {{ $errors->count() > 0 ? ($errors->has('place_found') ? 'is-invalid' : 'is-valid') : '' }}" value="{{ old('place_found') }}" required>
						<x-forms.validation-error field="place_found"/>
					</div>
				</div>
			</div>
		</div>
	</div>

	{{-- ITEM INFORMATION --}}
	<div class="container-fluid py-3">
		<div class="card floating-header">
			<div class="card-header bg-light rounded border">
				<h2 class="card-title">Item Information</h2>
			</div>

			<div class="card-body">
				<p class="card-text">
					Information relating to the item found. This includes an image of the item
					found, a description of the item, and the owner of the item.
				</p>

				<div class="row gap-3 gap-md-0">
					{{-- ITEM IMAGE --}}
					<div class="col-12 col-md-6 p-2">
						<label for="item_image" class="form-label h2 text-center w-100">Item Image</label>

						{{-- Image Input Start --}}
						<div class="image-input-scope drag-drop rounded" id="image-scope" data-fallback-img="{{ asset('uploads/lost-and-found/default-icon.png') }}">
							{{-- FILE IMAGE --}}
							<div class="form-group text-center image-input collapse show" id="image-input-wrapper">
								<div class="h-100 row py-2 mx-1">
									<div class="col-12 col-lg-8 form-control justify-content-start position-relative w-auto bg-transparent {{ $errors->count() > 0 ? ($errors->has('item_image') ? 'is-invalid' : 'is-valid') : '' }}">
										{{-- HOVER CAM --}}
										<div class="hover-cam mx-auto input-avatar rounded overflow-hidden border border-lg-0" style="--input-avatar-size: 15rem;">
											<img src="{{ asset('uploads/lost-and-found/default-icon.png') }}" class="hover-zoom img-fluid input-avatar" id="image-file-container" alt="User Avatar" data-default-src="{{ asset('uploads/lost-and-found/default-icon.png') }}">
											<span class="icon text-center image-input-float" id="item_image" tabindex="0">
												<i class="fas fa-camera text-white hover-icon-2x" tabindex="-1"></i>
											</span>

											{{-- DRAG-DROP OVERLAY --}}
											<div class="drag-drop-overlay animated rounded-circle overflow-hidden border-0">
												<i class="fas fa-upload 2x text-white"></i>
											</div>
										</div>


										{{-- ACTUAL INPUTS --}}
										<input type="file" tabindex="-1" name="item_image" id="item_image" class="d-none sr-only" accept=".jpg,.jpeg,.png,.webp" data-target-image-container="#image-file-container" data-target-name-container="#image-name" >
										<h6 id="image-name" class="text-truncate w-50 mx-auto text-center" data-default-name="default.png">default.png</h6>
									</div>

									<div class="col-12 col-lg-4 text-lg-start vstack gap-3 justify-content-center align-items-center">
										<hr class="d-block d-lg-none w-100 border-3 opacity-75">

										<small class="p text-center">
											<b>INSTRUCTIONS:</b>
											<br>Click the camera icon to upload an image.
										</small>

										<small class="pb-0 mb-0">
											<b>ALLOWED FORMATS:</b>
											<br>JPEG, JPG, PNG, WEBP
										</small>
										<small class="pt-0 mt-0"><b>MAX SIZE:</b> 5MB</small>
										<button type="button" class="btn btn-it-primary btn-sm image-input-reset" data-target-image-container="#image-file-container" data-target-name-container="#image-name">Remove Image</button>

										{{-- AVATAR ERROR --}}
										<x-forms.validation-error field="item_image"/>
									</div>
								</div>
							</div>
						</div>
						{{-- Image Input End --}}
					</div>

					<div class="col-12 col-md-6 p-2">
						<div class="vstack gap-2">
							{{-- ITEM FOUND --}}
							<div class="form-group">
								<label for="item_found" class="form-label required-after">Item Found</label>
								<input type="text" name="item_found" id="item_found" class="form-control {{ $errors->count() > 0 ? ($errors->has('item_found') ? 'is-invalid' : 'is-valid') : '' }}" value="{{ old('item_found') }}" required>
								<x-forms.validation-error field="item_found"/>
							</div>

							{{-- ITEM DESCRIPTION --}}
							<div class="form-group">
								<label for="item_description" class="form-label required-after">Item Description</label>
								<div id="editor" class="h-100 p-0 form-control {{ $errors->count() > 0 ? ($errors->has('item_description') ? 'is-invalid' : 'is-valid') : '' }}">
									{{ old('item_description') }}
								</div>
								<textarea name="item_description" id="item_description" class="visually-hidden" required>{{ old('item_description') }}</textarea>
								<x-forms.validation-error field="item_description"/>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="hstack gap-3 justify-content-center align-items-center">
		<button type="submit" class="btn btn-it-primary">Add Item</button>
		<button type="reset" class="btn btn-dark">Reset</button>
		<a href="{{ route('admin.lost-and-found.index', $params) }}" class="btn btn-secondary">Go Back</a>
	</div>
</form>
@endsection

@push('css')
	<link rel="stylesheet" href="{{ mix('css/widget/card-widget.css') }}">
	<link rel="stylesheet" href="{{ mix('css/util/image-input.css') }}">
@endpush

@push('scripts')
	<script type="text/javascript" src="{{ mix('views/authenticated/admin/lost-and-found/create.js') }}" defer></script>
	<script type="text/javascript" src="{{ mix('js/util/image-input.js') }}" defer></script>
	<script type="text/javascript" src="{{ mix('js/util/swal-flash.js') }}" defer></script>
@endpush
