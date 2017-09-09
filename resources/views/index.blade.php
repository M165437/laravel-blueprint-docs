<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('vendor/blueprintdocs/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/blueprintdocs/css/blueprintdocs.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ url('/api-documentation') }}">
                    {{ $api->name }}
                </a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row content-wrapper">

            <!-- Sidebar -->
            <div class="sidebar">
                <div class="sidebar__inner">

                    <!-- Navigation -->
                    @include ('blueprintdocs::navigation')

                    <!-- Host -->
                    <p class="host">
                        <a href="{{ $api->host }}">{{ $api->host }}</a>
                    </p>
                </div>
            </div>

            <!-- Content -->
            <div class="main">

                <!-- Description -->
                <div class="panel panel-default panel-description">
                    <div class="panel-heading">
                        <h1 class="panel-title" id="description">{{ $api->name }}</h1>
                    </div>
                    <div class="panel-body">
                        {!! $api->descriptionHtml !!}
                    </div>
                </div>

                <!-- Resource Groups -->
                @foreach($api->resourceGroups as $resourceGroup)
                    @include('blueprintdocs::resource_group')
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('vendor/blueprintdocs/js/app.js') }}"></script>
<script src="{{ asset('vendor/blueprintdocs/js/blueprintdocs.js') }}"></script>

</body>
</html>
