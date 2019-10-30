@if (isset($requestresponse->title))
    <h4>{{ $requestresponse->title }}</h4>
@endif
@if (isset($requestresponse->description))
    <p><strong>Description</strong></p>
    <p>{{ $requestresponse->description }}</p>
@endif
@if ($requestresponse->headers->count())
    <p><strong>Headers</strong></p>
    <pre><code>@foreach($requestresponse->headers as $key => $value){{ $key . ': ' . $value }}<br>@endforeach</code></pre>
@endif
@if ($requestresponse->messageBody)
    <p><strong>Body</strong></p>
    <pre><code>{{ $requestresponse->messageBody->body }}</code></pre>
@endif
@if ($requestresponse->messageBodySchema)
    <p><strong>Schema</strong></p>
    <pre><code>{{ $requestresponse->messageBodySchema->body }}</code></pre>
@endif
@if (! $requestresponse->hasContent)
    <p><strong>This has no content.</strong></p>
@endif
