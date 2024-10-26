<template>
    <div>
        <div class="modal-header">
            <h5 class="modal-title" id="matrizCheckListModalLabel">Crear Matriz CheckList</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form @submit.prevent="saveMatrizChecklist">
                <div class="mb-3">
                    <label for="matrizChecklistNombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="matrizChecklistNombre"
                        v-model="newMatrizChecklist.nombre"
                        :class="errors_matriz_checklist ? errors_matriz_checklist.nombre ? 'is-invalid' : '' : ''" required>
                </div>

                <button type="submit" class="btn btn-base-dv" :disabled="loading_matriz_create">
                    <span v-if="loading_matriz_create">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Cargando...</span>
                    <span v-else>Guardar Cambios</span>
                </button>
            </form>
        </div>
    </div>
</template>

<script>
import matrizChecklistMixin from '../../mixins/checklist/matrizChecklistMixin';

export default {
    mixins: [matrizChecklistMixin],
    data() {
        return {
            newMatrizChecklist: {
                nombre: '',
            }
        };
    },
    methods: {
        async saveMatrizChecklist() {
            const response = await this.createMatrizChecklist(this.newMatrizChecklist);

            if (this.errors_matriz_checklist === null) {
                this.$emit('matrizChecklist-creada', response.matrizChecklist);
            }
        }
    }
}
</script>

<style scoped></style>