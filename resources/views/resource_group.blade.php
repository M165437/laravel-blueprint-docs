<div class="panel panel-default panel-resource-group">
    <div class="panel-heading">
        <h2 class="panel-title" id="{{ $resourceGroup->elementId }}">
            {{ $resourceGroup->name }}
        </h2>
    </div>
    <div class="panel-body">
        {!! $resourceGroup->descriptionHtml !!}

        @foreach($resourceGroup->resources as $resource)
            @include('blueprintdocs::resource')
        @endforeach
    </div>
</div>