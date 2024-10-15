<template>
    <div class="modal fade" id="matrizCheckListModal" tabindex="-1" aria-labelledby="matrizCheckListModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <CrearMatrizCheckList @matrizChecklist-creada="matrizChecklistCreada"
                    v-if="componenteMatrizChecklist" />

                <CrearCategoriaMatrizCheckList @matrizCategoriaChecklist-creada="matrizCategoriaChecklistCreada"
                    v-else-if="componenteCategoriaChecklist" :matrizChecklist_id="matrizChecklist_id"
                    :matrizChecklist_categorias="matrizChecklist_categorias" />
                    
                <CrearIntervencionMatrizCheckList
                    @matrizIntervencionChecklist-volver="matrizIntervencionChecklistVolver" @matrizChecklist-finalizada="finalizarMatrizChecklist"
                    v-else-if="componenteIntervencionChecklist" :matrizChecklist_categorias="matrizChecklist_categorias"
                    :matrizChecklist_intervenciones="matrizChecklist_intervenciones" :matrizChecklist_id="matrizChecklist_id"/>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import CrearMatrizCheckList from './CrearMatrizCheckList.vue';
import CrearCategoriaMatrizCheckList from './CrearCategoriaMatrizCheckList.vue'
import CrearIntervencionMatrizCheckList from './CrearIntervencionMatrizCheckList.vue';

export default {
    mixins: [],
    components: {
        CrearMatrizCheckList,
        CrearCategoriaMatrizCheckList,
        CrearIntervencionMatrizCheckList
    },
    data() {
        return {
            componenteMatrizChecklist: true,
            componenteCategoriaChecklist: false,
            componenteIntervencionChecklist: false,

            matrizChecklist_id: 0,
            matrizChecklist_categorias: [],
            matrizChecklist_intervenciones: []
        };
    },
    methods: {
        open() {
            this.errors = null;
            const modalElement = document.getElementById('matrizCheckListModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('matrizCheckListModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },

        matrizChecklistCreada(matrizChecklist) {
            if (matrizChecklist) {
                this.componenteMatrizChecklist = false
                this.componenteCategoriaChecklist = true
                this.matrizChecklist_id = matrizChecklist.id
            }
        },

        matrizCategoriaChecklistCreada(matrizCategoriaChecklist) {
            if (matrizCategoriaChecklist) {
                this.componenteCategoriaChecklist = false
                this.componenteIntervencionChecklist = true
                this.matrizChecklist_categorias = matrizCategoriaChecklist
            }
        },

        matrizIntervencionChecklistVolver(matrizCategoriaChecklist) {
            this.componenteCategoriaChecklist = true
            this.componenteIntervencionChecklist = false
            this.matrizChecklist_categorias = matrizCategoriaChecklist.categorias
            this.matrizChecklist_intervenciones = matrizCategoriaChecklist.intervenciones
        },

        finalizarMatrizChecklist(){
            this.close();
        }
    }
}
</script>

<style scoped></style>