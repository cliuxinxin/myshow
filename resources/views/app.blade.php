<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>My Shows</title>

    <!-- Styles -->
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.11/css/dataTables.bootstrap4.min.css">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}


</head>
<body id="app-layout">
@include('partial.nav')

@yield('content')

        <!-- JavaScripts -->
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.js"></script>
<script src="//cdn.datatables.net/1.10.11/js/dataTables.bootstrap4.min.js"></script>



@yield('foot_script')
{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
