<template>
  <b-navbar toggleable="md" type="light" variant="light">
    <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>
    <b-navbar-brand :to="{name : 'inicio'}">Barbao</b-navbar-brand>


    <b-collapse is-nav id="nav_collapse">
 
      <b-navbar-nav>
        <b-nav-item-dropdown text="Administración" right>
          <b-dropdown-item :to="{name : 'empresas'}">Empresas</b-dropdown-item>
          <b-dropdown-divider ></b-dropdown-divider>
          <b-dropdown-item :to="{name : 'usuarios_roles'}">Roles de Usuario</b-dropdown-item>
          <b-dropdown-item :to="{name : 'usuarios'}">Usuarios</b-dropdown-item>
          <b-dropdown-item :to="{name : 'usuarios_permisos'}">Permisos de Usuario</b-dropdown-item>
          <b-dropdown-divider></b-dropdown-divider>
          <b-dropdown-item :to="{name : 'encuestas_tipos'}">Tipos de encuesta</b-dropdown-item>
          <b-dropdown-item :to="{name : 'encuestas'}">Encuestas</b-dropdown-item>
          <b-dropdown-item :to="{name : 'encuestas_preguntas'}">Preguntas de encuesta</b-dropdown-item>
          <b-dropdown-item :to="{name : 'encuestas_generadas'}">Encuestas generadas</b-dropdown-item>
          <b-dropdown-item :to="{name : 'informes_encuestas'}">Reporte de encuestas</b-dropdown-item>
        </b-nav-item-dropdown>
      </b-navbar-nav>

      <b-navbar-nav class="ml-auto">
        <b-nav-item>{{ $auth.user().name }}</b-nav-item>
        <b-nav-item href="#" @click.prevent="$auth.logout()" right><i class="fa fa-sign-out-alt"></i></b-nav-item>
      </b-navbar-nav>
      
    </b-collapse>
  </b-navbar>
   
</template>