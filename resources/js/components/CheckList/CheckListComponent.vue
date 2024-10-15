<template>
    <div>
        <div class="d-flex justify-content-between mb-3">
            <h3>Matriz Checklist</h3>

            <div>
                <button type="button" class="btn btn-base-dv" @click="openListaModal()"><i class="bi bi-list-check"></i>
                    Ver Matriz Checklist</button>
                <button type="button" class="btn btn-base-dv" @click="openCrearModal()"><i
                        class="bi bi-plus-circle"></i>
                    Crear Matriz Checklist</button>
            </div>
        </div>

        <div class="card shadow mb-5">
            <div class="card-body">
                <form @submit.prevent="saveChecklist">
                    <h5>Crear Checklist</h5>
                    <div class="row mb-3">
                        <div class="col-lg-3 col-md-12">
                            <label for="checklistEquipo" class="form-label">Tipo Equipo</label>
                            <select class="form-select" aria-label="Seleccione el equipo" id="checklistEquipo"
                                v-model="newChecklist.activo_id"
                                :class="errors_checklist ? errors_checklist.activo_id ? 'is-invalid' : '' : ''"
                                required>
                                <option :value="null" disabled>Seleccione el Equipo</option>
                                <template v-for="tipo_activo in tipo_activos">
                                    <option :value="tipo_activo.id">{{ tipo_activo.name }}</option>
                                </template>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-12">
                            <label for="checklistMatriz" class="form-label">Matriz Checklist</label>
                            <select class="form-select" aria-label="Seleccione el matriz" id="checklistMatriz"
                                v-model="newChecklist.matriz_checklist_id"
                                :class="errors_checklist ? errors_checklist.matriz_checklist_id ? 'is-invalid' : '' : ''"
                                required>
                                <option :value="null" disabled>Seleccione la Matriz</option>
                                <template v-for="matriz in matrizChecklist">
                                    <option v-if="matriz.status" :value="matriz.id">{{ matriz.nombre }}</option>
                                </template>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-12">
                            <label for="checklistMarca" class="form-label">Marca</label>
                            <input type="text" class="form-control" id="checklistMarca" v-model="newChecklist.marca"
                                :class="errors_checklist ? errors_checklist.marca ? 'is-invalid' : '' : ''" required>
                        </div>

                        <div class="col-lg-3 col-md-12">
                            <label for="checklistModelo" class="form-label">Modelo</label>
                            <input type="text" class="form-control" id="checklistModelo" v-model="newChecklist.modelo"
                                :class="errors_checklist ? errors_checklist.modelo ? 'is-invalid' : '' : ''" required>
                        </div>
                    </div>


                    <button type="submit" class="btn btn-base-dv" :disabled="loading_matriz_create">
                        <span v-if="loading_matriz_create">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Cargando...</span>
                        <span v-else>Guardar Cambios</span>
                    </button>

                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class=table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tipo Equipo</th>
                        <th>Matriz Checklist</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(check, index) in checklist" :key="check.id">
                        <th>{{ index + 1 }}</th>
                        <td>{{ check.activo.tipo_activo.name }}</td>
                        <td>{{ check.matriz.nombre }}</td>
                        <td>{{ check.marca }}</td>
                        <td>{{ check.modelo }}</td>
                        <td>
                            <button type="button" class="btn btn-base-dv" @click="openCompletarCheckListModal(check)"><i
                                    class="bi bi-ui-checks"></i></button>
                            <button type="button" class="btn btn-warning" @click="openEditarModal(check.matriz)"><i
                                    class="bi bi-pencil-square"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>


        <MatrizCheckListModal ref="matrizCheckListModal" />
        <ListaMatrizCheckListModal ref="listaMatrizCheckListModal" :matrizChecklistProps="matrizChecklist" />
        <EditCheckListModal ref="editarCheckListModal" :editMatrizChecklistProps="editChecklist" />
        <CompletarCheckListModal ref="completarCheckListModal" :completarCheckList="completarChecklist" />
    </div>
</template>

<script>
import checklistMixin from '../../mixins/checklist/checklistMixin';
import tipoActivoMixin from '../../mixins/tipoActivo/tipoActivoMixin';
import matrizChecklistMixin from '../../mixins/checklist/matrizChecklistMixin';

import MatrizCheckListModal from './MatrizCheckList/MatrizCheckListModal.vue'
import ListaMatrizCheckListModal from './MatrizCheckList/ListaMatrizCheckListModal.vue';
import EditCheckListModal from './EditCheckListModal.vue';
import CompletarCheckListModal from './CompletarCheckListModal.vue';

export default {
    mixins: [checklistMixin, matrizChecklistMixin, tipoActivoMixin],
    components: {
        MatrizCheckListModal,
        ListaMatrizCheckListModal,
        EditCheckListModal,
        CompletarCheckListModal
    },
    data() {
        return {
            newChecklist: {
                activo_id: 0,
                matriz_checklist_id: 0,
                marca: '',
                modelo: ''
            }

        };
    },
    methods: {
        openCrearModal() {
            this.$refs.matrizCheckListModal.open();
        },
        openListaModal() {
            this.$refs.listaMatrizCheckListModal.open();
        },
        openEditarModal(matrizChecklist) {
            this.$refs.editarCheckListModal.open();
            this.editChecklist = matrizChecklist;
        },
        async openCompletarCheckListModal(matrizChecklist) {
            this.$refs.completarCheckListModal.open();
            const intervenciones = await this.fetchItervenciones(matrizChecklist.id);

            matrizChecklist.matriz.categorias.forEach(categoria => {
                categoria.intervenciones.forEach(intervencion => {
                    intervenciones.forEach(inter => {
                        if (inter.matriz_intervencion_checklist_id === intervencion.id) {
                            intervencion.selected = true;
                        }
                    });
                });
            });

            this.completarChecklist = matrizChecklist;

            
        },
        async saveChecklist() {
            const response = await this.createChecklist(this.newChecklist);

            if (this.errors_checklist === null) {
                this.$notyf.success(response.message);
                this.checklist.push(response.checklist)
            }
        }

    },
    mounted() {
        this.fetchTipoActivosSelect();
        this.fetchMatrizChecklist();
        this.fetchChecklist();
    }
}
</script>

<style scoped></style>