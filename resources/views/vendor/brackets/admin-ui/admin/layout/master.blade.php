<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Sistema de Asistencia Técnica, Mesa de Ayuda y Gestión de Tickets - Soporte TIC">

    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Preload de Recursos Críticos (Elimina Render Delay) -->
    <link rel="preload" href="{{ mix('/css/admin.css') }}" as="style">
    <link rel="preload" href="{{ mix('/js/admin.js') }}" as="script">
    <link rel="preload" href="{{ asset('images/logo-muvh.jpg') }}" as="image" fetchpriority="high">

	{{-- TODO translatable suffix --}}
    <title>SOPORTE TIC'S - @yield('title', 'Craftable')</title>

	@include('brackets/admin-ui::admin.partials.main-styles')

    @yield('styles')

</head>

<body class="app header-fixed sidebar-fixed sidebar-lg-show">
    @yield('header')

    @yield('content')

    @yield('footer')

    @include('brackets/admin-ui::admin.partials.wysiwyg-svgs')
    @include('brackets/admin-ui::admin.partials.main-bottom-scripts')
    @yield('bottom-scripts')
</body>
</html>
