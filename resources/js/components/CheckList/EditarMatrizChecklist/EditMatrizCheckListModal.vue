<template>
    <div>
        <CrearCategoriaMatrizCheckList v-if="mostrarCrearCategoriaMatrizChecklist"
            :matriz_checklist_id="editMatrizChecklistProps.id" @categoriaMatrizChecklist-creada="agregarCategoriaMatrizChecklist"
            @volverEditarMatrizChecklist="volverEditarMatrizCheckList">
        </CrearCategoriaMatrizCheckList>
        <CrearIntervencionMatrizCheckList v-else-if="mostrarCrearIntervencioMatrizChecklist"
            :matriz_checklist_categoria_id="matriz_checklist_categoria_id"
            @intervencionMatrizChecklist-creada="agregarIntervencionMatrizChecklist"
            @volverEditarMatrizChecklist="volverEditarMatrizCheckList">
        </CrearIntervencionMatrizCheckList>

        <EditCategoriaMatrizCheckList v-else-if="mostrarEditarCategoriaMatrizChecklist"
            :matriz_checklist_categoria="matriz_checklist_categoria"
            @categoriaMatrizChecklist-actualizada="actualizarCategoriaMatrizChecklist"
            @volverEditarMatrizChecklist="volverEditarMatrizCheckList">
        </EditCategoriaMatrizCheckList>
        <EditIntervencionMatrizCheckList v-else-if="mostrarEditarIntervencionMatrizChecklist"
            :matriz_checklist_intervencion="matriz_checklist_intervencion"
            @intervencionMatrizChecklist-actualizada="actualizarIntervencionMatrizChecklist"
            @volverEditarMatrizChecklist="volverEditarMatrizCheckList">
        </EditIntervencionMatrizCheckList>

        <template v-else>
            <template v-if="editMatrizChecklistProps && editMatrizChecklistProps.categorias">
                <div class="d-flex justify-content-end mb-3">
                    <button type="button" class="btn btn-base-dv" @click="openCrearCategoriaMatrizChecklist()"><i
                            class="bi bi-plus-circle"></i> Categoria</button>
                </div>
                <ul class="list-group">
                    <template v-for="categoria in editMatrizChecklistProps.categorias">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <h5 class="titulo-categoria">{{ categoria.nombre }}</h5>
                            <div>
                                <button type="button" class="btn btn-base-dv"
                                    @click="openCrearIntervencionMatrizChecklist(categoria.id)"><i
                                        class="bi bi-plus-circle"></i>
                                    Intervencion</button>
                                <button type="button" class="btn btn-warning"
                                    @click="openEditarCategoriaMatrizChecklist(categoria)"><i
                                        class="bi bi-pencil-square"></i></button>
                                <button type="button" class="btn btn-danger"
                                    @click="eliminarCategoriaMatrizCheckList(categoria.id)"><i
                                        class="bi bi-trash"></i></button>
                            </div>
                        </li>
                        <template v-for="intervencion in categoria.intervenciones">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ intervencion.nombre }}</span>
                                <div>
                                    <button type="button" class="btn btn-warning"
                                        @click="openEditarIntervencionMatrizChecklist(intervencion)"><i
                                            class="bi bi-pencil-square"></i></button>
                                    <button type="button" class="btn btn-danger"
                                        @click="eliminarIntervencionMatrizCheckList(intervencion.id)"><i
                                            class="bi bi-trash"></i></button>
                                </div>
                            </li>
                        </template>
                    </template>
                </ul>
            </template>
        </template>
    </div>

</template>

<script>
import CrearCategoriaMatrizCheckList from './CrearCategoriaMatrizCheckList.vue';
import CrearIntervencionMatrizCheckList from './CrearIntervencionMatrizCheckList.vue';
import EditCategoriaMatrizCheckList from './EditCategoriaMatrizCheckList.vue';
import EditIntervencionMatrizCheckList from './EditIntervencionMatrizCheckList.vue';

import matrizChecklistMixin from '../../../mixins/checklist/matrizChecklistMixin';

export default {
    mixins: [matrizChecklistMixin],
    props: {
        editMatrizChecklistProps: Object
    },
    components: {
        CrearCategoriaMatrizCheckList,
        CrearIntervencionMatrizCheckList,
        EditCategoriaMatrizCheckList,
        EditIntervencionMatrizCheckList
    },
    data() {
        return {
            mostrarCrearCategoriaMatrizChecklist: false,
            mostrarCrearIntervencioMatrizChecklist: false,
            mostrarEditarCategoriaMatrizChecklist: false,
            mostrarEditarIntervencionMatrizChecklist: false,
            matriz_checklist_categoria_id: 0,
            matriz_checklist_categoria: null,
            matriz_checklist_intervencion: null,
        };
    },
    methods: {
        openCrearCategoriaMatrizChecklist() {
            this.mostrarCrearCategoriaMatrizChecklist = true;
        },
        openEditarCategoriaMatrizChecklist(categoria) {
            this.mostrarEditarCategoriaMatrizChecklist = true;
            this.matriz_checklist_categoria = categoria;
        },
        openCrearIntervencionMatrizChecklist(categoria_id) {
            this.mostrarCrearIntervencioMatrizChecklist = true;
            this.matriz_checklist_categoria_id = categoria_id;
        },
        openEditarIntervencionMatrizChecklist(intervencion) {
            this.mostrarEditarIntervencionMatrizChecklist = true;
            this.matriz_checklist_intervencion = intervencion;
        },

        volverEditarMatrizCheckList() {
            this.mostrarCrearCategoriaMatrizChecklist = false;
            this.mostrarCrearIntervencioMatrizChecklist = false;
            this.mostrarEditarCategoriaMatrizChecklist = false;
            this.mostrarEditarIntervencionMatrizChecklist = false;
        },

        agregarCategoriaMatrizChecklist(categoria) {
            this.mostrarCrearCategoriaMatrizChecklist = false;
            this.editMatrizChecklistProps.categorias.push(categoria)
        },

        agregarIntervencionMatrizChecklist(intervencion) {
            this.mostrarCrearIntervencioMatrizChecklist = false;
            const categoria = this.editMatrizChecklistProps.categorias.find(categoria => categoria.id === intervencion.matriz_checklist_categoria_id);

            if (!categoria.intervenciones) {
                categoria.intervenciones = [];
            }

            categoria.intervenciones.push(intervencion)
        },

        actualizarCategoriaMatrizChecklist(categoria_actualizada) {
            this.mostrarEditarCategoriaMatrizChecklist = false;
            const categoria = this.editMatrizChecklistProps.categorias.find(categoria => categoria.id === categoria_actualizada.id);
            categoria.nombre = categoria_actualizada.nombre;
        },

        actualizarIntervencionMatrizChecklist(intervencion_actualizada) {
            this.mostrarEditarIntervencionMatrizChecklist = false;
            const categoria = this.editMatrizChecklistProps.categorias.find(categoria => categoria.id === intervencion_actualizada.matriz_checklist_categoria_id);
            const intervencion = categoria.intervenciones.find(intervencion => intervencion.id === intervencion_actualizada.id);
            intervencion.nombre = intervencion_actualizada.nombre;
        },

        async eliminarCategoriaMatrizCheckList(categoria_id) {
            const response = await this.eliminarCategoriaMatrizChecklist(categoria_id);

            if (this.errors_categoria_matriz_checklist === null) {
                this.$notyf.success(response.message);
                this.editMatrizChecklistProps.categorias = this.editMatrizChecklistProps.categorias.filter(categoria => categoria.id !== response.categoriaMatrizChecklist.id);
            }
        },
        async eliminarIntervencionMatrizCheckList(intervencion_id) {
            const response = await this.eliminarIntervencionMatrizChecklist(intervencion_id);

            if (this.errors_intervencion_matriz_checklist === null) {
                this.$notyf.success(response.message);
                const categoria = this.editMatrizChecklistProps.categorias.find(categoria => categoria.id === response.intervencionMatrizChecklist.matriz_checklist_categoria_id);
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