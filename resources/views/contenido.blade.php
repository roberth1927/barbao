<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>@yield('titulo', 'Inicio') | Barbao v 2.0</title>

	<link rel="stylesheet" href="{{ asset('plugins/bootstrap-4/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{ asset('css/app.css')}}">
</head>
<body>
	<main role="main" class="container-fluid">
		@yield('contenido')
	</main>
	<script src="{{ asset('js/app.js')}}"></script>
</body>
</html>
