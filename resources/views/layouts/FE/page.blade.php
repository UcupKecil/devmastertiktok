<!DOCTYPE html>
<html lang="zxx">

@include('components.layouts.FE.index.head')

<body>
    @include('components.layouts.FE.index.preloader')
    @include('components.layouts.FE.index.sidebar')
    @include('components.layouts.FE.index.navbar')
    @yield('content')
    @include('components.layouts.FE.index.footer')
    @include('components.layouts.FE.index.script')
</body>

</html>
