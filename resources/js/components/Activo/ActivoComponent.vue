<template>
    <div>
        <div class="mb-5">
            <button type="button" class="btn btn-base-dv" @click="openCrearModal()"><i class="bi bi-plus-circle"></i>
                Agregar Activo</button>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tipo de Activo</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Modelo</th>
                        <th scope="col">Patente</th>
                        <th scope="col">N° Interno</th>
                        <th scope="col">Año</th>
                        <th scope="col">Horómetro</th>
                        <th scope="col">Kilometraje</th>
                        <th scope="col">Color</th>
                        <th scope="col">Chasis</th>
                        <th scope="col">N° Motor</th>
                        <th scope="col">Habilitar Activo</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="activos.length">
                        <tr v-for="(activo, index) in activos" :key="activo.id">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ activo.tipo_activo.name }}</td>
                            <td>{{ activo.marca }}</td>
                            <td>{{ activo.modelo }}</td>
                            <td>{{ activo.patente }}</td>
                            <td>{{ activo.numero_interno }}</td>
                            <td>{{ activo.year }}</td>
                            <td>{{ activo.horometro }}</td>
                            <td>{{ activo.kilometraje }}</td>
                            <td>{{ activo.color }}</td>
                            <td>{{ activo.chasis }}</td>
                            <td>{{ activo.numero_motor }}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        :id="activo.id" v-model="activo.status"
                                        @change="handleEnabledChange(activo.id, activo.status)">
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-success" @click="openImagenesModal(activo)"><i
                                        class="bi bi-images"></i></button>
                                <button type="button" class="btn btn-warning" @click="openEditModal(activo)"><i
                                        class="bi bi-pencil-square"></i></button>
                            </td>
                        </tr>
                    </template>
                    <p v-else-if="loading">Cargando...</p>
                    <p v-else>No hay activos.</p>
                    <p v-if="errors">{{ errors }}</p>
                </tbody>
            </table>

        </div>
        <CrearActivoModal ref="crearActivoModal" :tipo_activos="tipo_activos" @activo-updated="fetchActivos" />
        <EditActivoModal ref="editActivoModal" :activo="selectedActivo" :tipo_activos="tipo_activos"
            @activo-updated="fetchActivos" />
        <ImagenesActivoModel ref="imagenesActivoModal" :activo="selectedActivo" @activo-updated="fetchActivos" />
    </div>
</template>

<script>
import activoMixin from '../../mixins/activo/activoMixin';
import tipoActivoMixin from '../../mixins/tipoActivo/tipoActivoMixin';
import CrearActivoModal from './CrearActivoModal.vue';
import EditActivoModal from './EditActivoModal.vue';
import ImagenesActivoModel from './ImagenesActivoModal.vue';

export default {
    mixins: [activoMixin, tipoActivoMixin],
    components: {
        CrearActivoModal,
        EditActivoModal,
        ImagenesActivoModel
    },
    data() {
        return {
            selectedActivo: null,
            checkbox: []
        };
    },
    methods: {
        openCrearModal() {
            this.$refs.crearActivoModal.open();
        },
        openEditModal(activo) {
            if (activo) {
                this.selectedActivo = { ...activo };
                this.$refs.editActivoModal.open();
            }
        },
        openImagenesModal(activo) {
            if (activo) {
                this.selectedActivo = { ...activo };
                this.$refs.imagenesActivoModal.open();
            }
        },
        async handleEnabledChange(activoId, status) {
            const checkboxStatus = status ? 1 : 0;
            const checkbox = { activo_id: activoId, status: checkboxStatus };

            try {
                const response = await this.actualizarStatusActivo(checkbox);
                if (this.errors === null) {
                    this.$notyf.success(response.message);
                    this.$emit('activo-updated');
                }
            } catch (error) {
                console.error('Error actualizando el estado:', error);
            }
        }

    },
    created() {
        this.fetchActivos();
        this.fetchTipoActivosSelect();
    }
}
</script>

<style scoped></style>
