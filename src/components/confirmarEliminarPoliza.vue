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
        <div class="card">
            <div class="card-header">
                <h3>Estas seguro de eliminar la poliza?</h3>
            </div>
            <div class="card-body">
                <table id="listaPolizas" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Importe</th>
                            <th>Fecha de creacion</th>
                            <th>Estado</th>
                            <th>Observaciones</th>
                            <th>ID del cliente</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-bind:class="{ 'bg-success': poliza.estado == 'Cobrada', 'bg-danger': poliza.estado == 'Anulada', 'bg-warning': poliza.estado == 'A cuenta', 'bg-info': poliza.estado == 'Liquidada', 'bg-secondary': poliza.estado == 'Pre-Anulada' }">
                            <td>{{ poliza.idpoliza }}</td>
                            <td>{{ poliza.importe }}</td>
                            <td>{{ poliza.fecha }}</td>
                            <td>{{ poliza.estado }}</td>
                            <td>{{ poliza.observaciones }}</td>
                            <td>{{ poliza.cliente_idcliente }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="">

                                    <button type="button" v-on:click="borrarPoliza(poliza.idpoliza)"
                                        class="btn btn-danger">Si</button>
                                   
                                    <button type="button" v-on:click="noBorrarPoliza()"
                                        class="btn btn-success">No</button>
                                    
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
export default {
    data() {

        return {
            poliza: {

            }
        }
    },
    created: function () {
        this.consultarPoliza();
    },
    methods: {
        consultarPoliza() {
            fetch('https://ieslamarisma.net/proyectos/2023/jesusfernandez/Vue/poliza/?consultarBorrar=' + this.$route.params.id)
            .then(respuesta => respuesta.json())
                .then((datosRespuesta) => {

                    console.log(datosRespuesta)
                    this.poliza = datosRespuesta[0];

                })
                .catch(console.log)
        },
        borrarPoliza(id) {
            fetch('https://ieslamarisma.net/proyectos/2023/jesusfernandez/Vue/poliza/?borrar=' + id)
                .then(respuesta => respuesta.json())
                .then((datosRespuesta) => {

                    console.log(datosRespuesta)
                    this.$router.push({name: "VerPolizas"});
                })
                .catch(console.log)
        },
        noBorrarPoliza() {
            this.$router.push({name: "VerPolizas"});
        }
    }
}
</script>
<style>

#listaPolizas th {
    text-align: center;
}

</style>