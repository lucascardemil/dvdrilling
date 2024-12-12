<template>
    <div class="modal fade" id="verCheckListCompletadoModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="verCheckListCompletadoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verCheckListCompletadoModalLabel">Completar CheckList</h5>
                    <button type="button" class="btn-close" @click="close()"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-5 col-md-12 mb-md-5 form-checklist overflow-auto">
                            <template v-if="verCheckListProps">
                                <div class="card bg-white">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <h5>Proyecto</h5>
                                            <div class="row align-items-center mb-2">
                                                <p class="col-6 col-form-label">Tipo Equipo</p>
                                                <div class="col-6">
                                                    <p class="mb-0">{{ verCheckListProps.tipoactivo.name }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-2">
                                                <p class="col-6 col-form-label">Numero Interno</p>
                                                <div class="col-6">
                                                    <p class="mb-0"
                                                        v-if="verCheckListProps.vehiculos.detalles.numero_interno">{{
                                                            verCheckListProps.vehiculos.detalles.numero_interno }}</p>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-2">
                                                <p class="col-6 col-form-label">Proyecto</p>
                                                <div class="col-6">
                                                    <p class="mb-0"
                                                        v-if="verCheckListProps.vehiculos.detalles.proyecto">{{
                                                            verCheckListProps.vehiculos.detalles.proyecto }}</p>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-2">
                                                <p class="col-6 col-form-label">Faena</p>
                                                <div class="col-6">
                                                    <p class="mb-0" v-if="verCheckListProps.vehiculos.detalles.faena">{{
                                                        verCheckListProps.vehiculos.detalles.faena }}</p>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-2">
                                                <p class="col-6 col-form-label">Turno</p>
                                                <div class="col-6">
                                                    <p class="mb-0" v-if="verCheckListProps.vehiculos.detalles.turno">{{
                                                        verCheckListProps.vehiculos.detalles.turno }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <h5>Vehiculo</h5>
                                            <div class="row align-items-center mb-2">
                                                <p class="col-6 col-form-label">Marca</p>
                                                <div class="col-6">
                                                    <p class="mb-0">{{ verCheckListProps.marca }}</p>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-2">
                                                <p class="col-6 col-form-label">Modelo</p>
                                                <div class="col-6">
                                                    <p class="mb-0">{{ verCheckListProps.modelo }}</p>
                                                </div>
                                            </div>
                                            <div class="row align-items-start mb-2">
                                                <p class="col-6 col-form-label">Patente</p>
                                                <div class="col-6">
                                                    <p class="mb-0" v-if="verCheckListProps.vehiculos.patente">{{
                                                        verCheckListProps.vehiculos.patente }}</p>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-2">
                                                <p class="col-6 col-form-label">Conductor/Operador</p>
                                                <div class="col-6">
                                                    <p class="mb-0"
                                                        v-if="verCheckListProps.vehiculos.detalles.conductor">{{
                                                            verCheckListProps.vehiculos.detalles.conductor }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <h5>Kilometraje y Horometro</h5>
                                            <div class="row align-items-center mb-2">
                                                <p class="col-6 col-form-label">Kilometraje</p>
                                            </div>
                                            <div class="row align-items-center mb-2">
                                                <p class="col-6 col-form-label">Inicial</p>
                                                <div class="col-6">
                                                    <p class="mb-0">
                                                        {{ verCheckListProps.vehiculos.detalles.kilometraje_inicial }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-2">
                                                <p class="col-6 col-form-label">Final</p>
                                                <div class="col-6">
                                                    <p class="mb-0">
                                                        {{ verCheckListProps.vehiculos.detalles.kilometraje_final }}</p>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-2">
                                                <p class="col-6 col-form-label">Horometro</p>
                                            </div>
                                            <div class="row align-items-center mb-2">
                                                <p class="col-6 col-form-label">Inicial</p>
                                                <div class="col-6">
                                                    <p class="mb-0">
                                                        {{ verCheckListProps.vehiculos.detalles.horometro_inicial }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-2">
                                                <p class="col-6 col-form-label">Final</p>
                                                <div class="col-6">
                                                    <p class="mb-0">
                                                        {{ verCheckListProps.vehiculos.detalles.horometro_final }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <h5>Estado Equipo</h5>
                                            <div class="row">
                                                <p class="fw-bold mb-0">Status Equipo</p>
                                                <div v-if="verCheckListProps.vehiculos.detalles.estado_equipo === 1"
                                                    class="row align-items-center mb-2">
                                                    <p class="col-6 col-form-label">Operativo</p>
                                                    <div class="col-6">
                                                        <p class="mb-0"><i class="bi bi-check-lg fs-4"></i>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div v-else-if="verCheckListProps.vehiculos.detalles.estado_equipo === 0"
                                                    class="row align-items-center mb-2">
                                                    <p class="col-6 col-form-label">Fuera De Servicio</p>
                                                    <div class="col-6">
                                                        <p class="mb-0"><i class="bi bi-check-lg fs-4"></i>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div v-else>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <p class="fw-bold mb-0">Carga De Combustible</p>
                                                <div v-if="verCheckListProps.vehiculos.detalles.carga_combustible === 1"
                                                    class="row align-items-center mb-2">
                                                    <p class="col-6 col-form-label">SI</p>
                                                    <div class="col-6">
                                                        <p class="mb-0"><i class="bi bi-check-lg fs-4"></i>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div v-else-if="verCheckListProps.vehiculos.detalles.carga_combustible === 0"
                                                    class="row align-items-center mb-2">
                                                    <p class="col-6 col-form-label">NO</p>
                                                    <div class="col-6">
                                                        <p class="mb-0"><i class="bi bi-check-lg fs-4"></i>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <div class="row align-items-center mb-2">
                                                        <p class="col-6 col-form-label">LTS</p>
                                                        <div class="col-6">
                                                            <p class="mb-0">{{
                                                                verCheckListProps.vehiculos.detalles.litros }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <p class="fw-bold mb-0">INDIQUE NIVEL DE COMBUSTIBLE AL INICIAR EL TURNO
                                                </p>
                                                <div v-if="verCheckListProps.vehiculos.detalles.imagen_combustible"
                                                    class="w-50">
                                                    <img :src="formatImage(verCheckListProps.vehiculos.detalles.imagen_combustible)"
                                                        class="card-img-top"
                                                        :alt="verCheckListProps.vehiculos.detalles.imagen_combustible">
                                                </div>
                                                <div v-else>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <h5>Observacion (Bitacora)</h5>
                                            <div class="col-12">
                                                <p class="mb-0"
                                                    v-if="verCheckListProps.vehiculos.detalles.observacion_bitacora">
                                                    {{ verCheckListProps.vehiculos.detalles.observacion_bitacora }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div class="col-lg-7 col-md-12">
                            <div v-if="mostrarObservacionesImagenes" class="my-4">
                                <div class="row row-cols-1 row-cols-md-2 g-4">
                                    <template v-for="condicion in checklist_condiciones">
                                        <template v-for="imagen in condicion.imagenes">
                                            <div class="col">
                                                <div class="card h-100">
                                                    <template v-if="imagen.imagen">
                                                        <img :src="formatImage(imagen.imagen)" class="card-img-top"
                                                            :alt="imagen.observacion">
                                                    </template>

                                                    <div class="sin-imagen" v-if="!imagen.imagen">
                                                        <i class="bi bi-image"></i>
                                                    </div>
                                                    <div class="card-body">
                                                        <h5 class="card-title">Observacion</h5>
                                                        <p class="card-text">{{ imagen.observacion }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </template>
                                </div>
                                <div class="my-3">
                                    <button type="button" class="btn btn-base-dv"
                                        @click="volverCheckListObservacion()"><i class="bi bi-arrow-left"></i>
                                        Volver</button>
                                </div>
                            </div>
                            <div v-else class="table-responsive">
                                <table class="table table-bordered text-center align-middle">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Categoria</th>
                                            <th colspan="2">Aplica</th>
                                            <th colspan="3">Estado</th>
                                            <th rowspan="2">Observacion</th>
                                        </tr>
                                        <tr>
                                            <th>SI</th>
                                            <th>NO</th>
                                            <th><i class="bi bi-emoji-laughing fs-4 text-success"></i></th>
                                            <th><i class="bi bi-emoji-neutral fs-4 text-warning"></i></th>
                                            <th><i class="bi bi-emoji-frown fs-4 text-danger"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template v-if="verCheckListProps">
                                            <template v-for="categoria in verCheckListProps.categorias">
                                                <template v-if="categoria.intervenciones">
                                                    <template v-for="intervencion in categoria.intervenciones">
                                                        <template v-if="intervencion.condiciones.length > 0">
                                                            <tr class="table-active">
                                                                <th colspan="7">{{ categoria.nombre }}</th>
                                                            </tr>

                                                            <tr>
                                                                <td>{{ intervencion.nombre }}</td>
                                                                <template v-for="condicion in intervencion.condiciones">
                                                                    <td v-if="condicion.existe === 1">
                                                                        <i class="bi bi-check-lg fs-4"></i>
                                                                    </td>
                                                                    <td v-else></td>
                                                                    <td v-if="condicion.existe === 2">
                                                                        <i class="bi bi-check-lg fs-4"></i>
                                                                    </td>
                                                                    <td v-else></td>
                                                                    <td v-if="condicion.estado === 1">
                                                                        <i class="bi bi-check-lg fs-4"></i>
                                                                    </td>
                                                                    <td v-else></td>
                                                                    <td v-if="condicion.estado === 2">
                                                                        <i class="bi bi-check-lg fs-4"></i>
                                                                    </td>
                                                                    <td v-else></td>
                                                                    <td v-if="condicion.estado === 3">
                                                                        <i class="bi bi-check-lg fs-4"></i>
                                                                    </td>
                                                                    <td v-else></td>
                                                                    <td>
                                                                        <button type="button"
                                                                            class="btn btn-base-dv w-100"
                                                                            @click="verObservacionesImagenes(intervencion.condiciones)"><i
                                                                                class="bi bi-image-fill"></i></button>
                                                                    </td>
                                                                </template>
                                                            </tr>
                                                        </template>
                                                    </template>
                                                </template>
                                            </template>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import checklistMixin from '../../mixins/checklist/checklistMixin';
import { formatImage } from '../../utils/formatImage';

export default {
    mixins: [checklistMixin],
    props: {
        verCheckListProps: Object,
    },
    data() {
        return {
            mostrarObservacionesImagenes: false,
            checklist_condiciones: [],
            verImagenesObservaciones: false,
        };
    },
    methods: {
        open() {
            const modalElement = document.getElementById('verCheckListCompletadoModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('verCheckListCompletadoModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },
        verObservacionesImagenes(condiciones) {
            this.mostrarObservacionesImagenes = true;
            this.checklist_condiciones = condiciones
        },
        volverCheckListObservacion() {
            this.mostrarObservacionesImagenes = false;
        },
        formatImage
    }
}
</script>

<style scoped>
.list-group-item-base-dv {
    border-left-color: #fd7e14;
}

.border-checklist {
    border-left-color: #fd7e14;
}

.border-card {
    border-left-width: .25rem;
    border-radius: .25rem;
}

.checkbox-checklist {
    float: none;
    width: 1.4em;
    height: 1.4em;
}

.switch-checklist {
    width: 3.1em;
    height: 1.5em;
}

.form-checklist {
    max-height: 750px;
}
</style>