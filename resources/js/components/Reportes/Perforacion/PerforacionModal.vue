<template>
    <div class="modal fade" id="perforacionesModal" tabindex="-1" aria-labelledby="perforacionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="perforacionModalLabel">Perforacion En Roca</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row" v-if="habilitarEditar">
                        <div class="col-12">
                            <EditarPerforacion :data="editPerforaciones" @actualizar-perforacion="actualizarPerforacion"
                                @cancelar-editar="cancelarEditarPerforacion">
                            </EditarPerforacion>
                        </div>
                    </div>
                    <div class="row" v-else>
                        <div class="col-4">
                            <div class="card shadow mb-3">
                                <div class="card-body">
                                    <form @submit.prevent="crearPerforaciones">
                                        <div class="mb-3">
                                            <label for="perforacionesDesde" class="form-label">Desde</label>
                                            <input type="number" min="0" step="0.01" class="form-control"
                                                id="perforacionesDesde" v-model="newPerforaciones.desde"
                                                @input="calculoPerforado" :disabled="existeDesde"
                                                :class="errors_perforaciones ? errors_perforaciones.desde ? 'is-invalid' : '' : ''"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="perforacionesHasta" class="form-label">Hasta</label>
                                            <input type="number" min="0" step="0.01" class="form-control"
                                                id="perforacionesHasta" v-model="newPerforaciones.hasta"
                                                @input="calculoPerforado"
                                                :class="errors_perforaciones ? errors_perforaciones.hasta ? 'is-invalid' : '' : ''"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="perforacionesPerforado" class="form-label">Perforado</label>
                                            <input type="number" min="0" step="0.01" class="form-control"
                                                id="perforacionesPerforado" v-model="newPerforaciones.perforado"
                                                @input="calculoRecuperado"
                                                :class="errors_perforaciones ? errors_perforaciones.perforado ? 'is-invalid' : '' : ''"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="perforacionesRecuperado" class="form-label">Recuperado</label>
                                            <input type="number" min="0" step="0.01" class="form-control"
                                                id="perforacionesRecuperado" v-model="newPerforaciones.recuperado"
                                                @input="calculoRecuperado"
                                                :class="errors_perforaciones ? errors_perforaciones.recuperado ? 'is-invalid' : '' : ''"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="perforacionesPorcentaje" class="form-label">Porcentaje</label>
                                            <input type="number" min="0" step="0.01" class="form-control"
                                                id="perforacionesPorcentaje" v-model="newPerforaciones.porcentaje"
                                                :class="errors_perforaciones ? errors_perforaciones.porcentaje ? 'is-invalid' : '' : ''"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="perforacionesNumeroCajas" class="form-label">N°
                                                Cajas</label>
                                            <input type="number" min="0" step="0.01" class="form-control"
                                                id="perforacionesNumeroCajas" v-model="newPerforaciones.numero_cajas"
                                                :class="errors_perforaciones ? errors_perforaciones.numero_cajas ? 'is-invalid' : '' : ''"
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
                                            <th scope="col">Desde</th>
                                            <th scope="col">Hasta</th>
                                            <th scope="col">Perforado</th>
                                            <th scope="col">Recuperado</th>
                                            <th scope="col">Porcentaje</th>
                                            <th scope="col">N° Cajas</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="perforacion in ListaPerforaciones" :key="perforacion.id">
                                            <td>{{ perforacion.desde }}</td>
                                            <td>{{ perforacion.hasta }}</td>
                                            <td>{{ perforacion.perforado }}</td>
                                            <td>{{ perforacion.recuperado }}</td>
                                            <td>{{ perforacion.porcentaje }}%</td>
                                            <td>{{ perforacion.numero_cajas }}</td>
                                            <td class="text-end">
                                                <button type="button" class="btn btn-primary"
                                                    @click="openEditarPerforacion(perforacion)"><i
                                                        class="bi bi-pencil-square"></i></button>
                                                <button type="button" class="btn btn-danger"
                                                    @click="openElimninarPerforacion(perforacion)"><i
                                                        class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <PaginacionComponent :paginaActual="paginaActual" :totalPaginas="totalPaginas"
                                    @cambiar-pagina="cambiarPagina" @cambiar-pagina-actual="cambiarPaginaActual" />
                            </div>
                            <EliminarPerforacion :data="eliminarPerforacion"
                                @confirmado-eliminar="confirmadoEliminarPerforacion"
                                @cancelar-eliminar="cancelarEliminarPerforacion" v-else></EliminarPerforacion>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import perforacionesMixin from '../../../mixins/reporte/perforacionesMixin';
import PaginacionComponent from '../../base/PaginacionComponent.vue';
import EditarPerforacion from './EditarPerforacion.vue';
import EliminarPerforacion from './EliminarPerforacion.vue';

export default {
    mixins: [perforacionesMixin],
    components: {
        PaginacionComponent,
        EditarPerforacion,
        EliminarPerforacion
    },
    props: {
        reporte: Object,
    },
    data() {
        return {
            newPerforaciones: {
                reporte_id: 0,
                desde: 0,
                hasta: 0,
                perforado: 0,
                recuperado: 0,
                porcentaje: 0,
                numero_cajas: 0
            },
            editPerforaciones: {},
            existeDesde: false,
            eliminarPerforacion: {},
            habilitarEliminar: false,
            paginaActual: 1,
            filasPorPagina: 10,
            habilitarEditar: false
        };
    },
    computed: {
        totalPaginas() {
            return Math.ceil(this.perforaciones.length / this.filasPorPagina);
        },
        ListaPerforaciones() {
            const start = (this.paginaActual - 1) * this.filasPorPagina;
            const end = start + this.filasPorPagina;
            return this.perforaciones.slice(start, end);
        }
    },
    watch: {
        reporte: {
            immediate: true,
            handler(Reporte) {
                if (Reporte) {
                    this.perforaciones = Reporte.perforacion;
                    this.newPerforaciones.reporte_id = Reporte.id;

                    let ultimoPerforacion = this.perforaciones[this.perforaciones.length - 1];
                    if (ultimoPerforacion) {
                        this.existeDesde = true;
                        this.newPerforaciones.desde = ultimoPerforacion.hasta;
                    }

                }
            }
        },
        'newPerforaciones.desde': 'validarInicioTermino',
        'newPerforaciones.hasta': 'validarInicioTermino'
    },
    methods: {
        cambiarPaginaActual(newPage) {
            this.paginaActual = newPage;
        },
        cambiarPagina(newPage) {
            this.paginaActual = newPage;
        },
        openEditarPerforacion(perforacion) {
            this.habilitarEditar = true;
            this.editPerforaciones = {
                id: perforacion.id,
                reporte_id: perforacion.reporte_id,
                desde: perforacion.desde,
                hasta: perforacion.hasta,
                perforado: perforacion.perforado,
                recuperado: perforacion.recuperado,
                porcentaje: perforacion.porcentaje,
                numero_cajas: perforacion.numero_cajas
            }
        },
        openElimninarPerforacion(perforacion) {
            this.habilitarEliminar = true;
            this.eliminarPerforacion = perforacion;
        },
        confirmadoEliminarPerforacion(data) {
            this.habilitarEliminar = data.cerrarEliminar;
            this.perforaciones = this.perforaciones.filter(elemento => elemento.id !== data.id);

            if (this.ListaPerforaciones.length === 0 && this.paginaActual > 1) {
                this.paginaActual--;
            }

            if(this.perforaciones.length === 0){
                this.newPerforaciones.desde = 0;
                this.existeDesde = false;
                this.errors_perforaciones = null;
            }
        },
        cancelarEliminarPerforacion(data) {
            this.habilitarEliminar = data;
        },
        cancelarEditarPerforacion(data) {
            this.habilitarEditar = data;
        },
        open() {
            this.resetForm();
            const modalElement = document.getElementById('perforacionesModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('perforacionesModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },
        calculoRecuperado() {
            if (this.newPerforaciones.perforado > 0) {
                this.newPerforaciones.porcentaje = Math.round((this.newPerforaciones.recuperado / this.newPerforaciones.perforado) * 100);
            } else {
                this.newPerforaciones.porcentaje = 0;
            }
        },
        calculoPerforado() {
            const perforado = (this.newPerforaciones.hasta - this.newPerforaciones.desde) * 100;
            this.newPerforaciones.perforado = Number.isInteger(perforado)
                ? perforado
                : perforado.toFixed(2).replace(/\.?0+$/, '');
        },
        validarInicioTermino() {
            const desde = parseInt(this.newPerforaciones.desde);
            const hasta = parseInt(this.newPerforaciones.hasta);

            this.errors_perforaciones = {
                desde: false,
                hasta: false,
                perforado: false
            }

            if (isNaN(desde) || isNaN(hasta)) {
                this.errors_perforaciones = {
                    desde: true,
                    hasta: true,
                    perforado: true
                }
            }

            if ((desde > 0 && hasta > 0) && desde >= hasta) {
                this.errors_perforaciones = {
                    hasta: true,
                    perforado: true
                }
            }
        },
        resetForm() {
            this.existeDesde = false;
            this.newPerforaciones.desde = 0;
            this.newPerforaciones.hasta = 0;
            this.newPerforaciones.perforado = 0;
            this.newPerforaciones.recuperado = 0;
            this.newPerforaciones.porcentaje = 0;
            this.newPerforaciones.numero_cajas = 0;
            this.errors_perforaciones = null;
            this.habilitarEliminar = false;
            this.habilitarEditar = false;
            this.eliminarPerforacion = {};
        },
        actualizarPerforacion(perforaciones) {
            if (perforaciones) {
                this.perforaciones.forEach(perforacion => {
                    if (perforacion.id === perforaciones.id) {
                        perforacion.desde = perforaciones.desde;
                        perforacion.hasta = perforaciones.hasta;
                        perforacion.perforado = perforaciones.perforado;
                        perforacion.recuperado = perforaciones.recuperado;
                        perforacion.porcentaje = perforaciones.porcentaje;
                        perforacion.numero_cajas = perforaciones.numero_cajas;
                    }
                    this.resetForm();
                });
            }
        },
        async crearPerforaciones() {
            const response = await this.createPerforaciones(this.newPerforaciones);

            if (this.errors_perforaciones === null) {
                this.$notyf.success(response.message);
                this.perforaciones.push(response.perforacion);
                this.resetForm();
                this.newPerforaciones.desde = response.perforacion.hasta;
                this.existeDesde = true;
            }
        },
    }
}
</script>

<style scoped></style>
