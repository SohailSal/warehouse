<!DOCTYPE html>
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> --}}

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}

    <!-- Styles -->
    {{-- <link rel="stylesheet" href="{{ public_path('css/app.css') }}"> --}}

</head>

<body class="font-sans antialiased">
    <div class="border rounded-lg m-5 p-5 inline-block" style="color:white;background-color:gray;">
        @for ($i = 0; $i < 10; $i++) This is:
        {{-- {{ $a }}  --}}
        a<br>
            @endfor
    </div>
</body>

</html>
