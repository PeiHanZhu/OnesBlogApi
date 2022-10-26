<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        body {
            background-color: #333;
            text-align: center;
            color: #fff;
        }

        a {
            text-decoration: none;
        }

        h1 {
            color: white;
        }

        h1:hover {
            background-color: #2467af;
        }

        .container {
            margin: 0 auto;
            margin-top: 10%;
            width: 400px;
            height: 400px;
        }

        .image {
            border-radius: 5%;
            animation: logo 5s;
            width: 80%;
            height: 60%;
        }

        @keyframes logo {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body class="antialiased">
    <div class="container">
        <img src="/logo.png" alt="test" class="image">
        <a href="/docs">
            <h1>{{ env('APP_NAME') }} API Documentation</h1>
        </a>
    </div>
</body>

</html>
