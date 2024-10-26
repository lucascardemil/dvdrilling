<template>
    <div>
        <form @submit.prevent="saveCategoriaMatrizChecklist" class="mb-3">
            <div class="row align-items-end">
                <div class="col-lg-8 col-md-12">
                    <label for="categoriaChecklistNombre" class="form-label">Categoria</label>
                    <input type="text" class="form-control" id="categoriaChecklistNombre"
                        v-model="newCategoriaMatrizChecklist.nombre" placeholder="Nombre"
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
        
        <button type="button" class="btn btn-base-dv" @click="volverEditarMatrizCheckList()"><i
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
        matriz_checklist_id: {
            type: Number,
            required: true
        },
    },
    data() {
        return {
            newCategoriaMatrizChecklist: {
                matriz_checklist_id: this.matriz_checklist_id,
                nombre: '',
            },
        };
    },
    methods: {
        async saveCategoriaMatrizChecklist() {
            const response = await this.createCategoriaMatrizChecklist(this.newCategoriaMatrizChecklist);

            if (this.errors_categoria_matriz_checklist === null) {
                this.$notyf.success(response.message);
                this.$emit('categoriaMatrizChecklist-creada', response.categoriaMatrizChecklist);
                this.newCategoriaMatrizChecklist.nombre = '';
            }
        },

        volverEditarMatrizCheckList() {
            this.$emit('volverEditarMatrizChecklist');
        }
    }
}
</script>