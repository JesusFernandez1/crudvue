<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <router-link class="navbar-brand" to="/listar">Mi sitio web</router-link>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <router-link class="nav-link" to="/listar">Home</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/VerPolizas">Ver cuotas</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/filtrar">Filtrar</router-link>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <router-link class="nav-link btn btn-danger" to="/">Logout</router-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
    <div class="container mt-4">
    <div class="card">
      <div class="card-header bg-primary text-white">
        Clientes
      </div>
      <div class="card-body">
        <table id="listado" class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Teléfono</th>
              <th>Localidad</th>
              <th>Código Postal</th>
              <th>Tipo</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="cliente in clientes" :key="cliente.idcliente">
              <td>{{ cliente.idcliente }}</td>
              <td>{{ cliente.nombre }}</td>
              <td>{{ cliente.apellido }}</td>
              <td>{{ cliente.telefono }}</td>
              <td>{{ cliente.provincia }}</td>
              <td>{{ cliente.codigo_postal }}</td>
              <td>{{ cliente.tipo }}</td>
              <td>
                <div class="btn-group" role="group">
                  <router-link :to="{name:'polizas',params:{id:cliente.idcliente}}" class="btn btn-info">Ver detalles</router-link>
                  <router-link :to="{name:'crearPoliza',params:{id:cliente.idcliente}}" class="btn btn-success">Crear póliza</router-link>
                  <router-link :to="{name:'modificar',params:{id:cliente.idcliente}}" class="btn btn-warning">Modificar</router-link>
                  <router-link :to="{name:'confirmarEliminar',params:{id:cliente.idcliente}}" class="btn btn-danger">Borrar</router-link>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import 'jquery/dist/jquery.min.js';
import "datatables.net-dt/js/dataTables.dataTables"
import "datatables.net-dt/css/jquery.dataTables.min.css"
import $ from 'jquery'; 

export default {
    data() {

        return {
            clientes: []
        }
    },
    created: function () {
        this.consultarCliente();
    },
    methods: {
        consultarCliente() {
            fetch('https://ieslamarisma.net/proyectos/2023/jesusfernandez/Vue/user/')
                .then(respuesta => respuesta.json())
                .then((datosRespuesta) => {


                    console.log(datosRespuesta)
                    this.clientes = []
                    if (typeof datosRespuesta[0].success === 'undefined') {

                        this.clientes = datosRespuesta;
                    }
                    this.$nextTick(function () {
                        $("#listado").DataTable()
                    });
                })
                .catch(console.log)
        },
        crearPoliza(){
            this.$router.push({name: "crearPoliza"});
        }
    }
}
</script>
<style>

#listado th {
    text-align: center;
}

</style>