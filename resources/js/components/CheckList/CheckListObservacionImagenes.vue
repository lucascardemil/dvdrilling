<template>
    <div>
        <div v-if="localChecklistObservaciones" class="mb-4">
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <template v-for="observacion in localChecklistObservaciones">
                    <div class="col">
                        <div class="card h-100">
                            <template v-for="imagen in observacion.imagenes">
                                <img :src="formatImage(imagen.imagen)" class="card-img-top"
                                    :alt="observacion.observacion">
                            </template>

                            <div class="sin-imagen" v-if="observacion.imagenes.length === 0">
                                <i class="bi bi-image"></i>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Observacion</h5>
                                <p class="card-text">{{ observacion.observacion }}</p>
                                <button type="button" class="btn btn-danger" v-if="verImagenesObservacionesProp"
                                    :disabled="loading_checklist_delete_observacion[observacion.id]"
                                    @click="deleteObservacionChecklist(observacion.id)">
                                    <span v-if="loading_checklist_delete_observacion[observacion.id]">
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        Cargando...</span>
                                    <span v-else><i class="bi bi-trash"></i>
                                        Eliminar</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        <button type="button" class="btn btn-base-dv" @click="volverCheckListObservacion()"><i
                class="bi bi-arrow-left"></i>
            Volver
        </button>
    </div>
</template>

<script>

import checklistMixin from '../../mixins/checklist/checklistMixin';
import { formatImage } from '../../utils/formatImage';

export default {
    mixins: [checklistMixin],
    components: {},
    props: {
        checklist_observaciones: Array,
        verImagenesObservacionesProp: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            localChecklistObservaciones: [...this.checklist_observaciones]
        };
    },
    watch: {
        checklist_observaciones(nuevaObservacion) {
            this.localChecklistObservaciones = [...nuevaObservacion];
        }
    },
    methods: {
        async deleteObservacionChecklist(observacion_id) {
            const response = await this.eliminarObservacionChecklist(observacion_id);

            if (this.errors_observacion_checklist === null) {
                this.$notyf.success(response.message);
                this.localChecklistObservaciones = this.localChecklistObservaciones.filter(observacion => observacion.id !== response.observacionChecklist.id);
                this.$emit('delete-checkListObservacion', response.observacionChecklist);
            }
        },
        volverCheckListObservacion() {
            this.$emit('volver-checkListObservacion');
        },
        formatImage
    }
}
</script>
<style>
.sin-imagen {
    display: flex;
    width: 100%;
    height: 150px;
    justify-content: center;
    align-items: center;
    border-bottom: 1px solid gainsboro;
    background-color: lightgrey;
}

.sin-imagen i {
    font-size: 50px;
    color: aliceblue;
}
</style>