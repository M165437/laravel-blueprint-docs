<h3 id="{{ $resource->elementId }}">
    {{ $resource->name }}
</h3>
{!! $resource->descriptionHtml !!}

@foreach($resource->actions as $action)
    @include('blueprintdocs::action')
@endforeach