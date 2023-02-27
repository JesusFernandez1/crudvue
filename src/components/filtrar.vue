<template>
  <div>
    <form v-on:submit.prevent="buscarPolizas">
      <label for="cliente1">Cliente 1:</label>
      <select id="cliente1" v-model="cliente1">
        <option value="codigo1">Código 1</option>
        <option value="codigo2">Código 2</option>
      </select>

      <label for="cliente2">Cliente 2:</label>
      <select id="cliente2" v-model="cliente2">
        <option value="codigo1">Código 1</option>
        <option value="codigo2">Código 2</option>
      </select>

      <label for="fechaInicio">Fecha de inicio:</label>
      <input type="date" id="fechaInicio" v-model="fechaInicio">

      <label for="fechaFin">Fecha de fin:</label>
      <input type="date" id="fechaFin" v-model="fechaFin">

      <button type="submit">Buscar</button>
    </form>

    <table v-if="polizas.length">
      <thead>
        <tr>
          <th>Cliente</th>
          <th>Número de póliza</th>
          <th>Fecha</th>
          <th>Estado</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="poliza in polizas" :key="poliza.id" :class="{ 'rojo': !poliza.liquidada }">
          <td>{{ poliza.cliente }}</td>
          <td>{{ poliza.numeroPoliza }}</td>
          <td>{{ poliza.fecha }}</td>
          <td>{{ poliza.liquidada ? 'Liquidada' : 'Sin liquidar' }}</td>
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
      cliente1: 'codigo1',
      cliente2: 'codigo2',
      fechaInicio: '',
      fechaFin: '',
      polizas: [],
    }
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
}
  }
}
</script>

<style>
.rojo {
  color: red;
}
</style>