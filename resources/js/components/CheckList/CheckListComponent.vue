<template>
    <div>
        <div class="d-flex justify-content-between mb-3">
            <h3>Checklist</h3>
        </div>

        
        <div v-if="checklist.length > 0" class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tipo Equipo</th>
                        <th>Matriz Checklist</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Realizar</th>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="(check, index) in checklist">
                        <tr>
                            <th>{{ index + 1 }}</th>
                            <td>{{ check.tipoactivo.name }}</td>
                            <td>{{ check.matriz.nombre }}</td>
                            <td>{{ check.marca }}</td>
                            <td>{{ check.modelo }}</td>
                            <td>
                                <button type="button" class="btn btn-base-dv"
                                    @click="openCompletarCheckListModal(check)"><i class="bi bi-ui-checks"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">

                                <div class="accordion" id="accordionCheckListVehiculos">
                                    <template v-for="(check_vehiculo, index) in check.vehiculos">

                                        <div class="accordion-item">
                                            <h2 class="accordion-header"
                                                :id="'headingCheckListVehiculos' + check_vehiculo.id">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    :data-bs-target="'#collapseCheckListVehiculos' + check_vehiculo.id"
                                                    aria-expanded="true"
                                                    :aria-controls="'collapseCheckListVehiculos' + check_vehiculo.id">
                                                    <h6 class="mb-0">{{ check_vehiculo.patente }}</h6>
                                                </button>
                                            </h2>
                                            <div :id="'collapseCheckListVehiculos' + check_vehiculo.id"
                                                class="accordion-collapse collapse"
                                                :aria-labelledby="'headingCheckListVehiculos' + check_vehiculo.id"
                                                data-bs-parent="#accordionCheckListVehiculos">
                                                <div class="accordion-body">
                                                    <table class="table table-sm mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Check List</th>
                                                                <th>Numero Interno</th>
                                                                <th>Fecha</th>
                                                                <th>Turno</th>
                                                                <th>Estado Equipo</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <template
                                                                v-for="(check_vehiculo_detalle, index) in check_vehiculo.detalles">
                                                                <tr>
                                                                    <td>CHECK LIST {{ (index + 1).toString().padStart(4,
                                                                        '0') }}</td>
                                                                    <td>{{ check_vehiculo_detalle.numero_interno }}</td>
                                                                    <td>{{
                                                                        formatearFecha(check_vehiculo_detalle.created_at)
                                                                        }}</td>
                                                                    <td>{{ check_vehiculo_detalle.turno }}</td>
                                                                    <td>
                                                                        <span class="badge rounded-pill bg-primary">
                                                                            {{ check_vehiculo_detalle.estado_equipo ===
                                                                                1 ? 'Operativo' : 'Fuera De Servicio'
                                                                            }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-danger"
                                                                            :disabled="loading_pdf[check_vehiculo_detalle.id]"
                                                                            @click="downloadPDF(check, check.id, check_vehiculo.id, check_vehiculo_detalle.id)">
                                                                            <span
                                                                                v-if="loading_pdf[check_vehiculo_detalle.id]">
                                                                                <span
                                                                                    class="spinner-border spinner-border-sm"
                                                                                    role="status"
                                                                                    aria-hidden="true"></span>
                                                                            </span>
                                                                            <span v-else><i
                                                                                    class="bi bi-filetype-pdf"></i></span>
                                                                        </button>
                                                                        <button type="button" class="btn btn-primary"
                                                                            @click="openVerCheckListCompletadoModal({ check_id: check.id, check_list_vehiculo_id: check_vehiculo.id, check_list_vehiculo_detalle_id: check_vehiculo_detalle.id })">
                                                                            <i class="bi bi-eye"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            </template>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        <LoadingComponent v-else-if="loading_checklist" />
        <p v-else>No hay checklist.</p>

        <CompletarCheckListModal ref="completarCheckListModal" :completarCheckListProps="completarChecklist"
            :intervenciones="intervenciones" @checklist-completada="checklisCompletada" />

        <VerCheckListCompletadoModal ref="verCheckListCompletadoModal"
            :verCheckListProps="verCheckListCompletadoChecklist" />
    </div>
</template>

<script>
import checklistMixin from '../../mixins/checklist/checklistMixin';
import tipoActivoMixin from '../../mixins/tipoActivo/tipoActivoMixin';
import usuariosMixin from '../../mixins/usuarios/usuariosMixin';


import CompletarCheckListModal from './CompletarCheckListModal.vue';
import matrizChecklistMixin from '../../mixins/checklist/matrizChecklistMixin';
import VerCheckListCompletadoModal from './VerCheckListCompletadoModal.vue';
import LoadingComponent from '../base/LoadingComponent.vue';

export default {
    mixins: [checklistMixin, matrizChecklistMixin, tipoActivoMixin, usuariosMixin],
    components: {
        CompletarCheckListModal,
        VerCheckListCompletadoModal,
        LoadingComponent
    },
    data() {
        return {
            intervenciones: [],
            data_actualizada: [],
        };
    },
    methods: {
        async openCompletarCheckListModal(check) {
            this.$refs.completarCheckListModal.open();
            this.completarChecklist = check;
        },
        async openVerCheckListCompletadoModal(props) {
            this.$refs.verCheckListCompletadoModal.open();
            this.verCheckListCompletadoChecklist = this.obtenerCondiciones(props);
        },
        checklisCompletada() {
            this.fetchChecklist();
        },
        async downloadPDF(checklist, check_id, check_vehiculo_id, check_vehiculo_detalle_id) {
            if (checklist && check_id && check_vehiculo_id && check_vehiculo_detalle_id) {
                await this.descargarPDF(checklist, check_id, check_vehiculo_id, check_vehiculo_detalle_id);
            }
        },
        formatearFecha(fecha) {
            const fechaObj = new Date(fecha);
            const dia = String(fechaObj.getDate()).padStart(2, "0");
            const mes = String(fechaObj.getMonth() + 1).padStart(2, "0");
            const anio = fechaObj.getFullYear();
            return `${dia}-${mes}-${anio}`;
        },


        obtenerCondiciones(props) {
            if (!props || !this.checklist) return null;

            // Filtrar el checklist que coincide con el check_id
            const checklistOriginal = this.checklist.find(check => check.id === props.check_id);
            if (!checklistOriginal) return null;

            // Crear una copia profunda del checklist para no modificar el original
            const checklistNuevo = JSON.parse(JSON.stringify(checklistOriginal));

            // Iterar por las categorias dentro del nuevo checklist
            checklistNuevo.categorias?.forEach(categoria => {
                // Iterar por las intervenciones dentro de cada categoria
                categoria.intervenciones?.forEach(intervencion => {
                    // Verificar si tiene condiciones
                    if (intervencion.condiciones) {
                        // Filtrar las condiciones que coinciden con los ids de props
                        intervencion.condiciones = intervencion.condiciones.filter(condicion =>
                            condicion.checklist_vehiculo_detalle_id === props.check_list_vehiculo_detalle_id &&
                            condicion.checklist_vehiculo_id === props.check_list_vehiculo_id
                        );
                    }
                });
            });

            // Filtrar el vehículo que coincide con check_list_vehiculo_id
            const vehiculoFiltrado = checklistNuevo.vehiculos?.find(vehiculo => vehiculo.id === props.check_list_vehiculo_id);
            if (!vehiculoFiltrado) return null;

            // Filtrar los detalles del vehículo
            vehiculoFiltrado.detalles = vehiculoFiltrado.detalles?.find(detalle =>
                detalle.id === props.check_list_vehiculo_detalle_id &&
                detalle.checklist_vehiculo_id === props.check_list_vehiculo_id
            );

            // Mantener solo el vehículo filtrado en el checklist
            checklistNuevo.vehiculos = vehiculoFiltrado;

            // Retornar el checklist nuevo con las modificaciones
            return checklistNuevo;
        }

    },
    created() {
        this.fetchTipoActivosSelect();
        this.fetchMatrizChecklist();
        this.fetchChecklist();
        this.fetchUserRole();
    }
}
</script>

<style scoped></style>