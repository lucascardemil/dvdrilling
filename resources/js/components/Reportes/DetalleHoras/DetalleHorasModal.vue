<template>
    <div class="modal fade" id="detalleHorasModal" tabindex="-1" aria-labelledby="detalleHorasModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detalleHorasModalLabel">Detalle Horas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row" v-if="habilitarEditar">
                        <div class="col-12">
                            <EditarDetalleHora :data="editDetalleHoras"
                                @actualizar-detalleHora="actualizarDetalleHora"
                                @cancelar-editar="cancelarEditarDetalleHora"
                                :actividades="actividades">
                            </EditarDetalleHora>
                        </div>
                    </div>
                    <div class="row" v-else>
                        <div class="col-4">
                            <div class="card shadow mb-3">
                                <div class="card-body">
                                    <form @submit.prevent="crearDetalleHoras">
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label for="detalleHorasDe" class="form-label">De</label>
                                                <input type="time" class="form-control" id="detalleHorasDe"
                                                    v-model="newDetalleHoras.de" :disabled="existeDe"
                                                    :class="errors_detalleHoras ? errors_detalleHoras.de ? 'is-invalid' : '' : ''"
                                                    pattern="[0-9]{2}:[0-9]{2}" placeholder="HH:mm" required>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label for="detalleHorasA" class="form-label">A</label>
                                                <input type="time" class="form-control" id="detalleHorasA"
                                                    v-model="newDetalleHoras.a" :min="newDetalleHoras.de"
                                                    :class="errors_detalleHoras ? errors_detalleHoras.a ? 'is-invalid' : '' : ''"
                                                    pattern="[0-9]{2}:[0-9]{2}" placeholder="HH:mm" required>
                                            </div>

                                        </div>
                                        <div class="mb-3">
                                            <label for="detalleHorasActividad" class="form-label">Actividad</label>
                                            <select class="form-select" aria-label="Seleccione la actividad"
                                                id="detalleHorasActividad" v-model="newDetalleHoras.actividad_id"
                                                :class="errors_detalleHoras ? errors_detalleHoras.actividad_id ? 'is-invalid' : '' : ''"
                                                required>
                                                <option :value="null" disabled>Seleccione la actividad</option>
                                                <template v-for="actividad in actividades">
                                                    <option :value="actividad.id">{{ actividad.name }}</option>
                                                </template>
                                            </select>
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
                                            <th scope="col">De</th>
                                            <th scope="col">A</th>
                                            <th scope="col">Actividad</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="detalleHora in ListaDetalleHoras" :key="detalleHora.id">
                                            <th scope="row">{{ detalleHora.id }}</th>
                                            <td>{{ detalleHora.de.slice(0, 5) }}</td>
                                            <td>{{ detalleHora.a.slice(0, 5) }}</td>
                                            <td>{{ detalleHora.actividad.name }}</td>
                                            <td class="text-end">
                                                <button type="button" class="btn btn-primary"
                                                    @click="openEditarDetalleHora(detalleHora)"><i
                                                        class="bi bi-pencil-square"></i></button>
                                                <button type="button" class="btn btn-danger"
                                                    @click="openElimninarDetalleHora(detalleHora)"><i
                                                        class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <PaginacionComponent :paginaActual="paginaActual" :totalPaginas="totalPaginas"
                                    @cambiar-pagina="cambiarPagina" />
                            </div>
                            <EliminarDetalleHora :data="eliminarDetalleHora"
                                @confirmado-eliminar="confirmadoEliminarDetalleHora"
                                @cancelar-eliminar="cancelarEliminarDetalleHora" v-else></EliminarDetalleHora>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import detalleHorasMixin from '../../../mixins/reporte/detalleHorasMixin';
import PaginacionComponent from '../../base/PaginacionComponent.vue';
import EditarDetalleHora from './EditarDetalleHora.vue';
import EliminarDetalleHora from './EliminarDetalleHora.vue';

export default {
    mixins: [detalleHorasMixin],
    components: {
        PaginacionComponent,
        EditarDetalleHora,
        EliminarDetalleHora
    },
    props: {
        reporte: Object,
        actividades: Array
    },
    data() {
        return {
            newDetalleHoras: {
                reporte_id: 0,
                de: "",
                a: "",
                actividad_id: 0
            },
            editDetalleHoras: {},
            existeDe: false,
            eliminarDetalleHora: {},
            habilitarEliminar: false,
            paginaActual: 1,
            filasPorPagina: 7,
            habilitarEditar: false
        };
    },
    computed: {
        totalPaginas() {
            return Math.ceil(this.detalleHoras.length / this.filasPorPagina);
        },
        ListaDetalleHoras() {
            const start = (this.paginaActual - 1) * this.filasPorPagina;
            const end = start + this.filasPorPagina;
            return this.detalleHoras.slice(start, end);
        }
    },
    watch: {
        reporte: {
            immediate: true,
            handler(Reporte) {
                if (Reporte) {
                    this.detalleHoras = Reporte.detalle_hora;
                    this.newDetalleHoras.reporte_id = Reporte.id;

                    let ultimoDetalleHora = this.detalleHoras[this.detalleHoras.length - 1];
                    if (ultimoDetalleHora) {
                        this.existeDe = true;
                        this.newDetalleHoras.de = ultimoDetalleHora.a;
                    }

                }
            }
        },
        'newDetalleHoras.a': function(nuevaHoraA) {
            if (nuevaHoraA && this.newDetalleHoras.de && nuevaHoraA < this.newDetalleHoras.de) {
                this.newDetalleHoras.a = this.newDetalleHoras.de;
            }
        },
        'newDetalleHoras.de': function(nuevaHoraDe) {
            if (this.newDetalleHoras.a && nuevaHoraDe && this.newDetalleHoras.a < nuevaHoraDe) {
                this.newDetalleHoras.a = nuevaHoraDe;
            }
        }
    },
    methods: {
        cambiarPagina(newPage) {
            this.paginaActual = newPage;
        },
        openEditarDetalleHora(detalleHora) {
            this.habilitarEditar = true;
            this.editDetalleHoras = {
                id: detalleHora.id,
                reporte_id: detalleHora.reporte_id,
                de: detalleHora.de,
                a: detalleHora.a,
                actividad_id: detalleHora.actividad_id,
            }
        },
        openElimninarDetalleHora(detalleHora) {
            this.habilitarEliminar = true;
            this.eliminarDetalleHora = detalleHora;
        },
        confirmadoEliminarDetalleHora(data) {
            this.habilitarEliminar = data.cerrarEliminar;
            this.detalleHoras = this.detalleHoras.filter(elemento => elemento.id !== data.id);

            if (this.ListaDetalleHoras.length === 0 && this.paginaActual > 1) {
                this.paginaActual--;
            }
        },
        cancelarEliminarDetalleHora(data) {
            this.habilitarEliminar = data;
        },
        cancelarEditarDetalleHora(data) {
            this.habilitarEditar = data;
        },
        open() {
            this.resetForm();
            const modalElement = document.getElementById('detalleHorasModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('detalleHorasModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },
        resetForm() {
            this.existeDe = false;
            this.newDetalleHoras.de = "";
            this.newDetalleHoras.a = "";
            this.newDetalleHoras.actividad_id = null;
            this.errors_detalleHoras = null;
            this.habilitarEliminar = false;
            this.habilitarEditar = false;
            this.eliminarDetalleHora = {};
        },
        actualizarDetalleHora(detalleHoras) {
            if (detalleHoras) {
                this.detalleHoras.forEach(detalleHora => {
                    if (detalleHora.id === detalleHoras.id) {
                        detalleHora.de = detalleHoras.de;
                        detalleHora.a = detalleHoras.a;
                        detalleHora.actividad_id = detalleHoras.actividad_id;
                    }
                    this.resetForm();
                });
            }
        },
        async crearDetalleHoras() {
            const response = await this.createDetalleHoras(this.newDetalleHoras);

            if (this.errors_detalleHoras === null) {
                this.$notyf.success(response.message);
                this.detalleHoras.push(response.detalleHora);
                this.newDetalleHoras.de = response.detalleHora.a;
                this.resetForm();
            }
        },
    }
}
</script>

<style scoped></style>
