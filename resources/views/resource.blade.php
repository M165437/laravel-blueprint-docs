<h3 id="{{ $resource->elementId }}">
    {{ $resource->name ?: 'Resource' }}
</h3>
{!! $resource->descriptionHtml !!}

@foreach($resource->actions as $action)
    @include('blueprintdocs::action')
@endforeach