<template>
    <div>
        <CheckListObservacionImagenes v-if="mostrarObservacionesImagenes"
            :checklist_observaciones="checklist_observaciones"
            @delete-checkListObservacion="eliminarCheckListObservacion"
            @volver-checkListObservacion="volverCheckListObservacion"
            :verImagenesObservacionesProp="verImagenesObservaciones"></CheckListObservacionImagenes>
        <div v-else>
            <form @submit.prevent="saveObservacionChecklist">
                <div class="mb-3">
                    <label for="observacion" class="form-label">Observacion</label>
                    <textarea class="form-control" id="observacion" v-model="newObservacion.observacion"
                        :class="errors_observacion_checklist ? errors_observacion_checklist.detalle ? 'is-invalid' : '' : ''"
                        rows="5" required></textarea>
                </div>
                <div class="mb-3">
                    <input type="file"  class="form-control" id="imagenObservacion" @change="handleFileChange"
                        accept=".png, .jpeg, .jpg" ref="imagenObservacion"
                        :class="errors_observacion_checklist ? errors_observacion_checklist.imagen ? 'is-invalid' : '' : ''"
                        aria-label="Imagen">
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <button type="button" class="btn btn-base-dv" @click="volverCompletarCheckList()"><i
                            class="bi bi-arrow-left"></i> Volver
                    </button>
                    <div>
                        <button class="btn btn-primary me-2" type="button"
                            @click="verObservacionesImagenes(checklist_intervencionProps.observaciones)"
                            v-if="checklist_intervencionProps.observaciones">
                            <i class="bi bi-image"></i> Imagenes
                        </button>
                        <button type="submit" class="btn btn-base-dv" :disabled="loading_checklist_observacion">
                            <span v-if="loading_checklist_observacion">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Cargando...</span>
                            <span v-else>Guardar Cambios</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>

import checklistMixin from '../../mixins/checklist/checklistMixin';
import CheckListObservacionImagenes from './CheckListObservacionImagenes.vue';
import { redimensionarImagen } from '../../utils/redimensionarImagen';

export default {
    mixins: [checklistMixin],
    components: { CheckListObservacionImagenes },
    props: {
        checklist_intervencionProps: Object
    },
    data() {
        return {
            newObservacion: {
                checklist_intervencion_id: this.checklist_intervencionProps.id,
                observacion: '',
                imagen: null
            },
            mostrarObservacionesImagenes: false,
            checklist_observaciones: [],
            verImagenesObservaciones: true
        };
    },
    watch: {

    },
    methods: {
        verObservacionesImagenes(observaciones) {
            this.mostrarObservacionesImagenes = true;
            this.checklist_observaciones = observaciones
        },
        async handleFileChange(event) {
            const file = event.target.files[0];
            this.errors = null;

            try {
                const resizedImage = await Promise.resolve(this.redimensionarImagen(file));
                this.newObservacion.imagen = resizedImage;
            } catch (error) {
                this.errors = { imagenes: [error.message] };
                console.error('Error al procesar archivos:', error);
            }
        },
        volverCheckListObservacion() {
            this.mostrarObservacionesImagenes = false;
        },
        volverCompletarCheckList() {
            this.$emit('volver-completarCheckList');
        },
        eliminarCheckListObservacion(observacionChecklist) {
            this.$emit('delete-checkListObservacionCompletar', observacionChecklist);
        },
        async saveObservacionChecklist() {

            const formData = new FormData();
            formData.append('observacion', this.newObservacion.observacion);
            formData.append('checklist_intervencion_id', this.newObservacion.checklist_intervencion_id);

            if (this.newObservacion.imagen) {
                formData.append('imagen', this.newObservacion.imagen);
            }

            const response = await this.createObservacionChecklist(formData);

            if (this.errors_observacion_checklist === null) {
                this.$notyf.success(response.message);
                this.checklist_intervencionProps.observaciones.push(response.observacionChecklist);
                this.limpiarCampos();
            }
        },
        limpiarCampos() {
            this.newObservacion.observacion = '';
            this.newObservacion.imagen = null;
            this.$refs.imagenObservacion.value = '';
        },
        redimensionarImagen
    }
}
</script>