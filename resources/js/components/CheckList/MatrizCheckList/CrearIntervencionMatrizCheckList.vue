<template>
    <div>
        <div class="modal-header">
            <h5 class="modal-title" id="matrizCheckListModalLabel">Crear Intervencion Matriz CheckList</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form @submit.prevent="saveIntervencionMatrizChecklist">
                <div class="row align-items-end">
                    <div class="col-lg-4 col-md-12">
                        <label for="intervencionMatrizChecklistCategoria" class="form-label">Categoria</label>
                        <select class="form-select" aria-label="Seleccione el equipo"
                            id="intervencionMatrizChecklistCategoria"
                            v-model="newIntervencionMatrizChecklist.matriz_checklist_categoria_id"
                            :class="errors_intervencion_matriz_checklist ? errors_intervencion_matriz_checklist.matriz_checklist_categoria_id ? 'is-invalid' : '' : ''"
                            required>
                            <option :value="null" disabled>Seleccione la Categoria</option>
                            <template v-for="categoria in categorias">
                                <option :value="categoria.id">{{ categoria.nombre }}</option>
                            </template>
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <label for="intervencionMatrizChecklistNombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="intervencionMatrizChecklistNombre"
                            v-model="newIntervencionMatrizChecklist.nombre"
                            :class="errors_intervencion_matriz_checklist ? errors_intervencion_matriz_checklist.nombre ? 'is-invalid' : '' : ''"
                            required>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <button type="submit" class="btn btn-base-dv w-100" :disabled="loading_matriz_create">
                            <span v-if="loading_matriz_create">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Cargando...</span>
                            <span v-else>Agregar</span>
                        </button>
                    </div>
                </div>
            </form>

            <div class="table-responsive my-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Categoria</th>
                            <th>Intervencion</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(intervencion, index) in intervenciones" :key="intervencion.id">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ intervencion.categoria.nombre }}</td>
                            <td>{{ intervencion.nombre }}</td>
                            <td class="text-end">
                                <button type="button" class="btn btn-danger" :disabled="loading_matriz_delete && loading_id === intervencion.id"
                                    @click="deleteIntervencionMatrizChecklist(intervencion.id)">
                                    <span v-if="loading_matriz_delete && loading_id === intervencion.id">
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        Cargando...</span>
                                    <span v-else><i class="bi bi-trash"></i></span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-base-dv" @click="irACategorias()"><i class="bi bi-arrow-left"></i>
                Volver</button>
            <button type="button" class="btn btn-primary" :disabled="loading_matriz_finish"
                @click="finalizarMatrizChecklist()">
                <span v-if="loading_matriz_finish">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Cargando...</span>
                <span v-else>Finalizar</span>
            </button>
        </div>
    </div>
</template>

<script>
import matrizChecklistMixin from '../../../mixins/checklist/matrizChecklistMixin';

export default {
    mixins: [matrizChecklistMixin],
    props: {
        matrizChecklist_categorias: Array,
        matrizChecklist_intervenciones: Array,
        matriz_checklist_id: {
            type: Number,
            required: true
        },
    },
    data() {
        return {
            newIntervencionMatrizChecklist: {
                matriz_checklist_categoria_id: null,
                nombre: '',
            },
            categorias: this.matrizChecklist_categorias,
            intervenciones: this.matrizChecklist_intervenciones
        };
    },
    methods: {
        async saveIntervencionMatrizChecklist() {
            const response = await this.createIntervencionMatrizChecklist(this.newIntervencionMatrizChecklist);

            if (this.errors_intervencion_matriz_checklist === null) {
                this.intervenciones.push(response.intervencionMatrizChecklist);
                this.newIntervencionMatrizChecklist.nombre = '';
                this.newIntervencionMatrizChecklist.matriz_checklist_categoria_id = null
            }
        },

        async deleteIntervencionMatrizChecklist(id) {
            this.loading_id = id;
            const response = await this.eliminarIntervencionMatrizChecklist(id);

            if (this.errors_intervencion_matriz_checklist === null) {
                this.intervenciones = this.intervenciones.filter(intervencion => intervencion.id !== response.intervencionMatrizChecklist.id)
            }
            this.loading_id = null;
        },

        async finalizarMatrizChecklist() {
            const response = await this.finalizarCreacionMatrizChecklist(this.matriz_checklist_id);

            if (this.errors_intervencion_matriz_checklist === null) {
                this.$notyf.success(response.message);
                this.$emit('matrizChecklist-finalizada');
            }
        },

        irACategorias() {
            this.$emit('matrizIntervencionChecklist-volver', { categorias: this.categorias, intervenciones: this.intervenciones });
        }
    }
}
</script>

<style scoped></style>