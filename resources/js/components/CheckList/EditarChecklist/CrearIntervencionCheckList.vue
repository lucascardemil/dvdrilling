<template>
    <div>
        <form @submit.prevent="saveIntervencionChecklist" class="mb-3">
            <div class="row align-items-end">
                <div class="col-lg-8 col-md-12">
                    <label for="intervencionChecklistNombre" class="form-label">Intervencion</label>
                    <input type="text" class="form-control" id="intervencionChecklistNombre"
                        v-model="newIntervencionChecklist.nombre" placeholder="Nombre"
                        :class="errors_intervencion_checklist ? errors_intervencion_checklist.nombre ? 'is-invalid' : '' : ''"
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
        
        <button type="button" class="btn btn-base-dv" @click="volverEditarChecklist()"><i
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
        checklist_categoria_id: {
            type: Number,
            required: true
        },
    },
    data() {
        return {
            newIntervencionChecklist: {
                checklist_categoria_id: this.checklist_categoria_id,
                nombre: '',
            },
        };
    },
    methods: {
        async saveIntervencionChecklist() {
            const response = await this.createIntervencionChecklist(this.newIntervencionChecklist);

            if (this.errors_intervencion_checklist === null) {
                this.$notyf.success(response.message);
                this.$emit('intervencionChecklist-creada', response.intervencionChecklist);
                this.newIntervencionChecklist.nombre = '';
            }
        },

        volverEditarChecklist() {
            this.$emit('volverEditarChecklist');
        }
    }
}
</script>