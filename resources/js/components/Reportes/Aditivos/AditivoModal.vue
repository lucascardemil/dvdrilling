<template>
    <div class="modal fade" id="aditivoModal" tabindex="-1" aria-labelledby="aditivoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="aditivoModalLabel">Control De Aditivos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row" v-if="habilitarEditar">
                        <div class="col-12">
                            <EditarAditivo :data="editAditivos" @actualizar-aditivo="actualizarAditivo"
                                @cancelar-editar="cancelarEditarAditivo">
                            </EditarAditivo>
                        </div>
                    </div>
                    <div class="row" v-else>
                        <div class="col-4">
                            <div class="card shadow mb-3">
                                <div class="card-body">
                                    <form @submit.prevent="crearAditivos">
                                        <div class="mb-3">
                                            <label for="aditivoCantidad" class="form-label">Cantidad</label>
                                            <input type="number" min="0" class="form-control" id="aditivoCantidad"
                                                v-model="newAditivo.cantidad"
                                                :class="errors_aditivos ? errors_aditivos.cantidad ? 'is-invalid' : '' : ''"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="aditivoDetalla" class="form-label">Detalle</label>
                                            <textarea class="form-control" id="aditivoDetalla"
                                                v-model="newAditivo.detalle"
                                                :class="errors_aditivos ? errors_aditivos.detalle ? 'is-invalid' : '' : ''"
                                                required></textarea>
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
                                            <th scope="col">Cantidad</th>
                                            <th scope="col">Detalle</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="aditivo in ListaAditivos" :key="aditivo.id">
                                            <th scope="row">{{ aditivo.id }}</th>
                                            <td>{{ aditivo.cantidad }}</td>
                                            <td>{{ aditivo.detalle }}</td>
                                            <td class="text-end">
                                                <button type="button" class="btn btn-primary"
                                                    @click="openEditarAditivo(aditivo)"><i
                                                        class="bi bi-pencil-square"></i></button>
                                                <button type="button" class="btn btn-danger"
                                                    @click="openElimninarCoronaEscareador(aditivo)"><i
                                                        class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <PaginacionComponent :paginaActual="paginaActual" :totalPaginas="totalPaginas"
            @cambiar-pagina="cambiarPagina" @cambiar-pagina-actual="cambiarPaginaActual"/>
                            </div>
                            <EliminarAditivo :data="eliminarAditivo" @confirmado-eliminar="confirmadoEliminarAditivo"
                                @cancelar-eliminar="cancelarEliminarAditivo" v-else></EliminarAditivo>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import aditivoMixin from '../../../mixins/reporte/aditivoMixin';
import PaginacionComponent from '../../base/PaginacionComponent.vue';
import EditarAditivo from './EditarAditivo.vue';
import EliminarAditivo from './EliminarAditivo.vue';

export default {
    mixins: [aditivoMixin],
    components: {
        PaginacionComponent,
        EditarAditivo,
        EliminarAditivo
    },
    props: {
        reporte: Object,
    },
    data() {
        return {
            newAditivo: {
                reporte_id: 0,
                detalle: '',
                cantidad: 0
            },
            editAditivos: {},
            existeInicio: false,
            eliminarAditivo: {},
            habilitarEliminar: false,
            paginaActual: 1,
            filasPorPagina: 7,
            habilitarEditar: false
        };
    },
    computed: {
        totalPaginas() {
            return Math.ceil(this.aditivos.length / this.filasPorPagina);
        },
        ListaAditivos() {
            const start = (this.paginaActual - 1) * this.filasPorPagina;
            const end = start + this.filasPorPagina;
            return this.aditivos.slice(start, end);
        }
    },
    watch: {
        reporte: {
            immediate: true,
            handler(Reporte) {
                if (Reporte) {
                    this.aditivos = Reporte.aditivo;
                    this.newAditivo.reporte_id = Reporte.id;
                }
            }
        },
    },
    methods: {
        cambiarPaginaActual(newPage){
            this.paginaActual = newPage;
        },
        cambiarPagina(newPage) {
            this.paginaActual = newPage;
        },
        openEditarAditivo(aditivo) {
            this.habilitarEditar = true;
            this.editAditivos = {
                id: aditivo.id,
                reporte_id: aditivo.reporte_id,
                detalle: aditivo.detalle,
                cantidad: aditivo.cantidad
            }
        },
        openElimninarCoronaEscareador(aditivo) {
            this.habilitarEliminar = true;
            this.eliminarAditivo = aditivo;
        },
        confirmadoEliminarAditivo(data) {
            this.habilitarEliminar = data.cerrarEliminar;
            this.aditivos = this.aditivos.filter(elemento => elemento.id !== data.id);

            if (this.ListaAditivos.length === 0 && this.paginaActual > 1) {
                this.paginaActual--;
            }
        },
        cancelarEliminarAditivo(data) {
            this.habilitarEliminar = data;
        },
        cancelarEditarAditivo(data) {
            this.habilitarEditar = data;
        },
        open() {
            this.resetForm();
            const modalElement = document.getElementById('aditivoModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('aditivoModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },
        resetForm() {
            this.newAditivo.detalle = '';
            this.newAditivo.cantidad = 0;
            this.errors_aditivos = null;
            this.habilitarEliminar = false;
            this.habilitarEditar = false;
            this.eliminarAditivo = {};
        },
        actualizarAditivo(aditivos) {
            if (aditivos) {
                this.aditivos.forEach(aditivo => {
                    if (aditivo.id === aditivos.id) {
                        aditivo.detalle = aditivos.detalle;
                        aditivo.cantidad = aditivos.cantidad;
                    }
                    this.resetForm();
                });
            }
        },
        async crearAditivos() {
            const response = await this.createAditivos(this.newAditivo);

            if (this.errors_aditivos === null) {
                this.$notyf.success(response.message);
                this.aditivos.push(response.aditivo);
                this.resetForm();
            }
        },
    }
}
</script>

<style scoped></style>
