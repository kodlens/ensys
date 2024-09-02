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
        @page {
            /* size: A4; */
            margin: 0;
        }
        @media print {
            html, body {
                width: 210mm;
                height: 297mm;
            }

            
            .page-break{
                page-break-after: always;
            }
            .nprint{
                display: none;
            }

            header, footer, aside, nav, form, iframe, .menu, .hero, .adslot {
                display: none;
                margin: 0;
            }

            .section {
                margin: 0;
            }
            .buttons{
                display: none;
            }

            .print-area{
                width: 210mm;
                margin: 0 auto;
            }

            
        /* ... the rest of the rules ... */
        }

        .print-area{
            width: 210mm;
            height: 297mm;
            margin: 30px auto 0;
            padding: 30px 35px;
     
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
