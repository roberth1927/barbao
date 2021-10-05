<template>
    <div>
        <b-link v-if="ver.show"    :to="{name: ver.ruta,    params: {id : ver.id,    id2: ver.id2 }}"><i class="fa fa-eye"></i></b-link>
        <b-link v-if="editar.show" :to="{name: editar.ruta, params: {id : editar.id, id2: editar.id2 }}"><i class="fa fa-edit"></i></b-link>
    </div>
</template>

<script>
    export default {
        props: {
            ver: Object,
            editar: Object
        }
    }
</script>