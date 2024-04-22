@props(['columns', 'sortable' => false, 'hasActions' => true])

@php ($columns = json_decode($columns, true))
<div class="rounded-3 table-responsive h-100">
	<table class="table table-striped table-hover my-0 align-middle overflow-x-auto">
		<thead>
			<tr>
				@foreach ($columns as $label => $column)
				<th scope="col" class="text-nowrap">
					@if ($sortable)
						@sortablelink($column, $label)
					@else
						{{ $column }}
					@endif
				</th>
				@endforeach

				@if ($hasActions)
				<th scope="col" class="text-nowrap">
					@if ($sortable)
						<a href="{{ route(request()->route()->getName()) }}">Re-order</a>
						<i class="fa fa-rotate-left"></i>
					@endif
				</th>
				@endif
			</tr>
		</thead>

		<tbody class="table-group-divider h-100">
			{{ $slot }}
		</tbody>

		@if ($pagination)
		@php ($colToAdd = $hasActions ? 1 : 0)
		<tfoot class="table-group-divider">
			<tr>
				<td colspan="{{ count($columns) + $colToAdd }}">
					{{ $pagination }}
				</td>
			</tr>
		</tfoot>
		@endif
	</table>
</div>
