<template>
    <div>

        <div class="d-flex justify-content-between">
            <div>
                <h3>Glosario de Actividades</h3>
            </div>
            <div>
                <button type="button" class="btn btn-base-dv" @click="openCrearModal()"><i
                        class="bi bi-plus-circle"></i> Agregar Actividad</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Habilitar Actividades</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="actividades.length">
                        <tr v-for="(actividad, index) in actividades" :key="actividad.id">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ actividad.name }}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="flexSwitchCheckDefault" v-model="actividad.status"
                                        @change="handleEnabledChange(actividad.id, actividad.status)">
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" @click="openEditModal(actividad)"><i class="bi bi-pencil-square"></i> Editar
                                    Actividades</button>
                            </td>
                        </tr>
                    </template>
                    <p v-else-if="loading">Cargando...</p>
                    <p v-else>No hay actividades.</p>
                    <p v-if="errors">{{ errors }}</p>
                </tbody>
            </table>
        </div>
        <CrearActividadModal ref="crearActividadModal" @actividad-updated="fetchActividades" />
        <EditActividadModal ref="editActividadModal" :actividad="selectedActividad" @actividad-updated="fetchActividades" />
    </div>
</template>

<script>
import actividadMixin from '../../mixins/actividad/actividadMixin';
import CrearActividadModal from './CrearActividadModal.vue';
import EditActividadModal from './EditActividadModal.vue';

export default {
    mixins: [actividadMixin],
    components: {
        CrearActividadModal,
        EditActividadModal
    },
    data() {
        return {
            selectedActividad: null,
            checkbox: []
        };
    },
    methods: {
        openCrearModal() {
            this.$refs.crearActividadModal.open();
        },
        openEditModal(actividad) {
            if (actividad) {
                this.selectedActividad = { ...actividad };
                this.$refs.editActividadModal.open();
            }
        },
        async handleEnabledChange(actividadId, status) {
            const checkboxStatus = status ? 1 : 0;
            const checkbox = { actividad_id: actividadId, status: checkboxStatus };

            try {
                const response = await this.actualizarStatus(checkbox);
                if (this.errors === null) {
                    this.$notyf.success(response.message);
                    this.$emit('actividad-updated');
                }
            } catch (error) {
                console.error('Error actualizando el estado:', error);
            }
        }

    },
    mounted() {
        this.fetchActividades();
    }
}
</script>

<style scoped></style>
