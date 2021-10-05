<template>
    <div class="loading">
        <div class="centered">
            <HalfCircle-spinner :animation-duration="1000" :size="80" :color="'#ff1d5e'" />
        </div>
    </div>
</template>

<script>
      import {HalfCircleSpinner} from 'epic-spinners'
      export default {
            components: {
                HalfCircleSpinner
            }
      }
</script>

<style scoped>
    .loading {
        position: fixed;
        z-index: 1031;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);

        height: 100%;
        width: 100%;
        /*position: fixed;*/
        /*z-index: 1;*/
        /*top: 0;
        overflow-x: hidden;*/
        padding-top: 20px;
        background-color: #111;
        opacity: 0.5
    }

    .centered {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }
</style>