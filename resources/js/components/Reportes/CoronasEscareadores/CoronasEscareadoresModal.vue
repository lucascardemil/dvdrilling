<template>
    <div class="modal fade" id="coronasEscareadoresModal" tabindex="-1" aria-labelledby="coronasEscareadoresModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="coronasEscareadoresModalLabel">Control Coronas y Escareadores</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row" v-if="habilitarEditar">
                        <div class="col-12">
                            <EditarCoronaEscareador :data="editCoronasEscareadores"
                                @actualizar-corona-escareador="actualizarCoronaEscareador"
                                @cancelar-editar="cancelarEditarCoronaEscareador">
                            </EditarCoronaEscareador>
                        </div>
                    </div>
                    <div class="row" v-else>
                        <div class="col-4">
                            <div class="card shadow mb-3">
                                <div class="card-body">
                                    <form @submit.prevent="crearCoronasEscareadores">
                                        <div class="mb-3">
                                            <label for="coronasEscareadoresDetalla" class="form-label">Detalle</label>
                                            <select class="form-select" aria-label="Seleccione un detalle"
                                                v-model="newCoronasEscareadores.detalle" id="coronasEscareadoresDetalla"
                                                :class="errors_coronasEscareadores ? errors_coronasEscareadores.inicio ? 'is-invalid' : '' : ''"
                                                required>
                                                <option :value="null" disabled>Seleccione un Detalle</option>
                                                <option value="corona">Corona</option>
                                                <option value="escareador">Escareador</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="coronasEscareadoresDesde" class="form-label">Desde</label>
                                            <input type="number" min="0" class="form-control"
                                                id="coronasEscareadoresDesde" v-model="newCoronasEscareadores.desde"
                                                :class="errors_coronasEscareadores ? errors_coronasEscareadores.desde ? 'is-invalid' : '' : ''"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="coronasEscareadoresHasta" class="form-label">Hasta</label>
                                            <input type="number" min="0" class="form-control"
                                                id="coronasEscareadoresHasta" v-model="newCoronasEscareadores.hasta"
                                                :class="errors_coronasEscareadores ? errors_coronasEscareadores.hasta ? 'is-invalid' : '' : ''"
                                                required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="coronasEscareadoresDiametro" class="form-label">Diametro</label>
                                            <input type="number" min="0" class="form-control"
                                                id="coronasEscareadoresDiametro"
                                                v-model="newCoronasEscareadores.diametro"
                                                :class="errors_coronasEscareadores ? errors_coronasEscareadores.diametro ? 'is-invalid' : '' : ''"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="coronasEscareadoresNumeroCorona" class="form-label">N°
                                                Corona</label>
                                            <input type="number" min="0" class="form-control"
                                                id="coronasEscareadoresNumeroCorona"
                                                v-model="newCoronasEscareadores.numero_corona"
                                                :class="errors_coronasEscareadores ? errors_coronasEscareadores.numero_corona ? 'is-invalid' : '' : ''"
                                                required>
                                        </div>

                                        <button type="submit" class="btn btn-base-dv" :disabled="loading_create">
                                            <span v-if="loading_create">
                                                <span class="spinner-border spinner-border-sm" role="status"
                                                    aria-hidden="true"></span>
                                                Cargando...</span>
                                            <span v-else>Guardar Cambios</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div v-if="!habilitarEliminar">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Detalle</th>
                                            <th scope="col">Desde</th>
                                            <th scope="col">Hasta</th>
                                            <th scope="col">Diametro</th>
                                            <th scope="col">N° Corona</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="coronasEscareadores in ListaCoronasEscareadores"
                                            :key="coronasEscareadores.id">
                                            <th scope="row">{{ coronasEscareadores.id }}</th>
                                            <td>{{ coronasEscareadores.detalle }}</td>
                                            <td>{{ coronasEscareadores.desde }}</td>
                                            <td>{{ coronasEscareadores.hasta }}</td>
                                            <td>{{ coronasEscareadores.diametro }}</td>
                                            <td>{{ coronasEscareadores.numero_corona }}</td>
                                            <td class="text-end">
                                                <button type="button" class="btn btn-primary"
                                                    @click="openEditarCoronaEscareador(coronasEscareadores)"><i
                                                        class="bi bi-pencil-square"></i></button>
                                                <button type="button" class="btn btn-danger"
                                                    @click="openElimninarCoronaEscareador(coronasEscareadores)"><i
                                                        class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <PaginacionComponent :paginaActual="paginaActual" :totalPaginas="totalPaginas"
                                    @cambiar-pagina="cambiarPagina" />
                            </div>
                            <EliminarCoronaEscareador :data="eliminarCoronaEscareador"
                                @confirmado-eliminar="confirmadoEliminarCoronaEscareador"
                                @cancelar-eliminar="cancelarEliminarCoronaEscareador" v-else></EliminarCoronaEscareador>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import coronasEscareadoresMixin from '../../../mixins/reporte/coronasEscareadoresMixin';
import PaginacionComponent from '../../base/PaginacionComponent.vue';
import EditarCoronaEscareador from './EditarCoronaEscareador.vue';
import EliminarCoronaEscareador from './EliminarCoronaEscareador.vue';

export default {
    mixins: [coronasEscareadoresMixin],
    components: {
        PaginacionComponent,
        EditarCoronaEscareador,
        EliminarCoronaEscareador
    },
    props: {
        reporte: Object,
    },
    data() {
        return {
            newCoronasEscareadores: {
                reporte_id: 0,
                detalle: null,
                desde: 0,
                hasta: 0,
                diametro: 0,
                numero_corona: 0
            },
            editCoronasEscareadores: {},
            existeInicio: false,
            eliminarCoronaEscareador: {},
            habilitarEliminar: false,
            paginaActual: 1,
            filasPorPagina: 7,
            habilitarEditar: false
        };
    },
    computed: {
        totalPaginas() {
            return Math.ceil(this.coronasEscareadores.length / this.filasPorPagina);
        },
        ListaCoronasEscareadores() {
            const start = (this.paginaActual - 1) * this.filasPorPagina;
            const end = start + this.filasPorPagina;
            return this.coronasEscareadores.slice(start, end);
        }
    },
    watch: {
        reporte: {
            immediate: true,
            handler(Reporte) {
                if (Reporte) {
                    this.coronasEscareadores = Reporte.corona_escareador;
                    this.newCoronasEscareadores.reporte_id = Reporte.id;
                }
            }
        },
        'newCoronasEscareadores.desde': 'validarInicioTermino',
        'newCoronasEscareadores.hasta': 'validarInicioTermino'
    },
    methods: {
        cambiarPagina(newPage) {
            this.paginaActual = newPage;
        },
        openEditarCoronaEscareador(coronasEscareadores) {
            this.habilitarEditar = true;
            this.editCoronasEscareadores = {
                id: coronasEscareadores.id,
                reporte_id: coronasEscareadores.reporte_id,
                detalle: coronasEscareadores.detalle,
                desde: coronasEscareadores.desde,
                hasta: coronasEscareadores.hasta,
                diametro: coronasEscareadores.diametro,
                numero_corona: coronasEscareadores.numero_corona
            }
        },
        openElimninarCoronaEscareador(coronasEscareadores) {
            this.habilitarEliminar = true;
            this.eliminarCoronaEscareador = coronasEscareadores;
        },
        confirmadoEliminarCoronaEscareador(data) {
            this.habilitarEliminar = data.cerrarEliminar;
            this.coronasEscareadores = this.coronasEscareadores.filter(elemento => elemento.id !== data.id);

            if (this.ListaCoronasEscareadores.length === 0 && this.paginaActual > 1) {
                this.paginaActual--;
            }
        },
        cancelarEliminarCoronaEscareador(data) {
            this.habilitarEliminar = data;
        },
        cancelarEditarCoronaEscareador(data) {
            this.habilitarEditar = data;
        },
        open() {
            this.resetForm();
            const modalElement = document.getElementById('coronasEscareadoresModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('coronasEscareadoresModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },
        validarInicioTermino() {
            const desde = parseInt(this.newCoronasEscareadores.desde);
            const hasta = parseInt(this.newCoronasEscareadores.hasta);

            this.errors_coronasEscareadores = {
                desde: false,
                hasta: false
            }

            if (isNaN(desde) || isNaN(hasta)) {
                this.errors_coronasEscareadores = {
                    desde: true,
                    hasta: true
                }
            }

            if (hasta > 0 && desde >= hasta) {
                this.errors_coronasEscareadores = {
                    hasta: true
                }
            }
        },
        resetForm() {
            this.newCoronasEscareadores.detalle = null;
            this.newCoronasEscareadores.desde = 0;
            this.newCoronasEscareadores.hasta = 0;
            this.newCoronasEscareadores.diametro = 0;
            this.newCoronasEscareadores.numero_corona = 0;
            this.errors_coronasEscareadores = null;
            this.habilitarEliminar = false;
            this.habilitarEditar = false;
            this.eliminarCoronaEscareador = {};
        },
        actualizarCoronaEscareador(corona_escareador) {
            if (corona_escareador) {
                this.coronasEscareadores.forEach(coronaEscareador => {
                    if (coronaEscareador.id === corona_escareador.id) {
                        coronaEscareador.detalle = corona_escareador.detalle;
                        coronaEscareador.desde = corona_escareador.desde;
                        coronaEscareador.hasta = corona_escareador.hasta;
                        coronaEscareador.diametro = corona_escareador.diametro;
                        coronaEscareador.numero_corona = corona_escareador.numero_corona;
                    }
                    this.resetForm();
                });
            }
        },
        async crearCoronasEscareadores() {
            const response = await this.createCoronasEscareadores(this.newCoronasEscareadores);

            if (this.errors_coronasEscareadores === null) {
                this.$notyf.success(response.message);
                this.coronasEscareadores.push(response.corona_escareador);
                this.resetForm();
            }
        },
    }
}
</script>

<style scoped></style>
