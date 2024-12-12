<template>
    <div class="modal fade" id="crearUsuarioModal" tabindex="-1" aria-labelledby="crearUsuarioModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearUsuarioModalLabel">Crear Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                v-model="newUsuario.password" required>
                        </div>
                        <div class="mb-3">
                            <label for="usuarioConfirmarPassword" class="form-label">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="usuarioConfirmarPassword"
                                v-model="newUsuario.password_confirmation" required>
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
            }
        };
    },
    methods: {
        open() {
            this.errors = null;
            const modalElement = document.getElementById('crearUsuarioModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('crearUsuarioModal');
            const modal = Modal.getInstance(modalElement);
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

        limpiarForm() {
            this.newUsuario.name = '';
            this.newUsuario.email = '';
            this.newUsuario.password = '';
            this.newUsuario.password_confirmation = '';
        }
    }
}
</script>

<style scoped></style>
