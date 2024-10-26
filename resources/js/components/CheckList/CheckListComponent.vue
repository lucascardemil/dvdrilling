<template>
    <div>
        <div class="d-flex justify-content-between mb-3">
            <h3>Checklist</h3>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tipo Equipo</th>
                        <th>Matriz Checklist</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(check, index) in checklist" :key="check.id">
                        <th>{{ index + 1 }}</th>
                        <td>{{ check.tipoactivo.name }}</td>
                        <td>{{ check.matriz.nombre }}</td>
                        <td>{{ check.marca }}</td>
                        <td>{{ check.modelo }}</td>
                        <td>
                            <span class="badge rounded-pill bg-primary">{{ check.status === 0 ? 'Realizado' : 'No Realizado' }}</span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-base-dv" @click="openCompletarCheckListModal(check)"><i
                                    class="bi bi-ui-checks"></i></button>

                            <button type="button" class="btn btn-danger" :disabled="loading_pdf[check.id]"
                                @click="downloadPDF(check)">
                                <span v-if="loading_pdf[check.id]">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                </span>
                                <span v-else><i class="bi bi-filetype-pdf"></i></span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <CompletarCheckListModal ref="completarCheckListModal" :completarCheckListProps="completarChecklist"
            :intervenciones="intervenciones" @checklist-completada="checklisCompletada" />
    </div>
</template>

<script>
import checklistMixin from '../../mixins/checklist/checklistMixin';
import tipoActivoMixin from '../../mixins/tipoActivo/tipoActivoMixin';
import usuariosMixin from '../../mixins/usuarios/usuariosMixin';


import CompletarCheckListModal from './CompletarCheckListModal.vue';
import matrizChecklistMixin from '../../mixins/checklist/matrizChecklistMixin';

export default {
    mixins: [checklistMixin, matrizChecklistMixin, tipoActivoMixin, usuariosMixin],
    components: {
        CompletarCheckListModal
    },
    data() {
        return {
            intervenciones: []
        };
    },
    methods: {
        async openCompletarCheckListModal(check) {
            this.$refs.completarCheckListModal.open();
            this.completarChecklist = check;
        },
        checklisCompletada() {
            this.fetchChecklist();
        },
        async downloadPDF(checklist) {
            if (checklist) {
                await this.descargarPDF(checklist);
            }
        },
    },
    created() {
        this.fetchTipoActivosSelect();
        this.fetchMatrizChecklist();
        this.fetchChecklist();
        this.fetchUserRole();
    }
}
</script>

<style scoped></style>