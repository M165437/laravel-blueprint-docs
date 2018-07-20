<p>
	<strong>Attributes</strong>
</p>
<div class="attributes">
	<table>
		<thead>
		<tr>
			<th></th>
			<th></th>
		</tr>
		</thead>
		<tbody>
		@foreach ($action->attributes as $attribute)
			<tr>
				<td>
					<strong>{{ $attribute->name }}</strong>
				</td>
				<td>
					<p>
						<code>{{ $attribute->type }}</code>
						@if ($attribute->example)
							&nbsp;<span class="text-muted">Example: {{ $attribute->example }}</span>
						@endif
					</p>
					{!! $attribute->descriptionHtml !!}
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
</div>
