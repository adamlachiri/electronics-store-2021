<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- base -->
    <base href="{{ config('app.url') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/a9984945c1.js" crossorigin="anonymous"></script>


    <!-- my css -->
    <link rel="stylesheet" href="framework/css/index.css">

    <!-- style -->
    <style>
        /* css variables */
        :root {
            --main: #fcbb6a;
            --main-dark: orange;
            --light-transparent: rgba(255, 255, 255, 0.8);
            --dark-transparent: rgba(0, 0, 0, 0.8);
            --font-size-sm: 3vw;
            --font-size-md: 16px;
            --font-size-lg: 14px;
            --bg-body: rgb(220, 220, 220);
        }
    </style>

    <title>{{ config('app.name') }}</title>
</head>

<body class="text-lato d-flex flex-column vh-100">

    <!-- loading page -->
    <section class="js-loading-page bg-main">
        <div>
            <div class="d-center">
                <img src="framework/img/logo.png" alt="">
            </div>
            <div class="pt-3 text-center">
                <h5>
                    Loading the page . . .
                </h5>
            </div>

        </div>
    </section>

    <!-- global messages -->
    {{ success_msg() }}
    {{ error_msg() }}

    <!-- content -->
    <main>
        @yield("content")
    </main>


    <!-- footer -->
    <footer class="bg-darkgray py-5 flex-grow text-light text-capitalize text-center">
        <!-- logo -->
        <div class="d-center">
            <img src="framework/img/logo.png" width=100 height=auto alt="">
        </div>

        <!-- social media -->
        <div class="py-3">
            <!-- linkedin -->
            <a href="https://www.linkedin.com/in/adam-l-a33406210/" target="_blank" class="mx-3 hover-opacity" title="my linkedin profile">
                <i class="fab fa-linkedin fa-2x"></i>
            </a>

            <!-- github -->
            <a href="https://github.com/adamlachiri" target="_blank" class="mx-3 hover-opacity" title="my github">
                <i class="fab fa-github fa-2x"></i>
            </a>

            <!-- github -->
            <a href="https://www.freecodecamp.org/adamlachiri" target="_blank" class="mx-3 hover-opacity" title="my freecodecamp account">
                <i class="fab fa-free-code-camp fa-2x"></i>
            </a>
        </div>

        <!-- made by -->
        <div>
            made by adam lachiri
        </div>
    </footer>

    <!-- sign out form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <!-- product form -->
    <form id="products-form" action="products" method="get">
        @csrf
    </form>

</body>
<script src="framework/js/index.js" type="module"></script>

</html>