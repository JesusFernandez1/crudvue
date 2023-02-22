<template>
  <nav>
    <router-link to="/listar">Home</router-link> |
    <router-link to="/VerPolizas">Ver cuotas</router-link> |
    <router-link to="/about">About</router-link>
    </nav>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Editar poliza
            </div>
            <div class="card-body">
                
                <form v-on:submit.prevent="actualizarRegistro">

                    <div class="mb-3">
                      <label for="importe" class="form-label">Importe:</label>
                      <input type="number"
                        class="form-control" required name="importe" v-model="poliza.importe" id="importe" aria-describedby="helpId" placeholder="importe">
                      <small id="helpId" class="form-text text-muted">Escribe el importe</small>
                    </div>

                    <div class="mb-3">
                      <label for="fecha" class="form-label">Fecha:</label>
                      <input type="date"
                        class="form-control" required name="fecha" v-model="poliza.fecha" id="fecha" aria-describedby="helpId" placeholder="fecha">
                      <small id="helpId" class="form-text text-muted">Escribe el fecha</small>
                    </div>

                    <div class="mb-3">
                      <label for="estado" class="form-label">Estado:</label>
                      <input type="text"
                        class="form-control" required name="estado" v-model="poliza.estado" id="estado" aria-describedby="helpId" placeholder="estado">
                      <small id="helpId" class="form-text text-muted">Escribe el estado</small>
                    </div>

                    <div class="mb-3">
                      <label for="observaciones" class="form-label">Observaciones:</label>
                      <input type="text"
                        class="form-control" required name="observaciones" v-model="poliza.observaciones" id="observaciones" aria-describedby="helpId" placeholder="observaciones">
                      <small id="helpId" class="form-text text-muted">Escribe el codgio observaciones</small>
                    </div>                

                    <div class="btn-group" role="group" aria-label="Button group name">
                        <button type="submit" class="btn btn-danger">Aceptar</button>
                        <router-link :to="{name:'listar'}" class="btn btn-success">Cancelar</router-link>
                    </div>

                </form>

            </div>
            
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            poliza:{

            }
        }
    },
    created:function(){
        this.obtenerInformacionID();
    },
    methods:{

        obtenerInformacionID(){
            fetch('http://localhost/poliza/?consultarModificar='+this.$route.params.id)
                .then(respuesta => respuesta.json())
                .then((datosRespuesta) => {

                    console.log(datosRespuesta)
                    this.poliza = datosRespuesta[0];

                })
                .catch(console.log)
        },
        actualizarRegistro(){
            var datosEnviar={importe: this.poliza.importe, fecha: this.poliza.fecha, estado: this.poliza.estado, observaciones: this.poliza.observaciones}

            fetch('http://localhost/poliza/?actualizar='+this.$route.params.id, {
                method:"POST",
                body:JSON.stringify(datosEnviar)
            })
            .then(respuesta => respuesta.json())
            .then((datosRespuesta=>{
                if (JSON.stringify(datosRespuesta) == 'true') {
                        window.location.href = 'listar';
                }
           }))
        }
    }
}
</script>