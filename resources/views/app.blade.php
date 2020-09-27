<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="/css/app.css">

        <title>QuickBlog</title>


    </head>
    <body>
        <noscript>
        Denne side kræver, at JavaScript er slået til i din browser.
        </noscript>
        <div id="app">
            <blog-post-overview />
        </div>

        <script src="/js/app.js"></script>
    </body>
    
</html>
