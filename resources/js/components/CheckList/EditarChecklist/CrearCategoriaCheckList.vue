<template>
    <div>
        <form @submit.prevent="saveCategoriaChecklist" class="mb-3">
            <div class="row align-items-end">
                <div class="col-lg-8 col-md-12">
                    <label for="categoriaChecklistNombre" class="form-label">Categoria</label>
                    <input type="text" class="form-control" id="categoriaChecklistNombre"
                        v-model="newCategoriaChecklist.nombre" placeholder="Nombre"
                        :class="errors_categoria_checklist ? errors_categoria_checklist.nombre ? 'is-invalid' : '' : ''"
                        required>
                </div>
                <div class="col-lg-4 col-md-12">
                    <button type="submit" class="btn btn-base-dv w-100" :disabled="loading_checklist_create">
                        <span v-if="loading_checklist_create">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Cargando...</span>
                        <span v-else>Agregar</span>
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
        checklist_id: {
            type: Number,
            required: true
        },
    },
    data() {
        return {
            newCategoriaChecklist: {
                checklist_id: this.checklist_id,
                nombre: '',
            },
        };
    },
    methods: {
        async saveCategoriaChecklist() {
            const response = await this.createCategoriaChecklist(this.newCategoriaChecklist);

            if (this.errors_categoria_checklist === null) {
                this.$notyf.success(response.message);
                this.$emit('categoriaChecklist-creada', response.categoriaChecklist);
                this.newCategoriaChecklist.nombre = '';
            }
        },

        volverEditarCheckList() {
            this.$emit('volverEditarCheckList');
        }
    }
}
</script>