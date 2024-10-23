<template>
    <div class="modal fade" id="completarCheckListModal" tabindex="-1" aria-labelledby="completarCheckListModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="matrizCheckListModalLabel">Completar CheckList</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <template v-if="completarCheckListProps && completarCheckListProps.matriz">
                        <div class="card mb-3 border-card border-checklist">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <p class="col-6 col-form-label fw-bold">Tipo Equipo</p>
                                    <div class="col-6">
                                        <p class="mb-0">{{ completarCheckListProps.activo.tipo_activo.name }}</p>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <p class="col-6 col-form-label fw-bold">Matriz
                                        Checklist</p>
                                    <div class="col-6">
                                        <p class="mb-0">{{ completarCheckListProps.matriz.nombre }}</p>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <p class="col-6 col-form-label fw-bold">Marca</p>
                                    <div class="col-6">
                                        <p class="mb-0">{{ completarCheckListProps.marca }}</p>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <p class="col-6 col-form-label fw-bold">Modelo</p>
                                    <div class="col-6">
                                        <p class="mb-0">{{ completarCheckListProps.modelo }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <VerCheckListCompletado v-if="completarCheckListProps.status === 0"
                            :verCheckListProps="completarCheckListProps"></VerCheckListCompletado>
                        <CheckListObservacion v-else-if="mostrarAgregarObservacion"
                            @volver-completarCheckList="volverCompletarCheckList"
                            @delete-checkListObservacionCompletar="eliminarCheckListObservacionCompletar"
                            :checklist_intervencionProps="checklist_intervencion"></CheckListObservacion>
                        <div v-else class="table-responsive">
                            <table class="table table-bordered text-center align-middle">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Categoria</th>
                                        <th colspan="2">Existe</th>
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
                                                        <input class="form-check-input" type="radio"
                                                            :name="'radio_existe_si_' + intervencion.id + '_' + index"
                                                            :id="'radio_existe_si_' + intervencion.id + '_' + index"
                                                            :value="1" v-model="radioExiste[intervencion.id]"
                                                            @change="checklistRadio(categoria.nombre, intervencion.nombre, intervencion.id, radioExiste[intervencion.id], 'existe')">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            :name="'radio_existe_no_' + intervencion.id + '_' + index"
                                                            :id="'radio_existe_no_' + intervencion.id + '_' + index"
                                                            :value="2" v-model="radioExiste[intervencion.id]"
                                                            @change="checklistRadio(categoria.nombre, intervencion.nombre, intervencion.id, radioExiste[intervencion.id], 'existe')">
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            :name="'radio_estado_1_' + intervencion.id + '_' + index"
                                                            :id="'radio_estado_1_' + intervencion.id + '_' + index"
                                                            :value="1" v-model="radioEstado[intervencion.id]"
                                                            @change="checklistRadio(categoria.nombre, intervencion.nombre, intervencion.id, radioEstado[intervencion.id], 'estado')">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            :name="'radio_estado_2_' + intervencion.id + '_' + index"
                                                            :id="'radio_estado_2_' + intervencion.id + '_' + index"
                                                            :value="2" v-model="radioEstado[intervencion.id]"
                                                            @change="checklistRadio(categoria.nombre, intervencion.nombre, intervencion.id, radioEstado[intervencion.id], 'estado')">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            :name="'radio_estado_3_' + intervencion.id + '_' + index"
                                                            :id="'radio_estado_3_' + intervencion.id + '_' + index"
                                                            :value="3" v-model="radioEstado[intervencion.id]"
                                                            @change="checklistRadio(categoria.nombre, intervencion.nombre, intervencion.id, radioEstado[intervencion.id], 'estado')">
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-base-dv w-100"
                                                        @click="agregarObservacion(intervencion)"><i
                                                            class="bi bi-eye"></i> Observación</button>
                                                </td>

                                            </tr>
                                        </template>
                                    </template>
                                </tbody>
                            </table>
                            <template v-if="Array.isArray(errors_finalizar_checklist)">
                                <div v-for="errors in errors_finalizar_checklist"
                                    class="alert alert-danger alert-dismissible" role="alert">
                                    <template v-if="errors.existe === null && errors.estado === null">
                                        <i class="bi bi-exclamation-triangle-fill"></i>
                                        Existe y Estado de la <strong>{{ errors.categoria }}</strong><strong> - {{
                                            errors.intervencion }}</strong> no pueden quedar vacio
                                    </template>
                                    <template v-else-if="errors.estado === null">
                                        <i class="bi bi-exclamation-triangle-fill"></i>
                                        Estado de la <strong>{{ errors.categoria }}</strong><strong> - {{
                                            errors.intervencion }}</strong> no puede quedar vacio
                                    </template>
                                    <template v-else-if="errors.existe === null">
                                        <i class="bi bi-exclamation-triangle-fill"></i>
                                        Existe de la <strong>{{ errors.categoria }}</strong><strong> - {{
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
                    </template>


                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import checklistMixin from '../../mixins/checklist/checklistMixin';
import VerCheckListCompletado from './VerCheckListCompletado.vue';
import CheckListObservacion from './CheckListObservacion.vue';

export default {
    mixins: [checklistMixin],
    components: { VerCheckListCompletado, CheckListObservacion },
    props: {
        completarCheckListProps: Object,
    },
    data() {
        return {
            checkslist: [],
            radioExiste: {},
            radioEstado: {},
            mostrarAgregarObservacion: false,
            checklist_intervencion: null
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
        }
    },
    methods: {
        open() {
            this.limpiarParametros();
            const modalElement = document.getElementById('completarCheckListModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('completarCheckListModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },

        agregarObservacion(intervencion) {
            this.mostrarAgregarObservacion = true;
            console.log(intervencion)
            this.checklist_intervencion = intervencion;
        },

        volverCompletarCheckList() {
            this.mostrarAgregarObservacion = false;
        },

        checklistRadio(categoria_nombre, intervencion_nombre, intervencion_id, value, tipo) {
            const index = this.checkslist.findIndex(item => item.intervencion_id === intervencion_id);
            if (index !== -1) {
                if (tipo === 'existe') {
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
            }
        },

        async finalizarCheckList() {
            const response = await this.finalizarChecklist(this.checkslist, this.completarCheckListProps.id);

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
        },

        eliminarCheckListObservacionCompletar(observacionChecklist) {
            this.checklist_intervencion.observaciones = this.checklist_intervencion.observaciones.filter(observacion => observacion.id !== observacionChecklist.id);
        }
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

.form-check-input {
    float: none;
    width: 1.4em;
    height: 1.4em;
}
</style>