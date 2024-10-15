<template>
    <div class="modal fade" id="completarCheckListModal" tabindex="-1" aria-labelledby="completarCheckListModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="matrizCheckListModalLabel">Completar CheckList</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <template v-if="completarCheckList && completarCheckList.matriz">
                        <div class="card mb-3 border-card border-checklist">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h6>Tipo Equipo</h6>
                                        <p class="mb-0">{{ completarCheckList.activo.tipo_activo.name }}</p>
                                    </div>
                                    <div class="col">
                                        <h6>Matriz Checklist</h6>
                                        <p class="mb-0">{{ completarCheckList.matriz.nombre }}</p>
                                    </div>
                                    <div class="col">
                                        <h6>Marca</h6>
                                        <p class="mb-0">{{ completarCheckList.marca }}</p>
                                    </div>
                                    <div class="col">
                                        <h6>Modelo</h6>
                                        <p class="mb-0">{{ completarCheckList.modelo }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <ul class="list-group">
                            <template v-for="categoria in completarCheckList.matriz.categorias">
                                <template v-if="categoria.intervenciones.length > 0">
                                    <li
                                        class="list-group-item list-group-item-secondary d-flex justify-content-between align-items-center">
                                        <h5 class="titulo-categoria">{{ categoria.nombre }}</h5>
                                        <h6 class="mb-0">Realizado</h6>
                                    </li>

                                    <template v-for="intervencion in categoria.intervenciones">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>{{ intervencion.nombre }}</span>
                                            <div>
                                                <input class="form-check-input" type="checkbox"
                                                    :id="'intervencion-' + intervencion.id" :value="intervencion.id"
                                                    @change="marcarIntervencion(intervencion)"
                                                    v-model="intervencion.selected">
                                            </div>
                                        </li>
                                    </template>
                                </template>
                            </template>
                        </ul>
                    </template>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" class="btn btn-base-dv" @click="finalizarCheckList(completarCheckList.id)"
                            :disabled="loading_checklist_create">
                            <span v-if="loading_checklist_create">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Cargando...</span>
                            <span v-else><i class="bi bi-clipboard2-check-fill"></i> Finalizar</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import checklistMixin from '../../mixins/checklist/checklistMixin';

export default {
    mixins: [checklistMixin],
    props: {
        completarCheckList: Object
    },
    data() {
        return {
            selectedIntervencion: {
                checklist_id: 0,
                intervenciones: []
            },
        };
    },
    methods: {
        open() {
            this.errors = null;
            const modalElement = document.getElementById('completarCheckListModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('completarCheckListModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },

        volverEditarMatrizCheckList() {
        },

        marcarIntervencion(intervencion) {
            const index = this.selectedIntervencion.intervenciones.findIndex(
                i => i.intervencion_id === intervencion.id
            );
            if (index === -1) {
                this.selectedIntervencion.intervenciones.push({
                    categoria_id: intervencion.matriz_categoria_checklist_id,
                    intervencion_id: intervencion.id
                });
            } else {
                this.selectedIntervencion.intervenciones.splice(index, 1);
            }
        },

        async finalizarCheckList(checklist_id) {
            this.selectedIntervencion.checklist_id = checklist_id

            const response = await this.createIntervencionChecklist(this.selectedIntervencion);

            if (this.errors_intervencion_checklist) {
                this.$notyf.error(this.errors_intervencion_checklist);
            }

            if (this.errors_intervencion_checklist === null) {
                this.$notyf.success(response.message);
                // this.$emit('matrizCategoriaChecklist-creada', response.categoriaMatrizChecklist);
                // this.newCategoriaChecklist.nombre = '';
            }
        }
    }
}
</script>

<style scoped>
.list-group-item-base-dv {
    border-left-color: #fd7e14;
}

.border-checklist {
    border-left-color: #fd7e14;
}

.border-card {
    border-left-width: .25rem;
    border-radius: .25rem;
}

.titulo-categoria {
    margin-bottom: 0;
    white-space: nowrap;
}

.form-check-input {
    width: 1.4em;
    height: 1.4em;
}
</style>