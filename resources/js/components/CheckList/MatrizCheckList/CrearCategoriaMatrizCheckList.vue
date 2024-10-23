<template>
    <div>
        <div class="modal-header">
            <h5 class="modal-title" id="matrizCheckListModalLabel">Crear Categoria Matriz CheckList</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form @submit.prevent="saveCategoriaMatrizChecklist">
                <div class="row align-items-end">
                    <div class="col-lg-8 col-md-12">
                        <label for="categoriaMatrizChecklistNombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="categoriaMatrizChecklistNombre"
                            v-model="newCategoriaMatrizChecklist.nombre"
                            :class="errors_categoria_matriz_checklist ? errors_categoria_matriz_checklist.nombre ? 'is-invalid' : '' : ''"
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
                            <th>Nombre</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(categoria, index) in categorias" :key="categoria.id">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ categoria.nombre }}</td>
                            <td class="text-end">
                                <button type="button" class="btn btn-danger" :disabled="loading_matriz_delete && loading_id === categoria.id"
                                    @click="deleteCategoriaMatrizChecklist(categoria.id)">
                                    <span v-if="loading_matriz_delete && loading_id === categoria.id">
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
            <button type="button" class="btn btn-base-dv" :disabled="categorias.length === 0"
                @click="irAIntervenciones()">Siguiente <i class="bi bi-arrow-right"></i></button>
        </div>
    </div>
</template>

<script>
import matrizChecklistMixin from '../../../mixins/checklist/matrizChecklistMixin';

export default {
    mixins: [matrizChecklistMixin],
    props: {
        matriz_checklist_id: {
            type: Number,
            required: true
        },
        matrizChecklist_categorias: Array
    },
    data() {
        return {
            newCategoriaMatrizChecklist: {
                matriz_checklist_id: this.matriz_checklist_id,
                nombre: '',
            },
            categorias: this.matrizChecklist_categorias
        };
    },
    methods: {
        async saveCategoriaMatrizChecklist() {
            const response = await this.createCategoriaMatrizChecklist(this.newCategoriaMatrizChecklist);

            if (this.errors_categoria_matriz_checklist === null) {
                this.categorias.push(response.categoriaMatrizChecklist);
                this.newCategoriaMatrizChecklist.nombre = '';
            }
        },

        async deleteCategoriaMatrizChecklist(id) {
            this.loading_id = id;

            const response = await this.eliminarCategoriaMatrizChecklist(id);

            if (this.errors_categoria_matriz_checklist === null) {
                this.categorias = this.categorias.filter(categoria => categoria.id !== response.categoriaMatrizChecklist.id)
            }

            this.loading_id = null;
        },

        irAIntervenciones() {
            this.$emit('matrizCategoriaChecklist-creada', this.categorias);
        }
    }
}
</script>

<style scoped></style>