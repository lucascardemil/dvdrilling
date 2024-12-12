<template>
    <div class="modal fade" id="editarReporteModal" tabindex="-1" aria-labelledby="editarReporteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarReporteModalLabel">Reporte</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="editarReporte">
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <h5>Datos Principales</h5>
                                <div class="row g-3 align-items-center">
                                    <div class="col-lg-4 col-md-12 mb-3">
                                        <label for="reporteUbicacion" class="form-label">Ubicacion</label>
                                        <select class="form-select" aria-label="Seleccione el proyecto"
                                            id="reporteUbicacion" v-model="editReporte.proyecto_id"
                                            :class="errors_reporte ? errors_reporte.proyecto_id ? 'is-invalid' : '' : ''"
                                            required>
                                            <option :value="null" disabled>Seleccione el Proyecto</option>
                                            <template v-for="proyecto in proyectos">
                                                <option :value="proyecto.id">{{ proyecto.name }}</option>
                                            </template>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-12 mb-3">
                                        <label for="reporteSondaje" class="form-label">Sondaje</label>
                                        <input type="text" class="form-control" id="reporteSondaje"
                                            v-model="editReporte.sondaje"
                                            :class="errors_reporte ? errors_reporte.sondaje ? 'is-invalid' : '' : ''"
                                            required>
                                    </div>
                                    <div class="col-lg-4 col-md-12 mb-3">
                                        <label for="reporteFecha" class="form-label">Fecha</label>
                                        <vuejs-datepicker :language="es" :highlighted="highlightToday" id="reporteFecha"
                                            v-model="editReporte.fecha" @input="onDateSelected"
                                            :bootstrap-styling="true" />
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center">
                                    <div class="col-lg-3 col-md-12 mb-3">
                                        <label for="reporteEmpresa" class="form-label">Empresa</label>
                                        <input type="text" class="form-control" id="reporteEmpresa"
                                            v-model="editReporte.empresa"
                                            :class="errors_reporte ? errors_reporte.empresa ? 'is-invalid' : '' : ''"
                                            required>
                                    </div>
                                    <div class="col-lg-3 col-md-12 mb-3">
                                        <label for="reporteSonda" class="form-label">Sonda</label>
                                        <input type="text" class="form-control" id="reporteSonda"
                                            v-model="editReporte.sonda"
                                            :class="errors_reporte ? errors_reporte.sonda ? 'is-invalid' : '' : ''"
                                            required>
                                    </div>
                                    <div class="col-lg-3 col-md-12 mb-3">
                                        <label for="reporteTurno" class="form-label">Turno</label>
                                        <input type="text" class="form-control" id="reporteTurno"
                                            placeholder="Dia/Noche" v-model="editReporte.turno"
                                            :class="errors_reporte ? errors_reporte.turno ? 'is-invalid' : '' : ''"
                                            required>
                                    </div>
                                    <div class="col-lg-3 col-md-12 mb-3">
                                        <label for="reporteHoras" class="form-label">Horas</label>
                                        <input type="text" class="form-control" id="reporteHoras"
                                            v-model="editReporte.horas"
                                            :class="errors_reporte ? errors_reporte.horas ? 'is-invalid' : '' : ''"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <h5>Avance Turno</h5>
                                <div class="row g-3 align-items-center">
                                    <div class="col-lg-3 col-md-12 mb-3">
                                        <label for="reporteDesde" class="form-label">Desde</label>
                                        <input type="number" step="0.01" class="form-control" id="reporteDesde"
                                            v-model="editReporte.desde"
                                            :class="errors_reporte ? errors_reporte.desde ? 'is-invalid' : '' : ''"
                                            required>
                                    </div>
                                    <div class="col-lg-3 col-md-12 mb-3">
                                        <label for="reporteHasta" class="form-label">Hasta</label>
                                        <input type="number" step="0.01" class="form-control" id="reporteHasta"
                                            v-model="editReporte.hasta"
                                            :class="errors_reporte ? errors_reporte.hasta ? 'is-invalid' : '' : ''"
                                            required>
                                    </div>
                                    <div class="col-lg-3 col-md-12 mb-3">
                                        <label for="reporteTotal" class="form-label">Total</label>
                                        <input type="text" class="form-control" id="reporteTotal"
                                            v-model="editReporte.total"
                                            :class="errors_reporte ? errors_reporte.total ? 'is-invalid' : '' : ''"
                                            required readonly>
                                    </div>
                                    <div class="col-lg-3 col-md-12 mb-3">
                                        <label for="reporteMetros" class="form-label">Metros</label>
                                        <input type="text" class="form-control" id="reporteMetros"
                                            v-model="editReporte.metros"
                                            :class="errors_reporte ? errors_reporte.metros ? 'is-invalid' : '' : ''"
                                            required>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center">
                                    <div class="col-lg-3 col-md-12 mb-3">
                                        <label for="reporteInclinacion" class="form-label">Inclinacion</label>
                                        <input type="text" class="form-control" id="reporteInclinacion"
                                            v-model="editReporte.inclinacion"
                                            :class="errors_reporte ? errors_reporte.inclinacion ? 'is-invalid' : '' : ''"
                                            required>
                                    </div>
                                    <div class="col-lg-3 col-md-12 mb-3">
                                        <label for="reporteRumbo" class="form-label">Rumbo</label>
                                        <input type="text" class="form-control" id="reporteRumbo"
                                            v-model="editReporte.rumbo"
                                            :class="errors_reporte ? errors_reporte.rumbo ? 'is-invalid' : '' : ''"
                                            required>
                                    </div>
                                    <div class="col-lg-3 col-md-12 mb-3">
                                        <label for="reportePrograma" class="form-label">Programa</label>
                                        <input type="text" class="form-control" id="reportePrograma"
                                            v-model="editReporte.programa"
                                            :class="errors_reporte ? errors_reporte.programa ? 'is-invalid' : '' : ''"
                                            required>
                                    </div>
                                    <div class="col-lg-3 col-md-12 mb-3">
                                        <label for="reporteDiametro" class="form-label">Diametro</label>
                                        <input type="text" class="form-control" id="reporteDiametro"
                                            v-model="editReporte.diametro"
                                            :class="errors_reporte ? errors_reporte.diametro ? 'is-invalid' : '' : ''"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-base-dv" :disabled="loading_create">
                            <span v-if="loading_create">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Cargando...</span>
                            <span v-else>Guardar Cambios</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import reporteMixin from '../../mixins/reporte/reporteMixin';
import Datepicker from 'vuejs-datepicker';
import { en, es } from 'vuejs-datepicker/dist/locale';


export default {
    mixins: [reporteMixin],
    components: {
        'vuejs-datepicker': Datepicker,
    },
    props: {
        reporte: Object,
        proyectos: Array
    },
    data() {
        return {
            editReporte: {
                proyecto_id: null,
                sondaje: '',
                fecha: new Date(),
                empresa: '',
                sonda: '',
                turno: '',
                horas: '',
                desde: '',
                hasta: '',
                total: '',
                metros: '',
                inclinacion: '',
                rumbo: '',
                programa: '',
                diametro: ''
            },
            showDatePicker: false,
            es: es,
            filtros: '',
            selectedReporte: null,
        }
    },
    watch: {
        reporte: {
            immediate: true,
            handler(Reporte) {
                if (Reporte) {
                    this.editReporte.reporte_id = Reporte.id;
                    this.editReporte.proyecto_id = Reporte.proyecto_id;
                    this.editReporte.sondaje = Reporte.sondaje;
                    this.editReporte.fecha = Reporte.fecha;
                    this.editReporte.empresa = Reporte.empresa;
                    this.editReporte.sonda = Reporte.sonda;
                    this.editReporte.turno = Reporte.turno;
                    this.editReporte.horas = Reporte.horas;
                    this.editReporte.desde = Reporte.desde;
                    this.editReporte.hasta = Reporte.hasta;
                    this.editReporte.total = Reporte.total;
                    this.editReporte.metros = Reporte.metros;
                    this.editReporte.inclinacion = Reporte.inclinacion;
                    this.editReporte.rumbo = Reporte.rumbo;
                    this.editReporte.programa = Reporte.programa;
                    this.editReporte.diametro = Reporte.diametro;
                }
            }
        },
        'editReporte.desde': 'calculateTotal',
        'editReporte.hasta': 'calculateTotal'
    },
    computed: {
        highlightToday() {
            const today = new Date();
            return {
                dates: [today],
            };
        },
    },
    methods: {
        open() {
            const modalElement = document.getElementById('editarReporteModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('editarReporteModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },
        async editarReporte() {
            const response = await this.actualizarReporte(this.editReporte);

            if (this.errors_reporte === null) {
                this.$notyf.success(response.message);
                this.$emit('actualizar-reporte', response.updated_reporte);
                this.close();
            }
        },
        onDateSelected(date) {
            this.editReporte.fecha = date;
            this.showDatePicker = false;
        },
        calculateTotal() {
            const desde = parseFloat(this.editReporte.desde) || 0;
            const hasta = parseFloat(this.editReporte.hasta) || 0;

            if (!isNaN(desde) && !isNaN(hasta)) {
                this.editReporte.total = (hasta - desde).toFixed(2);
            } else {
                this.editReporte.total = '';
            }
        }

    }
}
</script>