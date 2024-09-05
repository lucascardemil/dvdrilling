<template>
    <div>
        <div class="d-flex justify-content-between">
            <div>
                <h3>Proyecto</h3>
            </div>
            <div>
                <button type="button" class="btn btn-base-dv" @click="openCrearModal()"><i
                        class="bi bi-plus-circle"></i> Agregar Proyecto</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Habilitar Proyecto</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="proyectos.length">
                        <tr v-for="(proyecto, index) in proyectos" :key="proyecto.id">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ proyecto.name }}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="flexSwitchCheckDefault" v-model="proyecto.status"
                                        @change="handleEnabledChange(proyecto.id, proyecto.status)">
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" @click="openEditModal(proyecto)"><i class="bi bi-pencil-square"></i> Editar
                                    Proyecto</button>
                            </td>
                        </tr>
                    </template>
                    <p v-else-if="loading">Cargando...</p>
                    <p v-else>No hay proyectos.</p>
                    <p v-if="errors">{{ errors }}</p>
                </tbody>
            </table>
        </div>
        <CrearProyectoModal ref="crearProyectoModal" @proyecto-updated="fetchProyectos" />
        <EditProyectoModal ref="editProyectoModal" :proyecto="selectedProyecto" @proyecto-updated="fetchProyectos" />
    </div>
</template>

<script>
import proyectoMixin from '../../mixins/proyecto/proyectoMixin';
import CrearProyectoModal from './CrearProyectoModal.vue';
import EditProyectoModal from './EditProyectoModal.vue';

export default {
    mixins: [proyectoMixin],
    components: {
        CrearProyectoModal,
        EditProyectoModal
    },
    data() {
        return {
            selectedProyecto: null,
            checkbox: []
        };
    },
    methods: {
        openCrearModal() {
            this.$refs.crearProyectoModal.open();
        },
        openEditModal(proyecto) {
            if (proyecto) {
                this.selectedProyecto = { ...proyecto };
                this.$refs.editProyectoModal.open();
            }
        },
        async handleEnabledChange(proyectoId, status) {
            const checkboxStatus = status ? 1 : 0;
            const checkbox = { proyecto_id: proyectoId, status: checkboxStatus };

            try {
                const response = await this.actualizarStatus(checkbox);
                if (this.errors === null) {
                    this.$notyf.success(response.message);
                    this.$emit('proyecto-updated');
                }
            } catch (error) {
                console.error('Error actualizando el estado:', error);
            }
        }

    },
    mounted() {
        this.fetchProyectos();
    }
}
</script>

<style scoped></style>
