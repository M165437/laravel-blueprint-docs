<p>
    <strong>URI Parameters</strong>
</p>
<div class="parameters">
    <table>
        <thead>
        <tr>
            <th>Parameter</th>
            <th>Description</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($action->parameters as $parameter)
            <tr>
                <td>
                    <strong>{{ $parameter->name }}</strong>
                </td>
                <td>
                    <p>
                        <code>{{$parameter->type}}</code>
                        @if ($parameter->required)
                            &nbsp;({{ $parameter->required }})
                        @endif
                        @if ($parameter->defaultValue)
                            &nbsp;<span class="text-muted">Default: {{ $parameter->defaultValue }}</span>
                        @endif
                        @if ($parameter->example)
                            &nbsp;<span class="text-muted">Example: {{ urldecode($parameter->example) }}</span>
                        @endif
                    </p>
                    {!! $parameter->descriptionHtml !!}
                    @if (!empty($parameter->values))
                        <p class="choices">
                            <strong>Choices:</strong>&nbsp;
                            @foreach($parameter->values as $value)
                                <code>{{ $value }}</code>&#32;
                            @endforeach
                        </p>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
