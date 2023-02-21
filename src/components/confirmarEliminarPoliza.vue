<template>
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
            fetch('http://localhost/poliza/?consultarBorrar=' + this.$route.params.id)
                .then(respuesta => respuesta.json())
                .then((datosRespuesta) => {

                    if (typeof datosRespuesta[0].success === 'undefined') {

                        this.polizas = datosRespuesta;
                    }
                })
                .catch(console.log)
        },
        borrarPoliza(id) {
            fetch('http://localhost/poliza/?borrar=' + id)
                .then(respuesta => respuesta.json())
                .then((datosRespuesta) => {

                    window.location.href = "VerPolizas"
                })
                .catch(console.log)
        },
        noBorrarPoliza() {
            window.location.href = 'VerPolizas';
        }
    }
}
</script>
<style>

#listaPolizas th {
    text-align: center;
}

</style>