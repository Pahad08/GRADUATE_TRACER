<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="{{ asset("images/logo.png") }}" type="image/x-icon">
        @vite(["resources/css/app.css", "resources/js/app.js", "resources/js/fontawesome/fontawesome.js"])
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <title>{{ $title ?? "Graduate Tracer" }}</title>
    </head>

    <body class="font-geist">
        {{ $slot }}
    </body>

</html>
