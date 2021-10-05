<template>
  <div class="fondo">
  <b-container fluid>
    <div class="login">
      <b-card-group deck>
        <b-card header="Inicio de Sesión">
          <b-form @submit.prevent="login">

            <b-form-group id="grupoEmail" label="Email:" label-for="email">
              <b-form-input id="email" type="text" v-model="email" @input="$v.email.$touch()"></b-form-input>
              <div v-if="$v.email.$dirty">
                <p class="error-message" v-if="!$v.email.required">El Email es obligatorio</p>
                <p class="error-message" v-if="!$v.email.email">Debe digitar un email valido1</p>
              </div>
            </b-form-group>

            <b-form-group id="grupoPassword" label="Contraseña:" label-for="password">
              <b-form-input id="password" type="password" v-model="password" @input="$v.password.$touch()"></b-form-input>
              <div v-if="$v.password.$dirty"><p class="error-message" v-if="!$v.password.required">La contraseña es obligatoria</p></div>
            </b-form-group>

            <div class="text-center"><b-button type="submit" variant="primary" :disabled="$v.$invalid">Iniciar Sesión</b-button></div>

          </b-form>
          <br>
          <b-alert show variant="danger" v-if="has_error">{{mensajes}}</b-alert>
        </b-card>
      </b-card-group>
    </div>
    <Loading v-if="loading"/>
  </b-container>
  </div>
</template>

<script>
  import { required, email } from 'vuelidate/lib/validators';
  export default {
    data() {
      return {
        loading : false,
        email: null,
        password: null,
        has_error: false,
        mensajes: null,
      }
    },
    validations: {
      email : { required, email },
      password : { required }
    },
    mounted() {

    },
    methods: {
      login() {
        this.loading = true
        // get the redirect object
        var redirect = this.$auth.redirect()
        var app = this
        this.$auth.login({
          params: {
            email: app.email,
            password: app.password
          },
          success: function() {
            // handle redirection
            this.$router.push({name: 'inicio'})
            this.loading = false
          },
          error: function(error) {
            app.has_error = true
            this.mensajes = error.response.data.message
            this.loading = false
          },
          rememberMe: true,
          fetchUser: true
        })
      },        
    },
  }
</script>

<style scoped>
  
  .fondo {        
			background-image: url('/imagenes/fondo_login.jpg');
			background-position: center center;
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-size: cover;
      width: 100%;
      height: 100vh;
		}

  .login {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 60%
    }
</style>