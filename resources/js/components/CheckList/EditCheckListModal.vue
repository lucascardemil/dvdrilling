<template>
    <div class="modal fade" id="editarCheckListModal" tabindex="-1" aria-labelledby="editarCheckListModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="matrizCheckListModalLabel">Editar Matriz CheckList</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <CrearCategoriaCheckList v-if="mostrarCrearCategoriaChecklist"
                        :matriz_checklist_id="editMatrizChecklistProps.id"
                        @matrizCategoriaChecklist-creada="agregarCategoriaMatrizChecklist"
                        @volverEditarMatrizCheckList="volverEditarMatrizCheckList">
                    </CrearCategoriaCheckList>
                    <CrearIntervencionCheckList v-else-if="mostrarCrearIntervencioChecklist"
                        :matrizChecklist_categoria_id="matrizChecklist_categoria_id"
                        @matrizIntervencionChecklist-creada="agregarIntervencionMatrizChecklist"
                        @volverEditarMatrizCheckList="volverEditarMatrizCheckList">
                    </CrearIntervencionCheckList>

                    <EditCategoriaCheckList v-else-if="mostrarEditarCategoriaChecklist"
                        :matrizChecklist_categoria="matrizChecklist_categoria"
                        @matrizCategoriaChecklist-actualizada="actualizarCategoriaMatrizChecklist"
                        @volverEditarMatrizCheckList="volverEditarMatrizCheckList">
                    </EditCategoriaCheckList>
                    <EditIntervencionCheckList v-else-if="mostrarEditarIntervencionChecklist"
                        :matrizChecklist_intervencion="matrizChecklist_intervencion"
                        @matrizIntervencionChecklist-actualizada="actualizarIntervencionMatrizChecklist"
                        @volverEditarMatrizCheckList="volverEditarMatrizCheckList">
                    </EditIntervencionCheckList>

                    <template v-else>
                        <template v-if="editMatrizChecklistProps && editMatrizChecklistProps.categorias">
                            <div class="d-flex justify-content-end mb-3">
                                <button type="button" class="btn btn-base-dv" @click="openCrearCategoriaCheckList()"><i
                                        class="bi bi-plus-circle"></i> Categoria</button>
                            </div>
                            <ul class="list-group">
                                <template v-for="categoria in editMatrizChecklistProps.categorias">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <h5 class="titulo-categoria">{{ categoria.nombre }}</h5>
                                        <div>
                                            <button type="button" class="btn btn-base-dv"
                                                @click="openCrearIntervencionCheckList(categoria.id)"><i
                                                    class="bi bi-plus-circle"></i>
                                                Intervencion</button>
                                            <button type="button" class="btn btn-warning"
                                                @click="openEditarCategoriaCheckList(categoria)"><i
                                                    class="bi bi-pencil-square"></i></button>
                                        </div>
                                    </li>
                                    <template v-for="intervencion in categoria.intervenciones">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>{{ intervencion.nombre }}</span>
                                            <div>
                                                <button type="button" class="btn btn-warning"
                                                    @click="openEditarIntervencionCheckList(intervencion)"><i
                                                        class="bi bi-pencil-square"></i></button>
                                                <button type="button" class="btn btn-danger"
                                                    @click="eliminarInternvecionCheckList(intervencion.id)"><i
                                                        class="bi bi-trash"></i></button>
                                            </div>
                                        </li>
                                    </template>
                                </template>
                            </ul>
                        </template>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import CrearCategoriaCheckList from './CrearCategoriaCheckList.vue';
import CrearIntervencionCheckList from './CrearIntervencionCheckList.vue';
import EditCategoriaCheckList from './EditCategoriaCheckList.vue';
import EditIntervencionCheckList from './EditIntervencionCheckList.vue';
import matrizChecklistMixin from '../../mixins/checklist/matrizChecklistMixin';

export default {
    mixins: [matrizChecklistMixin],
    props: {
        editMatrizChecklistProps: Object
    },
    components: {
        CrearCategoriaCheckList,
        CrearIntervencionCheckList,
        EditCategoriaCheckList,
        EditIntervencionCheckList
    },
    data() {
        return {
            mostrarCrearCategoriaChecklist: false,
            mostrarCrearIntervencioChecklist: false,
            mostrarEditarCategoriaChecklist: false,
            mostrarEditarIntervencionChecklist: false,
            matrizChecklist_categoria_id: 0,
            matrizChecklist_categoria: null,
            matrizChecklist_intervencion: null,
        };
    },
    methods: {
        open() {
            this.errors = null;
            const modalElement = document.getElementById('editarCheckListModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('editarCheckListModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },

        openCrearCategoriaCheckList() {
            this.mostrarCrearCategoriaChecklist = true;
        },
        openEditarCategoriaCheckList(categoria) {
            this.mostrarEditarCategoriaChecklist = true;
            this.matrizChecklist_categoria = categoria;
        },
        openCrearIntervencionCheckList(categoria_id) {
            this.mostrarCrearIntervencioChecklist = true;
            this.matrizChecklist_categoria_id = categoria_id;
        },
        openEditarIntervencionCheckList(intervencion) {
            this.mostrarEditarIntervencionChecklist = true;
            this.matrizChecklist_intervencion = intervencion;
        },

        volverEditarMatrizCheckList() {
            this.mostrarCrearCategoriaChecklist = false;
            this.mostrarCrearIntervencioChecklist = false;
            this.mostrarEditarCategoriaChecklist = false;
            this.mostrarEditarIntervencionChecklist = false;
        },

        agregarCategoriaMatrizChecklist(categoria) {
            this.mostrarCrearCategoriaChecklist = false;
            this.editMatrizChecklistProps.categorias.push(categoria)
        },

        agregarIntervencionMatrizChecklist(intervencion) {
            this.mostrarCrearIntervencioChecklist = false;
            const categoria = this.editMatrizChecklistProps.categorias.find(categoria => categoria.id === intervencion.matriz_categoria_checklist_id);

            if (!categoria.intervenciones) {
                categoria.intervenciones = [];
            }

            categoria.intervenciones.push(intervencion)
        },

        actualizarCategoriaMatrizChecklist(categoria_actualizada) {
            this.mostrarEditarCategoriaChecklist = false;
            const categoria = this.editMatrizChecklistProps.categorias.find(categoria => categoria.id === categoria_actualizada.id);
            categoria.nombre = categoria_actualizada.nombre;
        },

        actualizarIntervencionMatrizChecklist(intervencion_actualizada) {
            this.mostrarEditarIntervencionChecklist = false;
            const categoria = this.editMatrizChecklistProps.categorias.find(categoria => categoria.id === intervencion_actualizada.matriz_categoria_checklist_id);
            const intervencion = categoria.intervenciones.find(intervencion => intervencion.id === intervencion_actualizada.id);
            intervencion.nombre = intervencion_actualizada.nombre;
        },

        async eliminarInternvecionCheckList(intervencion_id) {
            const response = await this.eliminarIntervencionMatrizChecklist(intervencion_id);

            if (this.errors_categoria_matriz_checklist === null) {
                this.$notyf.success(response.message);
                const categoria = this.editMatrizChecklistProps.categorias.find(categoria => categoria.id === response.intervencionMatrizChecklist.matriz_categoria_checklist_id);
                categoria.intervenciones = categoria.intervenciones.filter(intervencion => intervencion.id !== intervencion_id);
            }
        }
    }
}
</script>

<style scoped>
.titulo-categoria {
    margin-bottom: 0;
    color: #6c757d;
    white-space: nowrap;
}
</style>