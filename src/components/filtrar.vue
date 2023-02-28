<template>
  <nav>
    <router-link to="/listar">Home</router-link> |
    <router-link to="/VerPolizas">Ver cuotas</router-link>
    </nav>
  <div>
    <form v-on:submit.prevent="buscarPolizas">
      <label for="cliente1">Cliente 1:</label>
      <select id="cliente1" v-model="cliente1">
        <option v-for="cliente in clientes" :key="cliente.idcliente" :value="cliente.idcliente">{{ cliente.nombre }}</option>
      </select>

      <label for="cliente2">Cliente 2:</label>
      <select id="cliente2" v-model="cliente2">
        <option v-for="cliente in clientes" :key="cliente.idcliente" :value="cliente.idcliente">{{ cliente.nombre }}</option>
      </select>

      <label for="fechaInicio">Fecha de inicio:</label>
      <input type="date" id="fechaInicio" v-model="fechaInicio">

      <label for="fechaFin">Fecha de fin:</label>
      <input type="date" id="fechaFin" v-model="fechaFin">

      <button type="submit">Buscar</button>
    </form>

<select v-if="polizas.length" v-model="estadoSeleccionado" v-on:change="buscarPolizasPorEstado">
  <option value="">Todos los estados</option>
  <option v-for="estado in estados" :key="estado" :value="estado">{{ estado }}</option>
</select>

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
    fetch('http://localhost/user/')
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
      fetch(`http://localhost/user/?cliente1=${this.cliente1}&cliente2=${this.cliente2}&fechaInicio=${this.fechaInicio}&fechaFin=${this.fechaFin}`)
        .then(response => response.json())
        .then(data => {
          this.polizas = data;
        })
        .catch(error => {
          console.log(error);
        });
    },
    buscarPolizasPorEstado() {
      fetch(`http://localhost/user/?cliente1=${this.cliente1}&cliente2=${this.cliente2}&fechaInicio=${this.fechaInicio}&fechaFin=${this.fechaFin}&estado=${this.estadoSeleccionado}`)
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
