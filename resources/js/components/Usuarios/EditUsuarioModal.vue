<template>
    <div class="modal fade" id="editUsuarioModal" tabindex="-1" aria-labelledby="editUsuarioModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUsuarioModalLabel"><i class="bi bi-pencil-square"></i> Editar Rol</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="editRoleUsuario">
                        <div class="mb-3">
                            <label for="usuarioRol" class="form-label">Rol</label>
                            <select class="form-select" aria-label="Seleccione roles" v-model="editUsuario.selectedRol">
                                <option :value="null" disabled>Seleccione un rol</option>
                                <template v-for="rol in roles">
                                    <option :value="rol.id">{{ rol.name }}</option>
                                </template>
                            </select>
                        </div>
                        <template v-if="errors">
                            <div class="alert alert-danger" role="alert">
                                {{ errors }}
                            </div>
                        </template>
                        <button type="submit" class="btn btn-base-dv" :disabled="editUsuario.selectedRol == null">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import usuariosMixin from '../../mixins/usuarios/usuariosMixin';
import roleMixin from '../../mixins/roles/roleMixin';

export default {
    mixins: [usuariosMixin, roleMixin],
    props: {
        usuario: Object
    },
    data() {
        return {
            editUsuario: {
                selectedRol: null
            }
        };
    },
    methods: {
        open() {
            this.errors = null;
            this.editUsuario.selectedRol = null;
            const modalElement = document.getElementById('editUsuarioModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('editUsuarioModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },

        async editRoleUsuario() {
            const response = await this.actualizarUsuario({
                usuario_id: this.usuario.id,
                rol_id: this.editUsuario.selectedRol
            });

            if (this.errors === null) {
                this.$notyf.success(response.message);
                this.$emit('usuario-updated');
                this.close();
            }
        }
    },
    mounted() {
        this.fetchRoles();
    }
}
</script>

<style scoped></style>
