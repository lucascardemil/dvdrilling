<template>
    <div>
        <form @submit.prevent="updateIntervencionChecklist" class="mb-3">
            <div class="row align-items-end">
                <div class="col-lg-8 col-md-12">
                    <label for="intervencionChecklistNombre" class="form-label">Intervencion</label>
                    <input type="text" class="form-control" id="intervencionChecklistNombre"
                        v-model="editIntervencionChecklist.nombre" placeholder="Nombre"
                        :class="errors_intervencion_checklist ? errors_intervencion_checklist.nombre ? 'is-invalid' : '' : ''"
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
        checklist_intervencion: Object
    },
    data() {
        return {
            editIntervencionChecklist: {
                id: this.checklist_intervencion.id,
                nombre: this.checklist_intervencion.nombre,
            },
        };
    },
    methods: {
        async updateIntervencionChecklist() {
            const response = await this.actualizarIntervencionCheckList(this.editIntervencionChecklist);

            if (this.errors_intervencion_checklist === null) {
                this.$notyf.success(response.message);
                this.$emit('intervencionChecklist-actualizada', response.intervencionChecklist);
            }
        },

        volverEditarCheckList() {
            this.$emit('volverEditarChecklist');
        }
    }
}
</script>