<div class="sidebar collapse-horizontal text-bg-dark shadow-lg w-lg-auto" id="sidebar" aria-labelledby="sidebar-toggler" aria-expanded="false" data-bs-theme="dark">
	{{-- Navigatiopn Bar (SIDE) --}}
	<div class="sidebar-content d-flex flex-column py-3 px-0 overflow-y-auto bg-it-primary">
		{{-- DASHBOARD --}}
		@if (Request::is('admin/dashboard'))
		<span class="bg-it-secondary"><i class="fas fa-tachometer-alt me-2 col-2"></i>Dashboard</span>
		@elseif (Request::is('admin/dashboard*'))
		<a class="text-decoration-none bg-it-secondary aria-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-2 col-2"></i>Dashboard</a>
		@else
		<a class="text-decoration-none aria-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-2 col-2"></i>Dashboard</a>
		@endif

		{{-- REPORTS --}}

		{{-- TEACHER'S PANEL CONTROLS --}}
		{{-- <hr>
		<small class="ms-3"><small>Teacher's Panel</small></small> --}}

		{{-- WEBSITE CONTENT CONTROLS --}}
		<hr>
		<small class="ms-3"><small>Website Content</small></small>

		{{-- Lost and Found --}}
		@if (Request::is('admin/lost-and-found'))
		<span class="bg-it-secondary"><i class="fas fa-box-open me-2 col-2"></i>Lost and Found</span>
		@elseif (Request::is('admin/lost-and-found*'))
		<a class="text-decoration-none bg-it-secondary aria-link" href="{{ route('admin.lost-and-found.index') }}"><i class="fa fa-box-open me-2 col-2"></i>Lost and Found</a>
		@else
		<a class="text-decoration-none aria-link" href="{{ route('admin.lost-and-found.index') }}"><i class="fa fa-box-open me-2 col-2"></i>Lost and Found</a>
		@endif

		{{-- Reported Contents --}}
		@if (Request::is('admin/reported-contents'))
		<span class="bg-it-secondary"><i class="fas fa-triangle-exclamation me-2 col-2"></i>Reported Contents</span>
		@elseif (Request::is('admin/reported-contents*'))
		<a class="text-decoration-none bg-it-secondary aria-link" href="{{ route('admin.reports.index') }}"><i class="fas fa-triangle-exclamation me-2 col-2"></i>Reported Contents</a>
		@else
		<a class="text-decoration-none aria-link" href="{{ route('admin.reports.index') }}"><i class="fas fa-triangle-exclamation me-2 col-2"></i>Reported Contents</a>
		@endif

		{{-- ADMIN CONTROLS --}}
		<hr>
		<small class="ms-3"><small>Admin Controls</small></small>

		{{-- Users --}}
		@if (Request::is('admin/users'))
		<span class="bg-it-secondary"><i class="fas fa-users me-2 col-2"></i>Users</span>
		@elseif (Request::is('admin/users*'))
		<a class="text-decoration-none bg-it-secondary aria-link" href="@{{ route('admin.users.index') }}"><i class="fa fa-users me-2 col-2"></i>Users</a>
		@else
		<a class="text-decoration-none aria-link" href="@{{ route('admin.users.index') }}"><i class="fa fa-users me-2 col-2"></i>Users</a>
		@endif

		{{-- User Types --}}
		@if (Request::is('admin/user-types'))
		<span class="bg-it-secondary"><i class="fas fa-circle-user me-2 col-2"></i>User Types</span>
		@elseif (Request::is('admin/user-types*'))
		<a class="text-decoration-none bg-it-secondary aria-link" href="@{{ route('admin.user-types.index') }}"><i class="fa fa-circle-user me-2 col-2"></i>User Types</a>
		@else
		<a class="text-decoration-none aria-link" href="@{{ route('admin.user-types.index') }}"><i class="fa fa-circle-user me-2 col-2"></i>User Types</a>
		@endif

		{{-- Permissions --}}
		@if (Request::is('admin/permissions'))
		<span class="bg-it-secondary"><i class="fas fa-lock me-2 col-2"></i>Permissions</span>
		@elseif (Request::is('admin/permissions*'))
		<a class="text-decoration-none bg-it-secondary aria-link" href="@{{ route('admin.permissions.index') }}"><i class="fa fa-lock me-2 col-2"></i>Permissions</a>
		@else
		<a class="text-decoration-none aria-link" href="@{{ route('admin.permissions.index') }}"><i class="fa fa-lock me-2 col-2"></i>Permissions</a>
		@endif

		{{-- Activity Log --}}
		@if (Request::is('admin/activity-log'))
		<span class="bg-it-secondary"><i class="fas fa-book me-2 col-2"></i>Activity Log</span>
		@elseif (Request::is('admin/activity-log*'))
		<a class="text-decoration-none bg-it-secondary aria-link" href="@{{ route('admin.activity-log.index') }}"><i class="fa fa-book me-2 col-2"></i>Activity Log</a>
		@else
		<a class="text-decoration-none aria-link" href="@{{ route('admin.activity-log.index') }}"><i class="fa fa-book me-2 col-2"></i>Activity Log</a>
		@endif

		{{-- Settings --}}
		@if (Request::is('admin/settings'))
		<span class="bg-it-secondary"><i class="fas fa-gear me-2 col-2"></i>Settings</span>
		@elseif (Request::is('admin/settings*'))
		<a class="text-decoration-none bg-it-secondary aria-link" href="@{{ route('admin.settings.index') }}"><i class="fa fa-gear me-2 col-2"></i>Settings</a>
		@else
		<a class="text-decoration-none aria-link" href="@{{ route('admin.settings.index') }}"><i class="fa fa-gear me-2 col-2"></i>Settings</a>
		@endif
	</div>
</div>
