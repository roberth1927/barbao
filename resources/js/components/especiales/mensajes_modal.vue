<template>
    <div class="d-block text-center">
        <b-alert v-if="mensaje" show variant="danger">{{mensaje}}</b-alert>
    </div>
</template>
<script>
    export default {
        props: {
            mensaje : '',
        }
    }
</script>