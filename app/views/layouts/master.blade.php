<html>
<head>
    {{ HTML::style('css/style.css') }}
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.8/angular.min.js"></script>
</head>
@yield('body_tag', '<body>')
@show
<nav class="top-bar">
    @if (Auth::check())
    <ul>
        <li>
            <a href="/logout">Logout</a>
        </li>
    </ul>
    @endif
</nav>

<header class="logo">
    <a href="/">
        <img src="http://www.theorganicagency.com/img/logo.png" alt="Pass-hole!">
        <span>Password Vault</span>
    </a>

</header>
<div class="main-wrap">

    <aside class="control-sidebar" @if (!Auth::check()) style="display:none" @endif>
        @section('left_sidebar')
        @show
    </aside>

    <section class="main" @if (!Auth::check()) style="float:none" @endif>
        @yield('content')
    </section>
</div>
<footer class="main-wrap">
    <span>&copy; Copyright <?php echo date('Y') ?></span>
</footer>

</body>
</html>