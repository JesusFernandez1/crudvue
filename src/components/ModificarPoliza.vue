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
                      <select  v-model="poliza.estado" required name="estado" id="estado" class="form-select" aria-label="Default select example">
                        <option value="">{{ poliza.provincia }}</option>
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
            fetch('https://ieslamarisma.net/proyectos/2023/jesusfernandez/Vue/poliza/?consultarModificar='+this.$route.params.id)
                .then(respuesta => respuesta.json())
                .then((datosRespuesta) => {

                    console.log(datosRespuesta)
                    this.poliza = datosRespuesta[0];

                })
                .catch(console.log)
        },
        actualizarRegistro(){
            var datosEnviar={importe: this.poliza.importe, fecha: this.poliza.fecha, estado: this.poliza.estado, observaciones: this.poliza.observaciones}

            fetch('https://ieslamarisma.net/proyectos/2023/jesusfernandez/Vue/poliza/?actualizar='+this.$route.params.id, {
                method:"POST",
                body:JSON.stringify(datosEnviar)
            })
            .then(respuesta => respuesta.json())
            .then((datosRespuesta=>{
                if (JSON.stringify(datosRespuesta) == 'true') {
                  this.$router.push({name: "listar"});
                }
           }))
        }
    }
}
</script>