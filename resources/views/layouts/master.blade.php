@include('layouts.partials.head')

<body style="background-color:#e9ecef;">

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->



    <!-- App Capsule -->
    @yield('content')
    <!-- * App Capsule -->


    <!-- App Bottom Menu -->
    @include('layouts.partials.navbottom')
    <!-- * App Bottom Menu -->



@include('layouts.partials.scripts')
@livewireScripts

</body>

</html>
