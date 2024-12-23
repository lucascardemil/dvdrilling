<template>
    <div class="modal fade" id="crearUsuarioModal" tabindex="-1" aria-labelledby="crearUsuarioModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearUsuarioModalLabel">Crear Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" @click="close" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="saveUsuario">
                        <div class="mb-3">
                            <label for="usuarioNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="usuarioNombre" v-model="newUsuario.name"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="usuarioEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="usuarioEmail" v-model="newUsuario.email"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="usuarioPassword" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="usuarioPassword"
                                v-model="newUsuario.password" :class="error_password ? 'is-invalid' : ''"
                                aria-describedby="password" required>
                            <div id="password" :class="error_password ? 'invalid-feedback' : ''">
                                {{ error_password ? error_password.password : '' }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="usuarioConfirmarPassword" class="form-label">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="usuarioConfirmarPassword"
                                v-model="newUsuario.password_confirmation" :class="error_password ? 'is-invalid' : ''"
                                aria-describedby="password_confirmation" required>

                            <div id="password_confirmation" :class="error_password ? 'invalid-feedback' : ''">
                                {{ error_password ? error_password.password_confirmation : '' }}
                            </div>
                        </div>

                        <template v-if="errors">
                            <div class="alert alert-danger" role="alert" v-for="email in errors.email">
                                {{ email }}
                            </div>

                            <div class="alert alert-danger" role="alert" v-for="password in errors.password">
                                {{ password }}
                            </div>
                        </template>
                        <button type="submit" class="btn btn-base-dv">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import usuariosMixin from '../../mixins/usuarios/usuariosMixin';

export default {
    mixins: [usuariosMixin],
    data() {
        return {
            newUsuario: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },

            error_password: null
        };
    },
    watch: {
        'newUsuario.password': 'verificarPassword',
        'newUsuario.password_confirmation': 'verificarPassword'
    },
    methods: {
        open() {
            this.errors = null;
            const modalElement = document.getElementById('crearUsuarioModal');
            const modal = new Modal(modalElement);
            this.limpiarForm();
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('crearUsuarioModal');
            const modal = Modal.getInstance(modalElement);
            this.limpiarForm();
            if (modal) modal.hide();
        },

        async saveUsuario() {
            const response = await this.createUsuario(this.newUsuario);

            if (this.errors === null) {
                this.$notyf.success(response.message);
                this.$emit('usuario-updated');
                this.limpiarForm();
                this.close();
            }
        },
        verificarPassword() {
            // Reset errors first
            this.error_password = {};

            // Validate password length
            if (this.newUsuario.password.length < 8) {
                this.error_password.password = "La Contraseña tiene que tener más de 8 caracteres";
            } else if (this.newUsuario.password.length > 15) {
                this.error_password.password = "La Contraseña tiene que tener menos de 15 caracteres";
            } else if (!/[0-9]/.test(this.newUsuario.password) || !/[!@#$%^&*(),.?":{}|<>]/.test(this.newUsuario.password)) {
                this.error_password.password = "La Contraseña debe contener al menos un número y un símbolo";
            } else if (this.newUsuario.password !== this.newUsuario.password_confirmation) {
                this.error_password.password = "La Contraseña deben ser iguales";
                this.error_password.password_confirmation = "La Contraseña deben ser iguales";
            }

            // If no errors, clear the object
            if (!this.error_password.password) {
                this.error_password = null;
            }
        },
        limpiarForm() {
            this.newUsuario.name = '';
            this.newUsuario.email = '';
            this.newUsuario.password = '';
            this.newUsuario.password_confirmation = '';
            this.error_password = null;
        }
    }
}
</script>

<style scoped></style>
