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
  <div>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Busqueda
            </div>
            <div class="card-body">
                <form v-on:submit.prevent="buscarPolizas" class="mb-4">
              <div class="form-group">
                <label for="cliente1" class="mr-2">Cliente 1:</label>
                <select id="cliente1" v-model="cliente1" class="form-control">
                  <option v-for="cliente in clientes" :key="cliente.idcliente" :value="cliente.idcliente">{{ cliente.idcliente }}</option>
                </select>
              </div>

              <div class="form-group">
                <label for="cliente2" class="mr-2">Cliente 2:</label>
                <select id="cliente2" v-model="cliente2" class="form-control">
                  <option v-for="cliente in clientes" :key="cliente.idcliente" :value="cliente.idcliente">{{ cliente.idcliente }}</option>
                </select>
              </div>

              <div class="form-group">
                <label for="fechaInicio" class="mr-2">Fecha de inicio:</label>
                <input type="date" id="fechaInicio" v-model="fechaInicio" class="form-control">
              </div>

              <div class="form-group">
                <label for="fechaFin" class="mr-2">Fecha de fin:</label>
                <input type="date" id="fechaFin" v-model="fechaFin" class="form-control">
              </div>

              <button type="submit" class="btn btn-primary">Buscar</button>
            </form>

            <div v-if="polizas.length" class="form-group">
              <label for="estadoSeleccionado" class="mr-2">Filtrar por estado:</label>
              <select id="estadoSeleccionado" v-model="estadoSeleccionado" v-on:change="buscarPolizasPorEstado" class="form-control">
                <option value="">Todos los estados</option>
                <option v-for="estado in estados" :key="estado" :value="estado">{{ estado }}</option>
              </select>
            </div>
          </div>
      </div>
  </div>
    <table v-if="polizas.length" class="table">
      <thead>
        <tr>
          <th>Cliente</th>
          <th>Número de póliza</th>
          <th>Fecha</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="poliza in polizas" :key="poliza.id" v-bind:class="{ 'bg-danger': poliza.estado != 'Liquidada'}">
          <td>{{ poliza.cliente_idcliente }}</td>
          <td>{{ poliza.idpoliza }}</td>
          <td>{{ poliza.fecha }}</td>
          <td>{{ poliza.estado }}</td>
          <td>
                <div class="btn-group" role="group" aria-label="">

                  <router-link :to="{name:'polizas',params:{id:poliza.cliente_idcliente}}" style="border-color: white;" class="btn btn-info">Ver cliente</router-link>

                  <router-link :to="{name:'modificarpoliza',params:{id:poliza.idpoliza}}" style="border-color: white;" class="btn btn-warning">Modificar</router-link>
                                   
                  <router-link :to="{name:'confirmarEliminarPoliza',params:{id:poliza.idpoliza}}" style="border-color: white;" class="btn btn-danger">Borrar</router-link>
              </div>
          </td>
        </tr>
      </tbody>
    </table>
    <p v-else>No se encontraron resultados.</p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      cliente1: '',
      cliente2: '',
      fechaInicio: '',
      fechaFin: '',
      polizas: [],
      clientes: [],
      estados: ['Cobrada', 'Anulada', 'A cuenta', 'Liquidada', 'Pre-Anulada'],
      estadoSeleccionado: '',
    };
  },
  mounted() {
    fetch('https://ieslamarisma.net/proyectos/2023/jesusfernandez/Vue/user/')
      .then(response => response.json())
      .then(data => {
        this.clientes = data;
      })
      .catch(error => {
        console.log(error);
      });
  },
  methods: {
    buscarPolizas() {
      fetch(`https://ieslamarisma.net/proyectos/2023/jesusfernandez/Vue/user/?cliente1=${this.cliente1}&cliente2=${this.cliente2}&fechaInicio=${this.fechaInicio}&fechaFin=${this.fechaFin}`)
        .then(response => response.json())
        .then(data => {
          this.polizas = data;
        })
        .catch(error => {
          console.log(error);
        });
    },
    buscarPolizasPorEstado() {
      fetch(`https://ieslamarisma.net/proyectos/2023/jesusfernandez/Vue/user/?cliente1=${this.cliente1}&cliente2=${this.cliente2}&fechaInicio=${this.fechaInicio}&fechaFin=${this.fechaFin}&estado=${this.estadoSeleccionado}`)
        .then(response => response.json())
        .then(data => {
          this.polizas = data;
        })
        .catch(error => {
          console.log(error);
        });
    }
  },
};
</script>
