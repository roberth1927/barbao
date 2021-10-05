<template>
<div class="fondo">  
 <div class="gracias">
 <b-container >      
        <b-card bg-variant="info"
                text-variant="white"
                header="GRACIAS"
                class="text-center">
        <p class="card-text">Texto Texto Texto</p>
        </b-card> 
</b-container>
 </div> 
</div>  
</template>

<style scoped>

 .fondo {        
        background-image: url('/imagenes/gracias.jpg');
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        width: 100%;
        height: 100vh;
        }
  
  .gracias {
        position: absolute;
        top: 40%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 50%;
        height: 50vh;
    }
</style>


