<template>
    <div>

        <div class="mb-5">
            <button type="button" class="btn btn-base-dv" @click="openCrearModal()"><i class="bi bi-plus-circle"></i>
                Agregar Tipo Activo</button>
        </div>

        <LoadingComponent v-if="loading"></LoadingComponent>
        <div v-else class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Habilitar Tipo Activo</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="tipo_activos.length">
                        <tr v-for="(tipo_activo, index) in tipo_activos" :key="tipo_activo.id">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ tipo_activo.name }}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        :id="tipo_activo.id" v-model="tipo_activo.status"
                                        @change="handleEnabledChange(tipo_activo.id, tipo_activo.status)">
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" @click="openEditModal(tipo_activo)"><i class="bi bi-pencil-square"></i> Editar
                                    Tipo Activo</button>
                            </td>
                        </tr>
                    </template>
                    <p v-else>No hay tipos de activo.</p>
                    <p v-if="errors">{{ errors }}</p>
                </tbody>
            </table>
        </div>
        <CrearTipoActivoModal ref="crearTipoActivoModal" @tipo-activos-updated="fetchTipoActivos" />
        <EditTipoActivoModal ref="editTipoActivoModal" :tipo_activo="selectedTipoActivo" @tipo-activos-updated="fetchTipoActivos" />
    </div>
</template>

<script>
import tipoActivoMixin from '../../mixins/tipoActivo/tipoActivoMixin';
import CrearTipoActivoModal from './CrearTipoActivoModal.vue';
import EditTipoActivoModal from './EditTipoActivoModal.vue';
import LoadingComponent from '../base/LoadingComponent.vue';

export default {
    mixins: [tipoActivoMixin],
    components: {
        CrearTipoActivoModal,
        EditTipoActivoModal,
        LoadingComponent
    },
    data() {
        return {
            selectedTipoActivo: null,
            checkbox: []
        };
    },
    methods: {
        openCrearModal() {
            this.$refs.crearTipoActivoModal.open();
        },
        openEditModal(tipo_activo) {
            if (tipo_activo) {
                this.selectedTipoActivo = { ...tipo_activo };
                this.$refs.editTipoActivoModal.open();
            }
        },
        async handleEnabledChange(tipo_activoId, status) {
            const checkboxStatus = status ? 1 : 0;
            const checkbox = { tipo_activo_id: tipo_activoId, status: checkboxStatus };

            try {
                const response = await this.actualizarStatus(checkbox);
                if (this.errors === null) {
                    this.$notyf.success(response.message);
                    this.$emit('tipo-activos-updated');
                }
            } catch (error) {
                console.error('Error actualizando el estado:', error);
            }
        }

    },
    created() {
        this.fetchTipoActivos();
    }
}
</script>

<style scoped></style>
