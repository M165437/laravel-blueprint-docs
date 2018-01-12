<div class="panel-group" role="tablist" aria-multiselectable="true">
    <div class="panel panel-collapsable">
        <div class="panel-heading" role="tab" id="panel-heading-0">
            <h4 class="panel-title">
                <a class="btn-block collapsed" role="button" data-toggle="collapse" data-group-id="description" href="#collapse-0" aria-expanded="false" aria-controls="collapse-0">
                    Description
                </a>
            </h4>
        </div>

        <div class="panel-body collapse" role="tabpanel" aria-labelledby="panel-heading-0" id="collapse-0">
            <div class="tabs">
                <ul class="nav stacked-tabs" role="tablist">
                    @foreach ($api->descriptionHeadings->where('level', '<', 3) as $heading)
                        <li role="presentation">
                            <a href="#{{ $heading->id }}">
                                {{ $heading->text }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    @foreach ($api->resourceGroups as $resourceGroup)
        <div class="panel panel-collapsable">
            <div class="panel-heading" role="tab" id="panel-heading-{{ $loop->iteration }}">
                <h4 class="panel-title">
                    <a class="btn-block" role="button" data-toggle="collapse" data-group-id="{{ $resourceGroup->elementId }}" href="#collapse-{{ $loop->iteration }}" aria-expanded="true" aria-controls="collapse-{{ $loop->iteration }}">
                        {{ $resourceGroup->name }}
                    </a>
                </h4>
            </div>

            <div class="panel-body collapse in" role="tabpanel" aria-labelledby="panel-heading-{{ $loop->iteration }}" id="collapse-{{ $loop->iteration }}">
                <div class="tabs">
                    <ul class="nav stacked-tabs" role="tablist">
                        @foreach ($resourceGroup->resources as $resource)
                            @if (config('blueprintdocs.condense_navigation'))
                                <li role="presentation" class="resource">
                                    <a href="{{ $resource->elementLink }}">{{ $resource->name ?: 'Resource' }}</a>
                                </li>
                            @else
                                @if ($resource->actions->count() > 1)
                                    <li role="presentation" class="resource">
                                        <a href="{{ $resource->elementLink }}">{{ $resource->name ?: 'Resource' }}</a>
                                        <ul class="nav stacked-tabs">
                                            @foreach ($resource->actions as $action)
                                                <li role="presentation">
                                                    <a href="{{ $action->elementLink }}">
                                                        <span class="method {{ $action->methodLower }}">{{ $action->method }}</span>
                                                        <span class="name">{{ $action->name ?: $action->method . ' ' . $action->uriTemplate }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    @php ($action = $resource->actions[0])
                                    <li role="presentation">
                                        <a href="{{ $action->elementLink }}">
                                            <span class="method {{ $action->methodLower }}">{{ $action->method }}</span>
                                            <span class="name">{{ $action->name ?: $resource->name ?: $action->method . ' ' . $action->uriTemplate }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endforeach
</div>
