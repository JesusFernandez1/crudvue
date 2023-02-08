<template>
    <section id="log">
        <section class="vh-100 gradient-custom">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-dark text-white" style="border-radius: 1rem">
                            <div class="card-body p-5 text-center">
                                <div class="mb-md-5 mt-md-4 pb-5">
                                    <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                    <p class="text-white-50 mb-5">
                                        Please enter your login and password!
                                    </p>
                                    <form v-on:submit.prevent="loginUsuario()">
                                        <div class="form-outline form-white mb-4">
                                            <input type="text" v-model="usuario.email" id="email"
                                                class="form-control form-control-lg" required name="email" />
                                            <label class="form-label" for="typeEmailX">Email</label>
                                        </div>
                                        <div class="form-outline form-white mb-4">
                                            <input type="password" v-model="usuario.pass" id="pass"
                                                class="form-control form-control-lg" name="pass" />
                                            <label class="form-label" for="typePasswordX">Password</label>
                                        </div>
                                        <p class="small mb-5 pb-lg-2">
                                            <a class="text-white-50" href="#!">Forgot password?</a>
                                        </p>
                                        <button type="submit" class="btn btn-success">Aceptar</button>
                                    </form>
                                </div>
                                <div>
                                    <p class="mb-0">
                                        Don't have an account?
                                        <a href="#" class="text-white-50 fw-bold">Sign Up</a>
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
</template>

<script>
export default {
    data() {
        return {
            usuario: {

            }
        }
    },
    methods: {
        loginUsuario() {
            var datosEnviar = { email: this.usuario.email, pass: this.usuario.pass }
            fetch('http://localhost/user/?login', {
                method: "POST",
                body: JSON.stringify(datosEnviar)
            })
                .then(respuesta => respuesta.json())
                .then((datosRespuesta => {

                    console.log(datosRespuesta);
                    window.location.href = 'listar';
                }))
        }
    }

}
</script>

<style scoped>
.gradient-custom {
    /* fallback for old browsers */
    background: #6a11cb;
    /* Chrome 10-25, Safari 5.1-6 */
    background: -webkit-linear-gradient(to right,
            rgba(106, 17, 203, 1),
            rgba(37, 117, 252, 1));
    /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    background: linear-gradient(to right,
            rgba(106, 17, 203, 1),
            rgba(37, 117, 252, 1));
}
</style>