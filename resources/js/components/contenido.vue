<template>
    <div id="main">
        <div v-if="$auth.check()">
            <Header/>
        </div>
        <router-view></router-view>
    </div>  
</template>
<script>
    import Header from './parciales/header.vue';
    import Footer from './parciales/footer.vue';
    export default { 
        data() {
            return {
            }
        },
        components: { Header, Footer }
    }
</script>