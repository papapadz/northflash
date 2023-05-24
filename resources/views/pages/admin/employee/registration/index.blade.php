<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

       
        <link href="{{ asset('css/app.css') }}" rel="stylesheet"></link>
    </head>
    
    <body>
        <div id="app" class="flex-center position-ref full-height">
            <div class="card">
                <div class="card-body">
                    <div class="card-header"><h2>Employee Record</h2></div>
                    <div class="card-body">
                        <registration-component csrf="{{ csrf_token() }}" />
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</html>
