<template>
    <div class="row p-2 mb-2 bg-secondary text-white">
        <div class="col-auto mr-auto"><h3>{{ titulo }}</h3></div>
        <div class="col-auto">
            <b-button v-if="ver_boton_nuevo" variant="primary" :to="{ name: ruta }"><i class="fa fa-plus-circle fa-lg"></i> Crear {{ titulo_singular }}</b-button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['ver_boton_nuevo', 'titulo', 'titulo_singular', 'ruta']
    }
</script>