<template>
    <div>
        <div class="d-flex justify-content-between mb-3">
            <h3>Matriz Checklist</h3>

            <div v-if="userRole && userRole.name !== 'usuario'">
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
                                v-model="newChecklist.tipo_activo_id"
                                :class="errors_checklist ? errors_checklist.tipo_activo_id ? 'is-invalid' : '' : ''"
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

        <LoadingComponent v-if="loading_matriz" />
        <div v-else class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tipo Equipo</th>
                        <th>Matriz Checklist</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Habilitar</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="checklist.length">
                        <tr v-for="(check, index) in checklist" :key="check.id">
                            <th>{{ index + 1 }}</th>
                            <td>{{ check.tipoactivo.name }}</td>
                            <td>{{ check.matriz.nombre }}</td>
                            <td>{{ check.marca }}</td>
                            <td>{{ check.modelo }}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        :id="'check-' + check.id + '_' + index" v-model="check.status"
                                        @change="habilitarCheckList(check.id, check.status)">
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-warning" @click="openEditarModal(check)"><i
                                        class="bi bi-pencil-square"></i></button>
                            </td>
                        </tr>
                    </template>
                    <p v-else>No hay matriz checklist.</p>
                </tbody>
            </table>
        </div>

        <EditCheckListModal ref="editarCheckListModal" :editChecklistProps="editChecklist" />
        <MatrizCheckListModal ref="matrizCheckListModal"
            @listarMatrizChecklist-finalizada="listarMatrizChecklistFinalizada" />
        <ListaMatrizCheckListModal ref="listaMatrizCheckListModal" :matrizChecklistProps="matrizChecklist" />
    </div>
</template>

<script>
import checklistMixin from '../../mixins/checklist/checklistMixin';
import tipoActivoMixin from '../../mixins/tipoActivo/tipoActivoMixin';
import matrizChecklistMixin from '../../mixins/checklist/matrizChecklistMixin';
import usuariosMixin from '../../mixins/usuarios/usuariosMixin';

import EditCheckListModal from '../CheckList/EditarChecklist/EditCheckListModal.vue';
import MatrizCheckListModal from './MatrizCheckListModal.vue'
import ListaMatrizCheckListModal from './ListaMatrizCheckListModal.vue';
import CompletarCheckListModal from '../CheckList/CompletarCheckListModal.vue';
import LoadingComponent from '../base/LoadingComponent.vue';

export default {
    mixins: [checklistMixin, matrizChecklistMixin, tipoActivoMixin, usuariosMixin],
    components: {
        MatrizCheckListModal,
        ListaMatrizCheckListModal,
        EditCheckListModal,
        CompletarCheckListModal,
        LoadingComponent
    },
    data() {
        return {
            newChecklist: {
                tipo_activo_id: null,
                matriz_checklist_id: null,
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
        openEditarModal(checklist) {
            this.$refs.editarCheckListModal.open();
            this.editChecklist = checklist;
        },
        async saveChecklist() {
            const response = await this.createChecklist(this.newChecklist);

            if (this.errors_checklist === null) {
                this.$notyf.success(response.message);
                this.checklist.push(response.checklist)

                this.newChecklist.tipo_activo_id = 0;
                this.newChecklist.matriz_checklist_id = null;
                this.newChecklist.marca = '';
                this.newChecklist.modelo = '';
            }
        },
        async habilitarCheckList(checklist_id, status) {
            const checkboxStatus = status ? 1 : 0;
            const checkbox = { checklist_id: checklist_id, status: checkboxStatus };

            try {
                await this.actualizarStatusChecklist(checkbox);
            } catch (error) {
                console.error('Error actualizando el estado:', error);
            }
        },
        listarMatrizChecklistFinalizada() {
            this.fetchMatrizChecklist();
        },
    },
    created() {
        this.fetchTipoActivosSelect();
        this.fetchMatrizChecklist();
        this.fetchChecklist();
        this.fetchUserRole();
    }
}
</script>

<style scoped></style>