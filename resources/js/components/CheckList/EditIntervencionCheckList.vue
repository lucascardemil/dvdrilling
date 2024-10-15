<template>
    <div>
        <form @submit.prevent="updateIntervencionChecklist" class="mb-3">
            <div class="row align-items-end">
                <div class="col-lg-8 col-md-12">
                    <label for="intervencionChecklistNombre" class="form-label">Intervencion</label>
                    <input type="text" class="form-control" id="intervencionChecklistNombre"
                        v-model="editIntervencionChecklist.nombre" placeholder="Nombre"
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
import checklistMixin from '../../mixins/checklist/checklistMixin';
import matrizChecklistMixin from '../../mixins/checklist/matrizChecklistMixin';

export default {
    mixins: [checklistMixin, matrizChecklistMixin],
    props: {
        matrizChecklist_intervencion: Object
    },
    data() {
        return {
            editIntervencionChecklist: {
                id: this.matrizChecklist_intervencion.id,
                nombre: this.matrizChecklist_intervencion.nombre,
            },
        };
    },
    methods: {
        async updateIntervencionChecklist() {
            const response = await this.actualizarIntervencionMatrizChecklist(this.editIntervencionChecklist);

            if (this.errors_intervencion_matriz_checklist === null) {
                this.$notyf.success(response.message);
                this.$emit('matrizIntervencionChecklist-actualizada', response.intervencionMatrizChecklist);
            }
        },

        volverEditarMatrizCheckList() {
            this.$emit('volverEditarMatrizCheckList');
        }
    }
}
</script>