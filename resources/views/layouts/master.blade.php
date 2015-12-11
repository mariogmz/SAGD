<html>
    <head>
        <title>@yield('title')</title>
        <link rel="stylesheet" type="text/css" href="@yield('style')">
    </head>
    <body>
        @section('header')
            <img src="http://www.zegucom.com.mx/images/logos/zegucom.png" alt="Zegucom computo"/>
        @show

        <div class="container">
            @yield('content')
        </div>
    </body>
</html>
