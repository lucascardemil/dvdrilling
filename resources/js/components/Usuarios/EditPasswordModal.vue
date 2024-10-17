<template>
    <div class="modal fade" id="editPasswordUsuarioModal" tabindex="-1" aria-labelledby="editPasswordUsuarioModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPasswordUsuarioModalLabel"><i class="bi bi-pencil-square"></i>
                        Editar Contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="editPasswordUsuario">
                        <div class="mb-3">
                            <label for="editUsuarioPassword" class="form-label">Contraseña</label>
                            <input type="password" class="form-control"
                                :class="errors ? errors.password ? 'is-invalid' : '' : ''" id="editUsuarioPassword"
                                v-model="editUsuario.password" required>
                        </div>
                        <div class="mb-3">
                            <label for="editUsuarioConfirmarPassword" class="form-label">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="editUsuarioConfirmarPassword"
                                v-model="editUsuario.password_confirmation" required>
                        </div>
                        <template v-if="errors">
                            <div class="alert alert-danger" role="alert">
                                {{ errors.password[0] }}
                            </div>
                        </template>

                        <button type="submit" class="btn btn-base-dv"
                            :disabled="editUsuario.password == null || loading">
                            <span v-if="loading">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Cargando...</span>
                            <span v-else>Guardar
                                Cambios</span>
                        </button>
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
    props: {
        usuario: Object
    },
    data() {
        return {
            editUsuario: {
                usuario_id: 0,
                password: '',
                password_confirmation: ''
            }
        };
    },
    watch: {
        usuario: {
            immediate: true,
            handler(usuario) {
                if (usuario) {
                    this.editUsuario.usuario_id = usuario.id
                }
            }
        }
    },
    methods: {
        open() {
            this.errors = null;
            this.editUsuario.password = null;
            const modalElement = document.getElementById('editPasswordUsuarioModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('editPasswordUsuarioModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },

        async editPasswordUsuario() {
            const response = await this.actualizarPasswordUsuario(this.editUsuario);

            if (this.errors === null) {
                this.$notyf.success(response.message);
                this.close();
        
                if (response.logout) {
                    await this.logoutUsuario();
                    setTimeout(() => {
                        window.location.href = '/login';
                    }, 1000);
                }
            }
        }
    }
}
</script>

<style scoped></style>
