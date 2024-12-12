<template>
    <div class="modal fade" id="completarCheckListModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="completarCheckListModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="matrizCheckListModalLabel">Completar CheckList</h5>
                    <button type="button" class="btn-close" @click="close()"></button>
                </div>
                <div class="modal-body">
                    <template v-if="completarCheckListProps && completarCheckListProps.matriz">
                        <div class="row">
                            <div class="col-lg-5 col-md-12 mb-md-5 form-checklist overflow-auto">
                                <div class="card bg-white">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <h5>Proyecto</h5>
                                            <div class="row align-items-center mb-2">
                                                <p class="col-6 col-form-label">Tipo Equipo</p>
                                                <div class="col-6">
                                                    <p class="mb-0">{{ completarCheckListProps.tipoactivo.name }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-2">
                                                <p class="col-6 col-form-label">Numero Interno</p>
                                                <div class="col-6">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="completarCheckListNumeroInterno" v-model="numero_interno"
                                                        :class="errors_finalizar_checklist ? errors_finalizar_checklist.errors?.numero_interno ? 'is-invalid' : '' : ''"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-2">
                                                <p class="col-6 col-form-label">Proyecto</p>
                                                <div class="col-6">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="completarCheckListProyecto" v-model="proyecto"
                                                        :class="errors_finalizar_checklist ? errors_finalizar_checklist.errors?.proyecto ? 'is-invalid' : '' : ''"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-2">
                                                <p class="col-6 col-form-label">Faena</p>
                                                <div class="col-6">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="completarCheckListFaena" v-model="faena"
                                                        :class="errors_finalizar_checklist ? errors_finalizar_checklist.errors?.faena ? 'is-invalid' : '' : ''"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-2">
                                                <p class="col-6 col-form-label">Turno</p>
                                                <div class="col-6">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="completarCheckListTurno" v-model="turno"
                                                        :class="errors_finalizar_checklist ? errors_finalizar_checklist.errors?.turno ? 'is-invalid' : '' : ''"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <h5>Vehiculo</h5>
                                            <div class="row align-items-center mb-2">
                                                <p class="col-6 col-form-label">Marca</p>
                                                <div class="col-6">
                                                    <p class="mb-0">{{ completarCheckListProps.marca }}</p>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-2">
                                                <p class="col-6 col-form-label">Modelo</p>
                                                <div class="col-6">
                                                    <p class="mb-0">{{ completarCheckListProps.modelo }}</p>
                                                </div>
                                            </div>
                                            <div class="row align-items-start mb-2">
                                                <p class="col-6 col-form-label">Patente</p>
                                                <div class="col-6">
                                                    <div class="form-check form-switch mb-3">
                                                        <input class="form-check-input switch-checklist" type="checkbox"
                                                            role="switch" id="completarCheckListPatenteExiste"
                                                            v-model="patente_existe"
                                                            @change="switchPatenteExiste(patente_existe)">
                                                    </div>

                                                    <input v-if="patente_existe" class="form-control form-control-sm"
                                                        list="completarCheckListPatente" id="completarCheckListPatente"
                                                        v-model="patente" placeholder="Escriba la Patente"
                                                        :class="errors_finalizar_checklist ? errors_finalizar_checklist.errors?.patente ? 'is-invalid' : '' : ''"
                                                        required>

                                                    <select v-else id="completarCheckListPatente"
                                                        class="form-select form-select-sm"
                                                        :class="errors_finalizar_checklist ? errors_finalizar_checklist.errors?.patente ? 'is-invalid' : '' : ''"
                                                        v-model="patente">
                                                        <option selected disabled>Selecciona la Patente</option>
                                                        <template v-for="vehiculo in completarCheckListProps.vehiculos">
                                                            <option :value="vehiculo.patente">{{ vehiculo.patente }}
                                                            </option>
                                                        </template>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-2">
                                                <p class="col-6 col-form-label">Conductor/Operador</p>
                                                <div class="col-6">
                                                    <p class="mb-0" v-if="completarCheckListProps.conductor">{{
                                                        completarCheckListProps.conductor }}</p>
                                                    <input v-else type="text" class="form-control form-control-sm"
                                                        id="completarCheckListConductor" v-model="conductor"
                                                        :class="errors_finalizar_checklist ? errors_finalizar_checklist.errors?.conductor ? 'is-invalid' : '' : ''"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <h5>Kilometraje y Horometro</h5>
                                            <div class="row align-items-center mb-2">
                                                <p class="col-6 col-form-label">Kilometraje</p>
                                                <div class="col-6">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input switch-checklist" type="checkbox"
                                                            role="switch" id="completarCheckListKilometraje"
                                                            v-model="kilometraje_existe"
                                                            @change="switchKilometrajeExiste(kilometraje_existe)">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-2">
                                                <p class="col-6 col-form-label">Inicial</p>
                                                <div class="col-6">
                                                    <input type="number" class="form-control form-control-sm"
                                                        id="completarCheckListkilometrajeInicial"
                                                        v-model="kilometraje_inicial"
                                                        :disabled="kilometraje_existe_inicial"
                                                        :class="errors_finalizar_checklist ? errors_finalizar_checklist.errors?.kilometraje_inicial ? 'is-invalid' : '' : ''"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-2">
                                                <p class="col-6 col-form-label">Final</p>
                                                <div class="col-6">
                                                    <input type="number" class="form-control form-control-sm"
                                                        id="completarCheckListkilometrajeFinal"
                                                        v-model="kilometraje_final" :disabled="kilometraje_existe_final"
                                                        :class="errors_finalizar_checklist ? errors_finalizar_checklist.errors?.kilometraje_final ? 'is-invalid' : '' : ''"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-2">
                                                <p class="col-6 col-form-label">Horometro</p>
                                                <div class="col-6">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input switch-checklist" type="checkbox"
                                                            role="switch" id="completarCheckListHorometro"
                                                            v-model="horometro_existe"
                                                            @change="switchHorometroExiste(horometro_existe)">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-2">
                                                <p class="col-6 col-form-label">Inicial</p>
                                                <div class="col-6">
                                                    <input type="number" class="form-control form-control-sm"
                                                        id="completarCheckListHorometroInicial"
                                                        v-model="horometro_inicial" :disabled="horometro_existe_final"
                                                        :class="errors_finalizar_checklist ? errors_finalizar_checklist.errors?.horometro_inicial ? 'is-invalid' : '' : ''"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-2">
                                                <p class="col-6 col-form-label">Final</p>
                                                <div class="col-6">
                                                    <input type="number" class="form-control form-control-sm"
                                                        id="completarCheckListHorometroFinal" v-model="horometro_final"
                                                        :disabled="horometro_existe_final"
                                                        :class="errors_finalizar_checklist ? errors_finalizar_checklist.errors?.horometro_final ? 'is-invalid' : '' : ''"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <h5>Estado Equipo</h5>
                                            <div class="row">
                                                <p class="fw-bold mb-0">Status Equipo</p>

                                                <div class="row align-items-center mb-2">
                                                    <p class="col-6 col-form-label">Operativo</p>
                                                    <div class="col-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox-checklist"
                                                                type="radio" name="radioEstadoEquipo"
                                                                id="radioEstadoEquipoOperativo" value="1"
                                                                :class="errors_finalizar_checklist ? errors_finalizar_checklist.errors?.estado_equipo ? 'is-invalid' : '' : ''"
                                                                v-model="estado_equipo">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row align-items-center mb-2">
                                                    <p class="col-6 col-form-label">Fuera De Servicio</p>
                                                    <div class="col-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox-checklist"
                                                                type="radio" name="radioEstadoEquipo"
                                                                id="radioEstadoEquipoFueraServicio" value="0"
                                                                :class="errors_finalizar_checklist ? errors_finalizar_checklist.errors?.estado_equipo ? 'is-invalid' : '' : ''"
                                                                v-model="estado_equipo">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <p class="fw-bold mb-0">Carga De Combustible</p>
                                                <div class="row align-items-center mb-2">
                                                    <p class="col-6 col-form-label">SI</p>
                                                    <div class="col-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox-checklist"
                                                                type="radio" name="radioCargaCombustible"
                                                                id="radioCargaCombustibleSi" value="1"
                                                                v-model="carga_combustible"
                                                                :class="errors_finalizar_checklist ? errors_finalizar_checklist.errors?.carga_combustible ? 'is-invalid' : '' : ''"
                                                                @change="checkCargaCombustible(false)">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row align-items-center mb-2">
                                                    <p class="col-6 col-form-label">NO</p>
                                                    <div class="col-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox-checklist"
                                                                type="radio" name="radioCargaCombustible"
                                                                id="radioCargaCombustibleNo" value="0"
                                                                v-model="carga_combustible"
                                                                :class="errors_finalizar_checklist ? errors_finalizar_checklist.errors?.carga_combustible ? 'is-invalid' : '' : ''"
                                                                @change="checkCargaCombustible(true)">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row align-items-center mb-2">
                                                    <p class="col-6 col-form-label">LTS</p>
                                                    <div class="col-6">
                                                        <input type="number" min="0"
                                                            class="form-control form-control-sm"
                                                            id="completarCheckListLitros" v-model="litros"
                                                            :disabled="carga_combustible_existe"
                                                            :class="errors_finalizar_checklist ? errors_finalizar_checklist.errors?.litros ? 'is-invalid' : '' : ''"
                                                            required>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <p class="fw-bold mb-0">INDIQUE NIVEL DE COMBUSTIBLE AL INICIAR EL TURNO
                                                </p>
                                                <div>
                                                    <input type="file" class="form-control"
                                                        id="completarCheckListImagenCombustible"
                                                        @change="handleFileChange" accept=".png, .jpeg, .jpg"
                                                        ref="completarCheckListImagenCombustible"
                                                        :class="errors_finalizar_checklist ? errors_finalizar_checklist.errors?.imagen ? 'is-invalid' : '' : ''"
                                                        aria-label="Imagen">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <h5>Observacion (Bitacora)</h5>
                                            <div class="col-12">
                                                <textarea class="form-control"
                                                    id="completarCheckListObservacionBitacora"
                                                    v-model="observacion_bitacora"
                                                    :class="errors_finalizar_checklist ? errors_finalizar_checklist.errors?.observacion_bitacora ? 'is-invalid' : '' : ''"
                                                    rows="5" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-12">
                                <CheckListObservacion v-if="mostrarAgregarObservacion"
                                    @volver-completarCheckList="volverCompletarCheckList"
                                    @create-checkListObservacionCompletar="createCheckListObservacionCompletar"
                                    :checklist_agregar_observacion_props="checklist_agregar_observacion"
                                    :checklist_devolver_observaciones_props="checklist_devolver_observaciones">
                                </CheckListObservacion>
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
                                            <template v-for="categoria in completarCheckListProps.categorias">
                                                <template v-if="categoria.intervenciones.length > 0">
                                                    <tr class="table-active">
                                                        <th colspan="7">{{ categoria.nombre }}</th>
                                                    </tr>

                                                    <tr v-for="(intervencion, index) in categoria.intervenciones"
                                                        :key="intervencion.id + '_' + index">
                                                        <td>{{ intervencion.nombre }}</td>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input checkbox-checklist"
                                                                    type="radio"
                                                                    :name="'radio_existe_si_' + intervencion.id + '_' + index"
                                                                    :id="'radio_existe_si_' + intervencion.id + '_' + index"
                                                                    :value="1" v-model="radioExiste[intervencion.id]"
                                                                    @change="checklistRadio(categoria.nombre, intervencion.nombre, intervencion.id, radioExiste[intervencion.id], 'existe')">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input checkbox-checklist"
                                                                    type="radio"
                                                                    :name="'radio_existe_no_' + intervencion.id + '_' + index"
                                                                    :id="'radio_existe_no_' + intervencion.id + '_' + index"
                                                                    :value="2" v-model="radioExiste[intervencion.id]"
                                                                    @change="checklistRadio(categoria.nombre, intervencion.nombre, intervencion.id, radioExiste[intervencion.id], 'existe')">
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input checkbox-checklist"
                                                                    type="radio"
                                                                    :name="'radio_estado_1_' + intervencion.id + '_' + index"
                                                                    :id="'radio_estado_1_' + intervencion.id + '_' + index"
                                                                    :value="1" v-model="radioEstado[intervencion.id]"
                                                                    :disabled="aplicaEstado[intervencion.id]"
                                                                    @change="checklistRadio(categoria.nombre, intervencion.nombre, intervencion.id, radioEstado[intervencion.id], 'estado')">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input checkbox-checklist"
                                                                    type="radio"
                                                                    :name="'radio_estado_2_' + intervencion.id + '_' + index"
                                                                    :id="'radio_estado_2_' + intervencion.id + '_' + index"
                                                                    :value="2" v-model="radioEstado[intervencion.id]"
                                                                    :disabled="aplicaEstado[intervencion.id]"
                                                                    @change="checklistRadio(categoria.nombre, intervencion.nombre, intervencion.id, radioEstado[intervencion.id], 'estado')">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input checkbox-checklist"
                                                                    type="radio"
                                                                    :name="'radio_estado_3_' + intervencion.id + '_' + index"
                                                                    :id="'radio_estado_3_' + intervencion.id + '_' + index"
                                                                    :value="3" v-model="radioEstado[intervencion.id]"
                                                                    :disabled="aplicaEstado[intervencion.id]"
                                                                    @change="checklistRadio(categoria.nombre, intervencion.nombre, intervencion.id, radioEstado[intervencion.id], 'estado')">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-base-dv w-100"
                                                                @click="agregarObservacion(completarCheckListProps.id, intervencion.id)"><i
                                                                    class="bi bi-eye"></i> Observación</button>
                                                        </td>

                                                    </tr>
                                                </template>
                                            </template>
                                        </tbody>
                                    </table>
                                    <template v-if="errors_finalizar_checklist">
                                        <div v-for="errors in errors_finalizar_checklist.errors_checks"
                                            class="alert alert-danger alert-dismissible" role="alert">
                                            <template v-if="errors.existe === null && errors.estado === null">
                                                <i class="bi bi-exclamation-triangle-fill"></i>
                                                Aplica y Estado de la <strong>{{ errors.categoria }}</strong><strong> -
                                                    {{
                                                        errors.intervencion }}</strong> no pueden quedar vacio
                                            </template>
                                            <template v-else-if="errors.existe !== null && errors.estado === null">
                                                <i class="bi bi-exclamation-triangle-fill"></i>
                                                Estado de la <strong>{{ errors.categoria }}</strong><strong> - {{
                                                    errors.intervencion }}</strong> no puede quedar vacio
                                            </template>
                                            <template v-else-if="errors.existe === null">
                                                <i class="bi bi-exclamation-triangle-fill"></i>
                                                Aplica de la <strong>{{ errors.categoria }}</strong><strong> - {{
                                                    errors.intervencion }}</strong> no puede quedar vacio
                                            </template>
                                        </div>
                                    </template>
                                </div>

                                <div class="d-flex justify-content-end mt-3"
                                    v-if="completarCheckListProps.status && !mostrarAgregarObservacion">
                                    <button type="button" class="btn btn-base-dv" @click="finalizarCheckList()"
                                        :disabled="loading_checklist_create">
                                        <span v-if="loading_checklist_create">
                                            <span class="spinner-border spinner-border-sm" role="status"
                                                aria-hidden="true"></span>
                                            Cargando...</span>
                                        <span v-else><i class="bi bi-clipboard2-check-fill"></i> Finalizar</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import checklistMixin from '../../mixins/checklist/checklistMixin';
import CheckListObservacion from './CheckListObservacion.vue';
import { redimensionarImagen } from '../../utils/redimensionarImagen';

export default {
    mixins: [checklistMixin],
    components: { CheckListObservacion },
    props: {
        completarCheckListProps: Object,
    },
    data() {
        return {
            kilometraje_existe_inicial: true,
            kilometraje_existe_final: true,
            kilometraje_existe: false,

            horometro_existe_inicial: true,
            horometro_existe_final: true,
            horometro_existe: false,

            patente_existe: false,

            carga_combustible_existe: true,

            patente: '',
            conductor: '',
            kilometraje_inicial: null,
            kilometraje_final: null,
            horometro_inicial: null,
            horometro_final: null,
            numero_interno: '',
            proyecto: '',
            faena: '',
            turno: '',
            litros: 0,
            observacion_bitacora: '',
            carga_combustible: null,
            estado_equipo: null,
            imagen_combustible: null,
            observaciones: [],


            checkslist: [],
            aplicaEstado: {},
            radioExiste: {},
            radioEstado: {},
            mostrarAgregarObservacion: false,
            checklist_agregar_observacion: null,
            checklist_devolver_observaciones: null
        };
    },
    watch: {
        completarCheckListProps: {
            immediate: true,
            handler(completarCheckListProps) {
                if (completarCheckListProps && completarCheckListProps.categorias) {
                    completarCheckListProps.categorias.forEach(categoria => {
                        if (categoria.intervenciones) {
                            categoria.intervenciones.forEach(intervencion => {
                                this.checkslist.push({
                                    categoria: categoria.nombre,
                                    estado: null,
                                    existe: null,
                                    intervencion: intervencion.nombre,
                                    intervencion_id: intervencion.id
                                })
                            })
                        }
                    });
                }
            }
        },

        kilometraje_inicial(newVal, oldVal) {
            if (newVal !== null && this.kilometraje_final !== null && newVal >= this.kilometraje_final) {
                this.errors_finalizar_checklist = {
                    errors: { kilometraje_inicial: "El kilometraje inicial no puede ser mayor que el final." },
                };
            } else {
                this.clearError("kilometraje_inicial");
            }
        },
        kilometraje_final(newVal, oldVal) {
            if (newVal !== null && this.kilometraje_inicial !== null && newVal <= this.kilometraje_inicial) {
                this.errors_finalizar_checklist = {
                    errors: { kilometraje_final: "El kilometraje final no puede ser menor que el inicial." },
                };
            } else {
                this.clearError("kilometraje_final");
            }
        },

        horometro_inicial(newVal, oldVal) {
            if (newVal !== null && this.horometro_final !== null && newVal > this.horometro_final) {
                this.errors_finalizar_checklist = {
                    errors: { horometro_inicial: "El horometro inicial no puede ser mayor que el final." },
                };
            } else {
                this.clearError("horometro_inicial");
            }
        },
        horometro_final(newVal, oldVal) {
            if (newVal !== null && this.horometro_inicial !== null && newVal < this.horometro_inicial) {
                this.errors_finalizar_checklist = {
                    errors: { horometro_final: "El horometro final no puede ser menor que el inicial." },
                };
            } else {
                this.clearError("horometro_final");
            }
        },
    },
    methods: {
        clearError(field) {
            if (this.errors_finalizar_checklist?.errors?.[field]) {
                delete this.errors_finalizar_checklist.errors[field];
                // Limpia todo el objeto de errores si ya no hay errores restantes
                if (Object.keys(this.errors_finalizar_checklist.errors).length === 0) {
                    this.errors_finalizar_checklist = null;
                }
            }
        },
        open() {
            const modalElement = document.getElementById('completarCheckListModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            this.limpiarParametros();
            const modalElement = document.getElementById('completarCheckListModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },

        agregarObservacion(matriz_id, intervencion_id) {
            this.mostrarAgregarObservacion = true;
            this.checklist_agregar_observacion = { matriz_id: matriz_id, intervencion_id: intervencion_id };
        },

        volverCompletarCheckList(observaciones) {
            this.mostrarAgregarObservacion = false;
            this.checklist_devolver_observaciones = observaciones;
        },

        checklistRadio(categoria_nombre, intervencion_nombre, intervencion_id, value, tipo) {
            const index = this.checkslist.findIndex(item => item.intervencion_id === intervencion_id);
            if (index !== -1) {
                if (tipo === 'existe') {
                    if (value === 2) {
                        this.checkslist[index].estado = null;
                        delete this.radioEstado[intervencion_id];
                    }
                    this.aplicaEstado[intervencion_id] = value === 2;
                    this.checkslist[index].existe = value;
                } else if (tipo === 'estado') {
                    this.checkslist[index].estado = value;
                }
            } else {
                this.checkslist.push({
                    categoria: categoria_nombre,
                    intervencion: intervencion_nombre,
                    intervencion_id: intervencion_id,
                    estado: tipo === 'estado' ? value : null,
                    existe: tipo === 'existe' ? value : null,
                });
                this.aplicaEstado[intervencion_id] = value === 2 && tipo === 'existe';
            }
        },

        createCheckListObservacionCompletar(observacionChecklist) {
            this.observaciones.push(observacionChecklist)
        },

        async finalizarCheckList() {
            const formData = new FormData();
            formData.append('checkslist', JSON.stringify(this.checkslist));
            formData.append('checklist_id', this.completarCheckListProps.id);
            formData.append('patente', this.patente);
            formData.append('conductor', this.conductor);
            formData.append('kilometraje_inicial', this.kilometraje_inicial === null ? 0 : this.kilometraje_inicial);
            formData.append('kilometraje_final', this.kilometraje_final === null ? 0 : this.kilometraje_final);
            formData.append('horometro_inicial', this.horometro_inicial === null ? 0 : this.horometro_inicial);
            formData.append('horometro_final', this.horometro_final === null ? 0 : this.horometro_final);
            formData.append('numero_interno', this.numero_interno);
            formData.append('proyecto', this.proyecto);
            formData.append('faena', this.faena);
            formData.append('turno', this.turno);
            formData.append('litros', this.litros);
            formData.append('observacion_bitacora', this.observacion_bitacora);
            formData.append('carga_combustible', this.carga_combustible);
            formData.append('estado_equipo', this.estado_equipo);


            this.observaciones.forEach((observacion, index) => {
                formData.append(`observaciones[${index}][observacion]`, observacion.observacion);
                formData.append(`observaciones[${index}][checklist_intervencion_id]`, observacion.checklist_intervencion_id);

                if (observacion.imagen_observacion) {
                    formData.append(`observaciones[${index}][imagen_observacion]`, observacion.imagen_observacion);
                }
            });


            if (this.imagen_combustible) {
                formData.append('imagen_combustible', this.imagen_combustible);
            }

            const response = await this.finalizarChecklist(formData);

            if (this.errors_finalizar_checklist === null) {
                this.$notyf.success(response.message);
                this.$emit('checklist-completada', response.checklistCondicion);
                this.limpiarParametros();
                this.close();
            }
        },

        limpiarParametros() {
            this.checkslist = [];
            this.radioExiste = {};
            this.radioEstado = {};
            this.errors_finalizar_checklist = null;
            this.carga_combustible_existe = null;
            this.estado_equipo = null;

            this.kilometraje_inicial = null;
            this.kilometraje_final = null;
            this.kilometraje_existe_inicial = true;
            this.kilometraje_existe_final = true;

            this.horometro_inicial = null;
            this.horometro_final = null;
            this.horometro_existe_inicial = true;
            this.horometro_existe_final = true;
            this.patente_existe = null;
            this.kilometraje_existe = false;
            this.horometro_existe = false;

            this.patente = '';
            this.conductor = '';
            this.numero_interno = '';
            this.proyecto = '';
            this.faena = '';
            this.turno = '';
            this.litros = null;
            this.observacion_bitacora = '';
            this.carga_combustible = null;
            this.estado_equipo = null;
            this.imagen_combustible = null;
            this.mostrarAgregarObservacion = false;
            document.getElementById('completarCheckListImagenCombustible').value = null;
            this.checklist_agregar_observacion = null;
            this.checklist_devolver_observaciones = null;
        },

        async switchKilometrajeExiste(existe) {
            this.kilometraje_inicial = existe ? this.kilometraje_inicial : null;
            this.kilometraje_final = existe ? this.kilometraje_final : null;
            this.kilometraje_existe_inicial = existe ? false : true;
            this.kilometraje_existe_final = existe ? false : true;
        },
        async switchHorometroExiste(existe) {
            this.horometro_inicial = existe ? this.horometro_inicial : null;
            this.horometro_final = existe ? this.horometro_final : null;
            this.horometro_existe_inicial = existe ? false : true;
            this.horometro_existe_final = existe ? false : true;
        },
        async switchPatenteExiste(existe) {
            this.patente = existe ? '' : this.patente;
            this.patente_existe = existe;
        },
        async checkCargaCombustible(existe) {
            this.litros = existe ? 0 : this.litros;
            this.carga_combustible_existe = existe;
        },
        async checkEstadoEquipo(existe) {
            this.estado_equipo_existe = existe;
        },
        async handleFileChange(event) {
            const file = event.target.files[0];
            this.errors_finalizar_checklist = null;

            try {
                const resizedImage = await Promise.resolve(this.redimensionarImagen(file));
                this.imagen_combustible = resizedImage;
            } catch (error) {
                this.errors_finalizar_checklist = { imagenes: [error.message] };
                console.error('Error al procesar archivos:', error);
            }
        },
        redimensionarImagen
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