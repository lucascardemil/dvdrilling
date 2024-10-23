<template>
    <div>
        <form @submit.prevent="updateCategoriaChecklist" class="mb-3">
            <div class="row align-items-end">
                <div class="col-lg-8 col-md-12">
                    <label for="categoriaChecklistNombre" class="form-label">Categoria</label>
                    <input type="text" class="form-control" id="categoriaChecklistNombre"
                        v-model="editCategoriaChecklist.nombre" placeholder="Nombre"
                        :class="errors_categoria_checklist ? errors_categoria_checklist.nombre ? 'is-invalid' : '' : ''"
                        required>
                </div>
                <div class="col-lg-4 col-md-12">
                    <button type="submit" class="btn btn-base-dv w-100" :disabled="loading_checklist_update">
                        <span v-if="loading_checklist_update">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Cargando...</span>
                        <span v-else>Editar</span>
                    </button>
                </div>
            </div>
        </form>
        
        <button type="button" class="btn btn-base-dv" @click="volverEditarCheckList()"><i
                class="bi bi-arrow-left"></i>
            Volver
        </button>
    </div>
</template>

<script>
import checklistMixin from '../../../mixins/checklist/checklistMixin';

export default {
    mixins: [checklistMixin],
    props: {
        checklist_categoria: Object
    },
    data() {
        return {
            editCategoriaChecklist: {
                id: this.checklist_categoria.id,
                nombre: this.checklist_categoria.nombre,
            },
        };
    },
    methods: {
        async updateCategoriaChecklist() {
            const response = await this.actualizarCategoriaChecklist(this.editCategoriaChecklist);

            if (this.errors_categoria_checklist === null) {
                this.$notyf.success(response.message);
                this.$emit('categoriaChecklist-actualizada', response.categoriaChecklist);
            }
        },

        volverEditarCheckList() {
            this.$emit('volverEditarChecklist');
        }
    }
}
</script>