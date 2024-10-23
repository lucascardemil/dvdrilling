<template>
    <div>
        <form @submit.prevent="updateMatrizChecklistCategoria" class="mb-3">
            <div class="row align-items-end">
                <div class="col-lg-8 col-md-12">
                    <label for="categoriaMatrizChecklistNombre" class="form-label">Categoria</label>
                    <input type="text" class="form-control" id="categoriaMatrizChecklistNombre"
                        v-model="editMatrizChecklistCategoria.nombre" placeholder="Nombre"
                        :class="errors_categoria_matriz_checklist ? errors_categoria_matriz_checklist.nombre ? 'is-invalid' : '' : ''"
                        required>
                </div>
                <div class="col-lg-4 col-md-12">
                    <button type="submit" class="btn btn-base-dv w-100" :disabled="loading_matriz_update">
                        <span v-if="loading_matriz_update">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Cargando...</span>
                        <span v-else>Editar</span>
                    </button>
                </div>
            </div>
        </form>
        
        <button type="button" class="btn btn-base-dv" @click="volverEditarMatrizChecklist()"><i
                class="bi bi-arrow-left"></i>
            Volver
        </button>
    </div>
</template>

<script>
import matrizChecklistMixin from '../../../mixins/checklist/matrizChecklistMixin';

export default {
    mixins: [matrizChecklistMixin],
    props: {
        matriz_checklist_categoria: Object
    },
    data() {
        return {
            editMatrizChecklistCategoria: {
                id: this.matriz_checklist_categoria.id,
                nombre: this.matriz_checklist_categoria.nombre,
            },
        };
    },
    methods: {
        async updateMatrizChecklistCategoria() {
            const response = await this.actualizarCategoriaMatrizChecklist(this.editMatrizChecklistCategoria);

            if (this.errors_categoria_matriz_checklist === null) {
                this.$notyf.success(response.message);
                this.$emit('categoriaMatrizChecklist-actualizada', response.categoriaMatrizChecklist);
            }
        },

        volverEditarMatrizChecklist() {
            this.$emit('volverEditarMatrizChecklist');
        }
    }
}
</script>