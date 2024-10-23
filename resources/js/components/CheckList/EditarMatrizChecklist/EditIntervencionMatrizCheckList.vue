<template>
    <div>
        <form @submit.prevent="updateIntervencionMatrizChecklist" class="mb-3">
            <div class="row align-items-end">
                <div class="col-lg-8 col-md-12">
                    <label for="intervencionMatrizChecklistNombre" class="form-label">Intervencion</label>
                    <input type="text" class="form-control" id="intervencionMatrizChecklistNombre"
                        v-model="editIntervencionMatrizChecklist.nombre" placeholder="Nombre"
                        :class="errors_intervencion_matriz_checklist ? errors_intervencion_matriz_checklist.nombre ? 'is-invalid' : '' : ''"
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
        matriz_checklist_intervencion: Object
    },
    data() {
        return {
            editIntervencionMatrizChecklist: {
                id: this.matriz_checklist_intervencion.id,
                nombre: this.matriz_checklist_intervencion.nombre,
            },
        };
    },
    methods: {
        async updateIntervencionMatrizChecklist() {
            const response = await this.actualizarIntervencionMatrizChecklist(this.editIntervencionMatrizChecklist);

            if (this.errors_intervencion_matriz_checklist === null) {
                this.$notyf.success(response.message);
                this.$emit('intervencionMatrizChecklist-actualizada', response.intervencionMatrizChecklist);
            }
        },

        volverEditarMatrizCheckList() {
            this.$emit('volverEditarMatrizChecklist');
        }
    }
}
</script>