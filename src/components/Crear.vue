<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Nuevo cliente
            </div>
            <div class="card-body">
                
                <form v-on:submit.prevent="agregarRegistro">

                    <div class="mb-3">
                      <label for="nombre" class="form-label">Nombre:</label>
                      <input type="text"
                        class="form-control" required name="nombre" v-model="cliente.nombre" id="nombre" aria-describedby="helpId" placeholder="Nombre">
                      <small id="helpId" class="form-text text-muted">Escribe el nombre</small>
                    </div>

                    <div class="mb-3">
                      <label for="apellido" class="form-label">Apellido:</label>
                      <input type="text"
                        class="form-control" required name="apellido" v-model="cliente.apellido" id="apellido" aria-describedby="helpId" placeholder="Apellido">
                      <small id="helpId" class="form-text text-muted">Escribe el apellido</small>
                    </div>

                    <div class="mb-3">
                      <label for="Telefono" class="form-label">Telefono:</label>
                      <input type="number"
                        class="form-control" required name="Telefono" v-model="cliente.telefono" id="Telefono" aria-describedby="helpId" placeholder="Telefono">
                      <small id="helpId" class="form-text text-muted">Escribe el Telefono</small>
                    </div>

                    <div class="mb-3">
                      <label for="Localidad" class="form-label">Localidad:</label>
                      <select v-model="cliente.localidad" required name="localidad" id="localidad" class="form-select" aria-label="Default select example">
                        <option disabled selected>Elija una localidad</option>
                        <option v-on:click="jugar" v-for="Localidad in Localidades" :key="Localidad.id">{{Localidad.nombre}}</option>
                        </select>
                    </div>

                    <div class="mb-3">
                      <label for="codigo_postal" class="form-label">Codigo Postal:</label>
                      <input type="text"
                        class="form-control" required name="codigo_postal" v-model="cliente.codigo_postal" id="codigo_postal" aria-describedby="helpId" placeholder="Codigo Postal">
                      <small id="helpId" class="form-text text-muted">Escribe el codgio Postal</small>
                    </div>

                    <div class="mb-3">
                      <label for="provincia" class="form-label">Provincia:</label>
                      <select v-model="cliente.provincia" required name="provincia" id="provincia" class="form-select" aria-label="Default select example">
                        <option disabled selected>Elija una provincia</option>
                        <option v-for="provincia in provincias" :key="provincia.id">{{provincia.nombre}}</option>
                      </select>
                    </div>
                    
                    <div class="mb-3">
                      <label for="tipo" class="form-label">Tipo de cliente:</label>
                      <select v-model="cliente.tipo" required name="tipo" id="tipo" class="form-select" aria-label="Default select example">
                        <option disabled selected>Elija un tipo</option>
                        <option value="Particular">Particular</option>
                        <option value="Empresa">Empresa</option>
                        </select>
                    </div>

                    <div class="btn-group" role="group" aria-label="Button group name">
                        <button type="submit" class="btn btn-success">Aceptar</button>
                        <router-link :to="{name:'login'}" class="btn btn-warning">Cancelar</router-link>
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
            Localidades: [],
            provincias: [],
            cliente:{

            }
        }
    },
    created: function () {
        this.consultarLocalidad();
    },
    methods:{
      consultarLocalidad() {
            fetch('http://localhost/comunidades/')
                .then(respuesta => respuesta.json())
                .then((datosRespuesta) => {

                    console.log(datosRespuesta)
                    this.Localidades = []
                    if (typeof datosRespuesta[0].success === 'undefined') {

                        this.Localidades = datosRespuesta;
                    }
                })
                .catch(console.log)
        },
        agregarRegistro(){
            var datosEnviar={nombre: this.cliente.nombre, apellido: this.cliente.apellido, telefono: this.cliente.telefono, localidad: this.cliente.localidad, 
                codigo_postal: this.cliente.codigo_postal, provincia: this.cliente.provincia, tipo: this.cliente.tipo}

            fetch('http://localhost/user/?insertar=1', {
                method:"POST",
                body:JSON.stringify(datosEnviar)
            })
            .then(respuesta => respuesta.json())
            .then((datosRespuesta => {
                if (JSON.stringify(datosRespuesta) == 'true') {
                    window.location.href = 'login';
                }  
            }))
        },
        jugar:function(){

          fetch('http://localhost/provincias/?consultarProvincia=' + this.cliente.localidad)
                .then(respuesta => respuesta.json())
                .then((datosRespuesta) => {

                    console.log(datosRespuesta)
                    this.provincias = []
                    if (typeof datosRespuesta[0].success === 'undefined') {

                        this.provincias = datosRespuesta;
                    }
                })
                .catch(console.log)
        }
    } 
}
</script>