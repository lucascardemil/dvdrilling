<template>
    <div>
        <div class="d-flex justify-content-between mb-3">
            <h3>Reportes</h3>
        </div>

        <div class="card shadow mb-5">
            <div class="card-body">
                <form @submit.prevent="saveDatosPrincipales">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <h5>Datos Principales</h5>
                            <div class="row g-3 align-items-center">
                                <div class="col-lg-4 col-md-12 mb-3">
                                    <label for="reporteUbicacion" class="form-label">Ubicacion</label>
                                    <select class="form-select" aria-label="Seleccione el proyecto"
                                        id="reporteUbicacion" v-model="newReporte.proyecto_id"
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
                                        v-model="newReporte.sondaje"
                                        :class="errors_reporte ? errors_reporte.sondaje ? 'is-invalid' : '' : ''"
                                        required>
                                </div>
                                <div class="col-lg-4 col-md-12 mb-3">
                                    <label for="reporteFecha" class="form-label">Fecha</label>
                                    <vuejs-datepicker :language="es" :highlighted="highlightToday" id="reporteFecha"
                                        v-model="newReporte.fecha" @input="onDateSelected" :bootstrap-styling="true" />
                                </div>
                            </div>
                            <div class="row g-3 align-items-center">
                                <div class="col-lg-3 col-md-12 mb-3">
                                    <label for="reporteEmpresa" class="form-label">Empresa</label>
                                    <input type="text" class="form-control" id="reporteEmpresa"
                                        v-model="newReporte.empresa"
                                        :class="errors_reporte ? errors_reporte.empresa ? 'is-invalid' : '' : ''"
                                        required>
                                </div>
                                <div class="col-lg-3 col-md-12 mb-3">
                                    <label for="reporteSonda" class="form-label">Sonda</label>
                                    <input type="text" class="form-control" id="reporteSonda" v-model="newReporte.sonda"
                                        :class="errors_reporte ? errors_reporte.sonda ? 'is-invalid' : '' : ''"
                                        required>
                                </div>
                                <div class="col-lg-3 col-md-12 mb-3">
                                    <label for="reporteTurno" class="form-label">Turno</label>
                                    <input type="text" class="form-control" id="reporteTurno" placeholder="Dia/Noche"
                                        v-model="newReporte.turno"
                                        :class="errors_reporte ? errors_reporte.turno ? 'is-invalid' : '' : ''"
                                        required>
                                </div>
                                <div class="col-lg-3 col-md-12 mb-3">
                                    <label for="reporteHoras" class="form-label">Horas</label>
                                    <input type="number" min="0" class="form-control" id="reporteHoras"
                                        v-model="newReporte.horas"
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
                                    <input type="number" step="0.01" min="0" class="form-control" id="reporteDesde"
                                        v-model="newReporte.desde"
                                        :class="errors_reporte ? errors_reporte.desde ? 'is-invalid' : '' : ''"
                                        required>
                                </div>
                                <div class="col-lg-3 col-md-12 mb-3">
                                    <label for="reporteHasta" class="form-label">Hasta</label>
                                    <input type="number" step="0.01" min="0" class="form-control" id="reporteHasta"
                                        v-model="newReporte.hasta"
                                        :class="errors_reporte ? errors_reporte.hasta ? 'is-invalid' : '' : ''"
                                        required>
                                </div>
                                <div class="col-lg-3 col-md-12 mb-3">
                                    <label for="reporteTotal" class="form-label">Total</label>
                                    <input type="text" class="form-control" id="reporteTotal" v-model="newReporte.total"
                                        :class="errors_reporte ? errors_reporte.total ? 'is-invalid' : '' : ''" required
                                        readonly>
                                </div>
                                <div class="col-lg-3 col-md-12 mb-3">
                                    <label for="reporteMetros" class="form-label">Metros</label>
                                    <input type="number" min="0" class="form-control" id="reporteMetros"
                                        v-model="newReporte.metros"
                                        :class="errors_reporte ? errors_reporte.metros ? 'is-invalid' : '' : ''"
                                        required>
                                </div>
                            </div>
                            <div class="row g-3 align-items-center">
                                <div class="col-lg-3 col-md-12 mb-3">
                                    <label for="reporteInclinacion" class="form-label">Inclinacion</label>
                                    <input type="number" min="0" class="form-control" id="reporteInclinacion"
                                        v-model="newReporte.inclinacion"
                                        :class="errors_reporte ? errors_reporte.inclinacion ? 'is-invalid' : '' : ''"
                                        required>
                                </div>
                                <div class="col-lg-3 col-md-12 mb-3">
                                    <label for="reporteRumbo" class="form-label">Rumbo</label>
                                    <input type="number" min="0" class="form-control" id="reporteRumbo"
                                        v-model="newReporte.rumbo"
                                        :class="errors_reporte ? errors_reporte.rumbo ? 'is-invalid' : '' : ''"
                                        required>
                                </div>
                                <div class="col-lg-3 col-md-12 mb-3">
                                    <label for="reportePrograma" class="form-label">Programa</label>
                                    <input type="text" class="form-control" id="reportePrograma"
                                        v-model="newReporte.programa"
                                        :class="errors_reporte ? errors_reporte.programa ? 'is-invalid' : '' : ''"
                                        required>
                                </div>
                                <div class="col-lg-3 col-md-12 mb-3">
                                    <label for="reporteDiametro" class="form-label">Diametro</label>
                                    <input type="text" class="form-control" id="reporteDiametro"
                                        v-model="newReporte.diametro"
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

        <div class="row g-2 mb-4">
            <div class="col-md">
                <div class="form-floating">
                    <input type="text" class="form-control" id="filtrarNombre" v-model="filtros">
                    <label for="filtrarNombre">Filtrar</label>
                </div>
            </div>
        </div>
        <template v-if="reportes.length > 0">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <tr v-for="reporte in ListaReportes" :key="reporte.id">
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title">{{ reporte.proyecto.name }}</h5>
                                    <div>
                                        <button type="button" class="btn btn-warning"
                                            @click="openEditarReporteModal(reporte)"><i
                                                class="bi bi-pencil-square"></i></button>

                                        <button type="button" class="btn btn-danger" :disabled="loading_pdf[reporte.id]"
                                            @click="downloadPDF(reporte)">
                                            <span v-if="loading_pdf[reporte.id]">
                                                <span class="spinner-border spinner-border-sm" role="status"
                                                    aria-hidden="true"></span>
                                            </span>
                                            <span v-else><i class="bi bi-filetype-pdf"></i></span>
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <ul class="list-group list-group-flush">
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                <strong>Empresa</strong>
                                                <span>{{ reporte.empresa }}</span>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                <strong>Sondaje</strong>
                                                <span>{{ reporte.sondaje }}</span>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                <div class="me-auto">
                                                    <div class="fw-bold">Fecha</div>
                                                    <span>{{ reporte.fecha }}</span>
                                                </div>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                <strong>Sonda</strong>
                                                <span>{{ reporte.sonda }}</span>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                <strong>Turno</strong>
                                                <span>{{ reporte.turno }}</span>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                <strong>Horas</strong>
                                                <span>{{ reporte.horas }}</span>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                <strong>Desde</strong>
                                                <span>{{ reporte.desde }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col">
                                        <ul class="list-group list-group-flush">
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                <strong>Hasta</strong>
                                                <span>{{ reporte.hasta }}</span>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                <strong>Total</strong>
                                                <span>{{ reporte.total }}</span>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                <strong>Metros</strong>
                                                <span>{{ reporte.metros }}</span>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                <strong>Inclinación</strong>
                                                <span>{{ reporte.inclinacion }}</span>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                <strong>Rumbo</strong>
                                                <span>{{ reporte.rumbo }}</span>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                <strong>Programa</strong>
                                                <span>{{ reporte.programa }}</span>
                                            </li>
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                <strong>Diámetro</strong>
                                                <span>{{ reporte.diametro }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <div class="dropdown">
                                    <button class="btn btn-base-dv dropdown-toggle" type="button"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-plus-circle"></i> Agregar
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li :class="reporte.horometro.length > 0 ? 'realizado' : 'no_realizado'">
                                            <a class="dropdown-item" href="#"
                                                @click="openHorometroModal(reporte)">Horómetro</a>
                                        </li>
                                        <li
                                            :class="reporte.corona_escareador.length > 0 ? 'realizado' : 'no_realizado'">
                                            <a class="dropdown-item" href="#"
                                                @click="openCoronasEscareadoresModal(reporte)">Control Coronas y
                                                Escareadores</a>
                                        </li>
                                        <li :class="reporte.aditivo.length > 0 ? 'realizado' : 'no_realizado'">
                                            <a class="dropdown-item" href="#"
                                                @click="openAditivosModal(reporte)">Control de Aditivos</a>
                                        </li>
                                        <li :class="reporte.herramienta.length > 0 ? 'realizado' : 'no_realizado'">
                                            <a class="dropdown-item" href="#"
                                                @click="openHerramientasModal(reporte)">Control de Herramientas</a>
                                        </li>
                                        <li :class="reporte.perforacion.length > 0 ? 'realizado' : 'no_realizado'">
                                            <a class="dropdown-item" href="#"
                                                @click="openPerforacionesModal(reporte)">Perforación en Roca</a>
                                        </li>
                                        <li :class="reporte.detalle_hora.length > 0 ? 'realizado' : 'no_realizado'">
                                            <a class="dropdown-item" href="#"
                                                @click="openDetalleHorasModal(reporte)">Detalle Horas</a>
                                        </li>
                                        <li :class="reporte.observacion.length > 0 ? 'realizado' : 'no_realizado'">
                                            <a class="dropdown-item" href="#"
                                                @click="openObservacionModal(reporte)">Observaciones</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </tr>
            </div>
        </template>
        <p v-else-if="loading">Cargando...</p>
        <p v-else>No hay reportes.</p>
        <p v-if="errors">{{ errors }}</p>

        <PaginacionComponent :paginaActual="paginaActual" :totalPaginas="totalPaginas" @cambiar-pagina="cambiarPagina"
            @cambiar-pagina-actual="cambiarPaginaActual" />
        <EditarReporteModal ref="editarReporteModal" :reporte="selectedReporte" :proyectos="proyectos"
            @actualizar-reporte="actualizarReporte" />

        <HorometroModal ref="horometroModal" :reporte="selectedReporte" />
        <CoronasEscareadoresModal ref="coronasEscareadoresModal" :reporte="selectedReporte" />
        <AditivoModal ref="aditivosModal" :reporte="selectedReporte" />
        <HerramientaModal ref="herramientasModal" :reporte="selectedReporte" />
        <PerforacionModal ref="perforacionesModal" :reporte="selectedReporte" />
        <DetalleHorasModal ref="detalleHorasModal" :reporte="selectedReporte" :actividades="actividades" />
        <ObservacionModal ref="observacionModal" :reporte="selectedReporte" />
    </div>
</template>

<script>
import proyectoMixin from '../../mixins/proyecto/proyectoMixin';
import reporteMixin from '../../mixins/reporte/reporteMixin';
import actividadMixin from '../../mixins/actividad/actividadMixin';
import Datepicker from 'vuejs-datepicker';
import { en, es } from 'vuejs-datepicker/dist/locale';

import PaginacionComponent from '../base/PaginacionComponent.vue';
import EditarReporteModal from './EditarReporteModal.vue';
import HorometroModal from './Horometro/HorometroModal.vue';
import CoronasEscareadoresModal from './CoronasEscareadores/CoronasEscareadoresModal.vue';
import AditivoModal from './Aditivos/AditivoModal.vue';
import HerramientaModal from './Herramientas/HerramientaModal.vue';
import PerforacionModal from './Perforacion/PerforacionModal.vue';
import DetalleHorasModal from './DetalleHoras/DetalleHorasModal.vue';
import ObservacionModal from './Observacion/ObservacionModal.vue';

export default {
    mixins: [proyectoMixin, reporteMixin, actividadMixin],
    components: {
        'vuejs-datepicker': Datepicker,
        PaginacionComponent,
        HorometroModal,
        CoronasEscareadoresModal,
        AditivoModal,
        HerramientaModal,
        PerforacionModal,
        DetalleHorasModal,
        ObservacionModal,
        EditarReporteModal
    },
    data() {
        return {
            newReporte: {
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
            paginaActual: 1,
            filasPorPagina: 10,
        }
    },
    watch: {
        'newReporte.desde': 'calculateTotal',
        'newReporte.hasta': 'calculateTotal'
    },
    computed: {
        totalPaginas() {
            return Math.ceil(this.filtrarReportes.length / this.filasPorPagina);
        },
        ListaReportes() {
            const start = (this.paginaActual - 1) * this.filasPorPagina;
            const end = start + this.filasPorPagina;
            return this.filtrarReportes.slice(start, end);
        },
        highlightToday() {
            const today = new Date();
            return {
                dates: [today],
            };
        },
        filtrarReportes() {
            return this.reportes.filter(reporte => {
                return reporte.empresa.includes(this.filtros) ||
                    reporte.sondaje.includes(this.filtros) ||
                    reporte.sonda.includes(this.filtros) ||
                    reporte.turno.includes(this.filtros) ||
                    reporte.proyecto.name.includes(this.filtros) ||
                    reporte.fecha.includes(this.filtros);
            });
        }
    },
    methods: {
        cambiarPaginaActual(newPage) {
            this.paginaActual = newPage;
        },
        cambiarPagina(newPage) {
            this.paginaActual = newPage;
        },
        openEditarReporteModal(reporte) {
            if (reporte) {
                this.selectedReporte = { ...reporte };
                this.$refs.editarReporteModal.open();
            }
        },
        openHorometroModal(reporte) {
            if (reporte) {
                this.selectedReporte = { ...reporte };
                this.$refs.horometroModal.open();
            }
        },
        openCoronasEscareadoresModal(reporte) {
            if (reporte) {
                this.selectedReporte = { ...reporte };
                this.$refs.coronasEscareadoresModal.open();
            }
        },
        openAditivosModal(reporte) {
            if (reporte) {
                this.selectedReporte = { ...reporte };
                this.$refs.aditivosModal.open();
            }
        },
        openHerramientasModal(reporte) {
            if (reporte) {
                this.selectedReporte = { ...reporte };
                this.$refs.herramientasModal.open();
            }
        },
        openPerforacionesModal(reporte) {
            if (reporte) {
                this.selectedReporte = { ...reporte };
                this.$refs.perforacionesModal.open();
            }
        },
        openDetalleHorasModal(reporte) {
            if (reporte) {
                this.selectedReporte = { ...reporte };
                this.$refs.detalleHorasModal.open();
            }
        },
        openObservacionModal(reporte) {
            if (reporte) {
                this.selectedReporte = { ...reporte };
                this.$refs.observacionModal.open();
            }
        },
        async downloadPDF(reporte) {
            if (reporte) {
                await this.descargarPDF(reporte);
            }
        },
        async saveDatosPrincipales() {
            const response = await this.createReporte(this.newReporte);

            if (this.errors_reporte === null) {
                this.$notyf.success(response.message);
                this.newReporte = {
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
                }

                this.fetchReportes();
            }
        },
        actualizarReporte(reporte_actualizado) {
            if (reporte_actualizado) {
                this.reportes.forEach(reporte => {
                    if (reporte.id === reporte_actualizado.id) {
                        reporte.proyecto_id = reporte_actualizado.proyecto_id,
                            reporte.proyecto = reporte_actualizado.proyecto,
                            reporte.sondaje = reporte_actualizado.sondaje;
                        reporte.fecha = reporte_actualizado.fecha;
                        reporte.empresa = reporte_actualizado.empresa;
                        reporte.sonda = reporte_actualizado.sonda;
                        reporte.turno = reporte_actualizado.turno;
                        reporte.horas = reporte_actualizado.horas;
                        reporte.desde = reporte_actualizado.desde;
                        reporte.hasta = reporte_actualizado.hasta;
                        reporte.total = reporte_actualizado.total;
                        reporte.metros = reporte_actualizado.metros;
                        reporte.inclinacion = reporte_actualizado.inclinacion;
                        reporte.rumbo = reporte_actualizado.rumbo;
                        reporte.programa = reporte_actualizado.programa;
                        reporte.diametro = reporte_actualizado.diametro;
                    }
                });
            }
        },
        onDateSelected(date) {
            this.newReporte.fecha = date;
            this.showDatePicker = false;
        },
        calculateTotal() {
            const desde = parseFloat(this.newReporte.desde) || 0;
            const hasta = parseFloat(this.newReporte.hasta) || 0;

            if (!isNaN(desde) && !isNaN(hasta)) {
                this.newReporte.total = (hasta - desde).toFixed(2);
            } else {
                this.newReporte.total = '';
            }
        }

    },
    created() {
        this.fetchReportes();
        this.fetchProyectosSelect();
        this.fetchActividadesSelect();
    }
}
</script>

<style>
.dropdown-menu {
    min-width: 20rem;
}

.dropdown-menu .no_realizado a {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.dropdown-menu .no_realizado a::after {
    content: "\F623";
    font-family: bootstrap-icons !important;
    font-size: 16px;
    font-weight: bold;
    color: #dc3545;
}

.dropdown-menu .realizado a {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.dropdown-menu .realizado a::after {
    content: "\F26B";
    font-family: bootstrap-icons !important;
    font-size: 18px;
    font-weight: bold;
    color: #198754
}
</style>