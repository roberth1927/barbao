<template>

    <b-container fluid>

    <div v-if="mensaje">
        {{mensaje}}
    </div>
    <div v-else>
        <b-form @submit="guardarDatos">
            <div v-for="(preg, id) in encuesta_preguntas" :key="id"> 
                    
                <b-card bg-variant="light">             
                    <label>{{preg.pregunta}}</label>

                    <div v-if="preg.tipo === 'SEL_MUL_UNI_RESP'"> 
                        
                        <b-form-group id="grupoPregunta" label-for="pregunta">                     
                            <b-form-select v-model="respuestas.opciones[id].valor_rta" :options="preg.pregunta_respuestas" @change="setPreguntaId($event, id, preg.id)" required></b-form-select>                                        <!-- v-model="firstname" name="firstname" class="form-control" id="firstname" placeholder="Nombre" v-validate="'required'" :class="{'has-errors': errors.has('firstname')}"> -->
                        </b-form-group>
                    </div>

                    <div v-else-if="preg.tipo === 'SI_NO'">
                        <b-form-group id="grupoPregunta1" label-for="pregunta1">
                            <b-form-radio-group v-model="respuestas.opciones[id].valor_rta" :options="preg.pregunta_respuestas" @change="setPreguntaId($event, id, preg.id)" required></b-form-radio-group>
                        </b-form-group>
                    </div>

                    <div v-else-if="preg.tipo === 'TEXTO'">
                        <b-form-textarea v-model="respuestas.opciones[id].valor_rta" :rows="3" :max-rows="6" @input="setPreguntaId($event, id, preg.id)" required></b-form-textarea>
                    </div>
                </b-card>
                <br>
            </div>
            <b-card bg-variant="light" class="text-center">
                <b-button type="submit" variant="outline-primary">Enviar</b-button>
            </b-card>
    
        </b-form>        
        <br>
    </div>
    </b-container>
      
</template>

<script>

 import { required } from 'vuelidate/lib/validators';
    export default {
        props: ['token'],  
         data () {         
            return { 
                respuesta : [],
                cargada_id : 0,
                respuestas : {
                    encuestas_id : 0 ,
                    opciones : []                                
                },
                encuesta_preguntas : [],
                cliente_id : '',
                totalRows: 0, 
                mensaje : '',
            }
         },
            validations: {
            respuestas : {required},
            respuesta : {required}
        },
        created() {
            this.getRespuestas()
        },
        methods: {
            getRespuestas: function() {
                this.loading = true
                axios.get(`/auth/encuesta_cliente/${this.token}`)
                    .then((respuesta) => {
                        if (respuesta.status == 202){
                            this.mensaje = respuesta.data.message
                        } else {
                            this.encuesta_preguntas = respuesta.data[0].encuesta_cargada.encuesta_preguntas
                            this.totalRows=Object.keys(this.encuesta_preguntas).length
                            this.respuestas.encuestas_id = respuesta.data[0].encuestas_id
                            this.empresas_id = respuesta.data[0].empresas_id
                            this.encuestas_id = respuesta.data[0].encuestas_id
                            this.cliente_id = respuesta.data[0].cliente_id
                            this.orden_id = respuesta.data[0].orden_id
                            this.empresas = respuesta.data[0].empresas
                            this.tipo_estado = respuesta.data[0].tipo_estado
                            this.id_ws = respuesta.data[0].id_ws
                            this.token = respuesta.data[0].token
                            this.addValue()
                        }
                        this.loading = false
                    })
                    .catch((err) => {
                        console.log(err)
                        this.loading = false
                    })
            },
            guardarDatos(evt){
                this.loading = true
                evt.preventDefault();
                this.errors = []
                axios.put('/auth/encuesta_cargadas/' + this.token, {
                 encuesta_cargadas_id: this.id,
                 encuestas_id: this.encuestas_id,
                 empresas_id: this.empresas_id,
                 cliente_id: this.cliente_id,
                 orden_id: this.orden_id,
                 empresas: this.empresas,
                 id_ws: this.id_ws,
                 ip: this.ip,
                 token: this.token,
                 respuesta: this.respuestas,                       
                }).then(response => {
                    this.pregunta_respuestas = response.data
                    this.loading = false
                    //this.$router.push('/gracias');
                    return response.data
                }).catch(error => {
                    if (error.response.status == 422){
                        this.errors = error.response.data.errors
                    }
                    this.loading = false
                })
            },
            addValue: function(){
                var i
                for(i=0; i<this.totalRows; i++){
                    this.respuestas.opciones.push({
                            pregunta_id : 0, 
                            valor_rta : ''
                            })
                }    
                
            },
            setPreguntaId(ev, id, pregunta_id){
                this.respuestas.opciones[id].pregunta_id = pregunta_id
            },
        }
        
    }
</script>







