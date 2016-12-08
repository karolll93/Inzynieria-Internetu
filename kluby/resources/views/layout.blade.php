<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Rozgrywki klubowe</title>
    <link href="{{ url("bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css"/>
    <link href="{{ url("css/style.css") }}" rel="stylesheet" type="text/css"/>
    <script src="{{ url("js/jquery-3.1.1.min.js") }}"></script>
    <script src="{{ url("bootstrap/js/bootstrap.min.js") }}"></script>
    <script src="{{ url("js/bootbox.min.js") }}"></script>
    <script src="{{ url("js/app.js") }}"></script>
</head>
<body>

<nav class="navbar navbar-light" style="background-color: #e3f2fd;">
    <div class="container">
        <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse"
                data-target="#navbarResponsive"></button>
        <div class="collapse navbar-toggleable-md" id="navbarResponsive">
            <h1 class="navbar-brand mb-0"><img src="{{ url("img/football-icon.png") }}" alt="" /> Rozgrywki klubowe</h1>
            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route("home") }}">Strona główna</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route("leagues") }}">Rozgrywki</a>
                </li>
            </ul>
            <ul class="nav navbar-nav float-lg-right">
                @if (Auth::check())
                    <li class="nav-item">
                        <span class="nav-link">zalogowany jako: <strong>{{ Auth::user()->login }}</strong></span>
                    </li>
                    @if (Auth::user()->admin)
                        <li class="nav-item">
                            <a href="{{ route("dashboard") }}" class="nav-link" style="text-decoration: underline;">zarządzaj systemem</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route("logout") }}">wyloguj się</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route("login") }}">zaloguj się</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<div id="content" class="container">
    @yield('content')
</div>

</body>
</html>
