 <template>
    <div class="modal fade" id="listaMatrizCheckListModal" tabindex="-1"
        aria-labelledby="listaMatrizCheckListModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="matrizCheckListModalLabel">Ver Matriz CheckList</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <EditMatrizCheckListModal :editMatrizChecklistProps="matrizChecklist" v-if="habilitarEditMatrizChecklist"/>
                    <div class="table-responsive" v-else-if="matrizChecklistProps.length > 0">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Habilitar Matriz</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(matriz, index) in matrizChecklistProps" :key="matriz.id">
                                    <th>{{ index + 1 }}</th>
                                    <td class="text-center">{{ matriz.nombre }}</td>
                                    <td>
                                        <div class="form-check form-switch d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                :id="matriz.id" v-model="matriz.status"
                                                @change="handleEnabledChange(matriz.id, matriz.status)">
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-warning"
                                            @click="editMatrizChecklist(matriz)"><i class="bi bi-pencil-square"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <p v-else>No hay matriz checklist.</p>
                </div>
                <div class="modal-footer" v-if="habilitarEditMatrizChecklist">
                    <button type="button" class="btn btn-base-dv" @click="volverListaMatrizCheckList()"><i
                            class="bi bi-arrow-left"></i> Volver a Lista Matriz 
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import EditMatrizCheckListModal from './EditarMatrizChecklist/EditMatrizCheckListModal.vue';
import matrizChecklistMixin from '../../mixins/checklist/matrizChecklistMixin';

export default {
    mixins: [matrizChecklistMixin],
    props: {
        matrizChecklistProps: Array,
    },
    components: {
        EditMatrizCheckListModal
    },
    data() {
        return {
            matrizChecklist: null,
            habilitarEditMatrizChecklist: false
        };
    },
    methods: {
        open() {
            this.habilitarEditMatrizChecklist = false;
            this.errors = null;
            const modalElement = document.getElementById('listaMatrizCheckListModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('listaMatrizCheckListModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();            
        },

        async handleEnabledChange(matrizId, status) {
            const checkboxStatus = status ? 1 : 0;
            const checkbox = { matriz_id: matrizId, status: checkboxStatus };

            try {
                const response = await this.actualizarStatusMatrizChecklist(checkbox);
                if (this.errors_matriz_checklist === null) {
                    this.$notyf.success(response.message);
                }
            } catch (error) {
                console.error('Error actualizando el estado:', error);
            }
        },

        editMatrizChecklist(matrizChecklist) {
            this.habilitarEditMatrizChecklist = true;
            this.matrizChecklist = matrizChecklist;
        },

        volverListaMatrizCheckList(){
            this.habilitarEditMatrizChecklist = false;
        },
    },
}
</script>