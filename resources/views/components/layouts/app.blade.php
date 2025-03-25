<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}" data-theme="nord">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="{{ asset("images/logo.png") }}" type="image/x-icon">
        @vite(["resources/css/app.css", "resources/js/fontawesome/fontawesome.js"])
        <title>{{ $title ?? "Graduate Tracer" }}</title>
    </head>

    <body class="font-[Arial]">
        {{ $slot }}
    </body>

</html>
