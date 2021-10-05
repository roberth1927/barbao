<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	<title><?php echo $__env->yieldContent('titulo', 'Inicio'); ?> | Barbao v 2.0</title>

	<link rel="stylesheet" href="<?php echo e(asset('plugins/bootstrap-4/css/bootstrap.min.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
</head>
<body>
	<main role="main" class="container-fluid">
		<?php echo $__env->yieldContent('contenido'); ?>
	</main>
	<script src="<?php echo e(asset('js/app.js')); ?>"></script>
</body>
</html>
