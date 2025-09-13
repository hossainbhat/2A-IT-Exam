
<!doctype html>
<html lang="en" class="color-sidebar sidebarcolor8">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    @include('layouts.admin._layout.style')
</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
        <!--sidebar wrapper -->
        @include('layouts.admin._layout.sitebar')
		<!--end sidebar wrapper -->
		<!--start header -->
        @include('layouts.admin._layout.header')
		<!--end header -->
		<!--start page wrapper -->
		@yield('content')
		<!--end page wrapper -->
		<!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
         @include('layouts.admin._layout.footer')
	</div>
	<!--end wrapper-->
	<!-- Bootstrap JS -->
    <script>
        var utlt = [];
        // Block page
        utlt['siteUrl'] = function(param) {
            var url = '{{ url('/') }}';
            if (param != null) {
                return `${url}/${param}`;
            } else {
                return `${url}`;
            }

        }
    </script>
    @include('layouts.admin._layout.script')
</body>
</html>