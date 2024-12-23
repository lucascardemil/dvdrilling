<template>
    <div>
        <div class="d-flex justify-content-between mb-3">
            <h3>Usuarios</h3>
            <button type="button" class="btn btn-base-dv" @click="openCrearModal()"><i class="bi bi-plus-circle"></i>
                Agregar Usuario</button>
        </div>

        <LoadingComponent v-if="loading"></LoadingComponent>
        <div v-else class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Email</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Habilitar Usuario</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="usuarios.length">
                        <tr v-for="(usuario, index) in usuarios" :key="usuario.id">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ usuario.name }}</td>
                            <td>{{ usuario.email }}</td>
                            <td v-if="usuario.roles.length > 0" v-for="(rol, index) in usuario.roles" :key="index">
                                {{ rol.name }}
                            </td>
                            <td v-if="usuario.roles.length === 0">No tiene rol</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        :id="'status-' + usuario.id" v-model="usuario.status"
                                        @change="handleEnabledChange(usuario.id, usuario.status)">
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-warning" @click="openEditPasswordModal(usuario)"><i
                                        class="bi bi-pencil-square"></i> Editar Contraseña</button>
                                <button type="button" class="btn btn-primary" @click="openEditModal(usuario)"><i
                                        class="bi bi-pencil-square"></i> Editar
                                    Rol</button>
                            </td>
                        </tr>
                    </template>
                    <p v-else>No hay usuarios.</p>
                    <p v-if="errors">{{ errors }}</p>
                </tbody>
            </table>
        </div>
        <CrearUsuarioModal ref="crearUsuarioModal" @usuario-updated="fetchUsuarios" />
        <EditUsuarioModal ref="editUsuarioModal" :usuario="selectedUsuario" @usuario-updated="fetchUsuarios" />
        <EditPasswordModal ref="editPasswordUsuarioModal" :usuario="selectedUsuario" @usuario-updated="fetchUsuarios" />
    </div>
</template>

<script>
import usuariosMixin from '../../mixins/usuarios/usuariosMixin';
import CrearUsuarioModal from './CrearUsuarioModal.vue';
import EditUsuarioModal from './EditUsuarioModal.vue';
import EditPasswordModal from './EditPasswordModal.vue';
import LoadingComponent from '../base/LoadingComponent.vue';

export default {
    mixins: [usuariosMixin],
    components: {
        CrearUsuarioModal,
        EditUsuarioModal,
        EditPasswordModal,
        LoadingComponent
    },
    data() {
        return {
            selectedUsuario: null,
            checkbox: []
        };
    },
    methods: {
        openCrearModal() {
            this.$refs.crearUsuarioModal.open();
        },
        openEditModal(usuario) {
            if (usuario) {
                this.selectedUsuario = { ...usuario };
                this.$refs.editUsuarioModal.open();
            }
        },
        openEditPasswordModal(usuario) {
            if (usuario) {
                this.selectedUsuario = { ...usuario };
                this.$refs.editPasswordUsuarioModal.open();
            }
        },
        async handleEnabledChange(usuarioId, status) {
            const checkboxStatus = status ? 1 : 0;
            const checkbox = { usuario_id: usuarioId, status: checkboxStatus };

            try {
                await this.actualizarStatus(checkbox);
                this.$emit('usuario-updated');
            } catch (error) {
                console.error('Error actualizando el estado:', error);
            }
        }

    },
    created() {
        this.fetchUsuarios();
    }
}
</script>

<style scoped></style>
