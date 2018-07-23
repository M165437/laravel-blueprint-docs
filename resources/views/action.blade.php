<div class="panel panel-default panel-action">
    <div class="panel-heading">
        <h4 class="panel-title" id="{{ $action->elementId }}">
            <span class="method {{ $action->methodLower }}">{{ $action->method }}</span>
            <code class="uri">{!! urldecode($action->uriTemplate) !!}</code>
            <span class="name">{{ $action->name }}</span>
        </h4>
    </div>
    <div class="panel-body">
        {!! $action->descriptionHtml !!}

        <p><strong>Example URI</strong></p>
        <div class="definition">
            <span class="method {{ $action->methodLower }}">{{ $action->method }}</span>
            <span class="uri">
                <span class="hostname">{{ $api->host }}</span>{!! urldecode($action->colorizedUriTemplate) !!}
            </span>
        </div>

        @if ($action->parameters->count())
            @include ('blueprintdocs::parameters')
        @endif

        @if ($action->attributes->count())
            @include ('blueprintdocs::attributes')
        @endif
    </div>
    @if ($action->examples->count())
        <div class="panel-footer">
            <div class="transaction">
                <ul class="nav nav-pills nav-justified" role="tablist">
                    <li role="presentation" class="">
                        <a href="{{ $action->elementLink }}-request" aria-controls="{{ $action->elementId }}-request" role="tab" data-toggle="tab">Request</a>
                    </li>
                    @foreach($action->examples->pluck('response') as $response)
                        <li role="presentation">
                            <a href="{{ $action->elementLink }}-response-{{ $response->statusCode }}" aria-controls="{{ $action->elementId }}-response-{{ $response->statusCode }}" role="tab"
                               data-toggle="tab">Response <code>{{ $response->statusCode }}</code></a>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane" id="{{ $action->elementId }}-request">
                        @include('blueprintdocs::requestresponsebody', ['requestresponse' => $action->examples->first()->get('request')])
                    </div>
                    @foreach($action->examples->pluck('response') as $response)
                        <div role="tabpanel" class="tab-pane" id="{{ $action->elementId }}-response-{{ $response->statusCode }}">
                            @include('blueprintdocs::requestresponsebody', ['requestresponse' => $response])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
