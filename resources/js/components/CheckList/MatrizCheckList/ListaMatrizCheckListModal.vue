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
                    <VerMatrizCheckListModal :matrizChecklist="matriz" v-if="habilitarVerMatrizChecklist" />
                    <div class="table-responsive" v-else>
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
                                        <button type="button" class="btn btn-success"
                                            @click="verMatrizChecklist(matriz)"><i class="bi bi-file-text-fill"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer" v-if="habilitarVerMatrizChecklist">
                    <button type="button" class="btn btn-base-dv" @click="volverListaMatrizCheckList()"><i
                            class="bi bi-arrow-left"></i> Volver
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import VerMatrizCheckListModal from './VerMatrizCheckListModal';
import matrizChecklistMixin from '../../../mixins/checklist/matrizChecklistMixin';
export default {
    mixins: [matrizChecklistMixin],
    props: {
        matrizChecklistProps: Array,
    },
    components: {
        VerMatrizCheckListModal
    },
    data() {
        return {
            matriz: null,
            habilitarVerMatrizChecklist: false
        };
    },
    methods: {
        open() {
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

        verMatrizChecklist(matriz) {
            this.habilitarVerMatrizChecklist = true;
            this.matriz = matriz;
        },

        volverListaMatrizCheckList(){
            this.habilitarVerMatrizChecklist = false;
        }

    }
}
</script>