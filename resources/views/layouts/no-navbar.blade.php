<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
{{--    <link rel="dns-prefetch" href="//fonts.gstatic.com">--}}
{{--    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">--}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>

        .print-area{
            width: 210mm;
            margin: 30px auto;
            padding: 30px 35px;
        }

        @page {
            size: 11.7in 8.3in;
            border: 1px solid red;
            margin: 0;
        }
        
        @media print {
            
            .print-area{
                margin: 0 auto;
                padding: 0;
                font-size: .9rem;
            }


            html, body {
                margin: 0;
                padding: 0;
            }

            
            .page-break{
                page-break-after: always;
                margin-top: 15px;
            }

            .nprint{
                display: none;
            }

            header, footer, aside, nav, form, iframe, .menu, .hero, .adslot {
                display: none;
                margin: 0;
            }

            .section .columns .column {
                margin: 0;
            }

            .buttons{
                display: none;
            }

            
        /* ... the rest of the rules ... */
        }

     
    </style>

</head>
<body>
    <div id="app">

        <div>
            @yield('content')
        </div>


    </div>
</body>
</html>
