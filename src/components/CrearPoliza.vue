<template>
    <nav>
    <router-link to="/listar">Home</router-link> |
    <router-link to="/VerPolizas">Ver cuotas</router-link>
    </nav>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Nuevo cliente
            </div>
            <div class="card-body">
                
                <form v-on:submit.prevent="agregarRegistro">

                    <div class="mb-3">
                      <label for="importe" class="form-label">Importe:</label>
                      <input type="number"
                        class="form-control" required name="importe" v-model="cliente.importe" id="importe" aria-describedby="helpId" placeholder="Importe">
                      <small id="helpId" class="form-text text-muted">Escribe el importe</small>
                    </div>

                    <div class="mb-3">
                      <label for="fecha" class="form-label">Fecha:</label>
                      <input type="date"
                        class="form-control" required name="fecha" v-model="cliente.fecha" id="fecha" aria-describedby="helpId" placeholder="Fecha">
                      <small id="helpId" class="form-text text-muted">Escribe el fecha</small>
                    </div>

                    <div class="mb-3">
                      <label for="estado" class="form-label">Estado:</label>
                      <select  v-model="cliente.estado" required name="estado" id="estado" class="form-select" aria-label="Default select example">
                        <option disabled selected>Elija un estado</option>
                        <option value="Cobrada">Cobrada</option>
                        <option value="A cuenta">A cuenta</option>
                        <option value="Liquidada">Liquidada</option>
                        <option value="Anulada">Anulada</option>
                        <option value="Pre-Anulada">Pre-Anulada</option>
                        </select>
                    </div>

                    <div class="mb-3">
                      <label for="observaciones" class="form-label">Observaciones:</label>
                      <input type="text"
                        class="form-control" required name="observaciones" v-model="cliente.observaciones" id="observaciones" aria-describedby="helpId" placeholder="Observaciones">
                      <small id="helpId" class="form-text text-muted">Escribe el codgio observaciones</small>
                    </div>
                    
                    <div class="mb-3">
                      <label for="cliente_idcliente" class="form-label">Cliente:</label>
                      <select v-model="cliente.cliente_idcliente" required name="cliente_idcliente" id="cliente_idcliente" class="form-select" aria-label="Default select example">
                        <option v-for="cliente in clientes" :key="cliente.idcliente">{{cliente.nombre}}</option>
                        </select>
                    </div>

                    <div class="btn-group" role="group" aria-label="Button group name">
                        <button type="submit" class="btn btn-success">Aceptar</button>
                        <router-link :to="{name:'listar'}" class="btn btn-warning">Cancelar</router-link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            clientes: [],
            cliente:{

            }
        }
    },
    created: function () {
        this.consultarCliente();
    },
    methods:{
        consultarCliente() {
            fetch('https://ieslamarisma.net/proyectos/2023/jesusfernandez/Vue/poliza/?consultarCrear='+this.$route.params.id)
                .then(respuesta => respuesta.json())
                .then((datosRespuesta) => {

                    console.log(datosRespuesta)
                    this.clientes = []
                    if (typeof datosRespuesta[0].success === 'undefined') {

                        this.clientes = datosRespuesta;
                    }
                })
                .catch(console.log)
        },
        agregarRegistro(){
            var datosEnviar={importe: this.cliente.importe, fecha: this.cliente.fecha, estado: this.cliente.estado, observaciones: this.cliente.observaciones, cliente_idcliente: this.cliente.cliente_idcliente}

            fetch('https://ieslamarisma.net/proyectos/2023/jesusfernandez/Vue/poliza/?insertar=1', {
                method:"POST",
                body:JSON.stringify(datosEnviar)
            })
            .then(respuesta => respuesta.json())
            .then((datosRespuesta => {
                if (JSON.stringify(datosRespuesta) == 'true') {
                    this.$router.push({name: "listar"});
                }  
            }))
        }
    } 
}
</script>