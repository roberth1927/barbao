<?php $__env->startSection('titulo','Inicio'); ?>

<?php $__env->startSection('contenido'); ?>
    <div id="app">
        <contenido></contenido>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('contenido', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>