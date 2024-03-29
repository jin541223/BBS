<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'BBS') - 进阶练习</title>
  <meta name="description" content="@yield('description', 'laravel爱好者BBS')" />

  <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
  @yield('styles')
</head>
<body>
  <div id="app" class="{{ route_class() }}-page">
    @include('layouts._header')

    <div class="container">
      @include('shared._messages')

      @yield('content')

    </div>

    @include('layouts._footer')
  </div>

  <script src="{{ mix('js/app.js') }}"></script>
  @yield('scripts')
</body>
</html>
