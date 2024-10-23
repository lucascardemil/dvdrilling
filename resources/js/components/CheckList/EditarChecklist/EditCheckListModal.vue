<template>
    <div class="modal fade" id="editarCheckListModal" tabindex="-1" aria-labelledby="editarCheckListModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="CheckListModalLabel">Editar CheckList</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <CrearCategoriaCheckList v-if="mostrarCrearCategoriaChecklist" :checklist_id="editChecklistProps.id"
                        @categoriaChecklist-creada="agregarCategoriaChecklist"
                        @volverEditarChecklist="volverEditarCheckList">
                    </CrearCategoriaCheckList>
                    <CrearIntervencionCheckList v-else-if="mostrarCrearIntervencioChecklist"
                        :checklist_categoria_id="checklist_categoria_id"
                        @intervencionChecklist-creada="agregarIntervencionChecklist"
                        @volverEditarChecklist="volverEditarCheckList">
                    </CrearIntervencionCheckList>

                    <EditCategoriaCheckList v-else-if="mostrarEditarCategoriaChecklist"
                        :checklist_categoria="checklist_categoria"
                        @categoriaChecklist-actualizada="actualizarCategoriaChecklist"
                        @volverEditarChecklist="volverEditarCheckList">
                    </EditCategoriaCheckList>
                    <EditIntervencionCheckList v-else-if="mostrarEditarIntervencionChecklist"
                        :checklist_intervencion="checklist_intervencion"
                        @intervencionChecklist-actualizada="actualizarIntervencionChecklist"
                        @volverEditarChecklist="volverEditarCheckList">
                    </EditIntervencionCheckList>

                    <template v-else>
                        <template v-if="editChecklistProps && editChecklistProps.categorias">
                            <div class="d-flex justify-content-end mb-3">
                                <button type="button" class="btn btn-base-dv" @click="openCrearCategoriaCheckList()"><i
                                        class="bi bi-plus-circle"></i> Categoria</button>
                            </div>
                            <ul class="list-group">
                                <template v-for="categoria in editChecklistProps.categorias">
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
                                            <button type="button" class="btn btn-danger"
                                                @click="eliminarCategoriaCheckList(categoria.id)"><i
                                                    class="bi bi-trash"></i></button>
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
                                                    @click="eliminarIntervencionCheckList(intervencion.id)"><i
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
import checklistMixin from '../../../mixins/checklist/checklistMixin';

export default {
    mixins: [checklistMixin],
    props: {
        editChecklistProps: Object
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
            checklist_categoria_id: 0,
            checklist_categoria: null,
            checklist_intervencion: null,
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
            this.checklist_categoria = categoria;
        },
        openCrearIntervencionCheckList(categoria_id) {
            this.mostrarCrearIntervencioChecklist = true;
            this.checklist_categoria_id = categoria_id;
        },
        openEditarIntervencionCheckList(intervencion) {
            this.mostrarEditarIntervencionChecklist = true;
            this.checklist_intervencion = intervencion;
        },

        volverEditarCheckList() {
            this.mostrarCrearCategoriaChecklist = false;
            this.mostrarCrearIntervencioChecklist = false;
            this.mostrarEditarCategoriaChecklist = false;
            this.mostrarEditarIntervencionChecklist = false;
        },

        agregarCategoriaChecklist(categoria) {
            this.mostrarCrearCategoriaChecklist = false;
            this.editChecklistProps.categorias.push(categoria)
        },

        agregarIntervencionChecklist(intervencion) {
            this.mostrarCrearIntervencioChecklist = false;
            const categoria = this.editChecklistProps.categorias.find(categoria => categoria.id === intervencion.checklist_categoria_id);

            if (!categoria.intervenciones) {
                categoria.intervenciones = [];
            }

            categoria.intervenciones.push(intervencion)
        },

        actualizarCategoriaChecklist(categoria_actualizada) {
            this.mostrarEditarCategoriaChecklist = false;
            const categoria = this.editChecklistProps.categorias.find(categoria => categoria.id === categoria_actualizada.id);
            categoria.nombre = categoria_actualizada.nombre;
        },

        actualizarIntervencionChecklist(intervencion_actualizada) {
            this.mostrarEditarIntervencionChecklist = false;
            const categoria = this.editChecklistProps.categorias.find(categoria => categoria.id === intervencion_actualizada.checklist_categoria_id);
            const intervencion = categoria.intervenciones.find(intervencion => intervencion.id === intervencion_actualizada.id);
            intervencion.nombre = intervencion_actualizada.nombre;
        },

        async eliminarCategoriaCheckList(categoria_id) {
            const response = await this.eliminarCategoriaChecklist(categoria_id);

            if (this.errors_categoria_checklist === null) {
                this.$notyf.success(response.message);
                this.editChecklistProps.categorias = this.editChecklistProps.categorias.filter(categoria => categoria.id !== response.categoriaChecklist.id);
            }
        },
        async eliminarIntervencionCheckList(intervencion_id) {
            const response = await this.eliminarIntervencionChecklist(intervencion_id);

            if (this.errors_intervencion_checklist === null) {
                this.$notyf.success(response.message);
                const categoria = this.editChecklistProps.categorias.find(categoria => categoria.id === response.intervencionChecklist.checklist_categoria_id);
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