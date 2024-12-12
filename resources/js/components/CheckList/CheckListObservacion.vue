<template>
    <div>
        <form @submit.prevent="saveObservacionChecklist">
            <div class="mb-3">
                <label for="observacion" class="form-label">Observacion</label>
                <textarea class="form-control" id="observacion" v-model="newObservacion.observacion"
                    :class="errors_observacion_checklist ? errors_observacion_checklist.detalle ? 'is-invalid' : '' : ''"
                    rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <input type="file" class="form-control" id="imagenObservacion" @change="handleFileChange"
                    accept=".png, .jpeg, .jpg" ref="imagenObservacion"
                    :class="errors_observacion_checklist ? errors_observacion_checklist.imagen ? 'is-invalid' : '' : ''"
                    aria-label="Imagen">
            </div>

            <div class="d-flex justify-content-between mt-3">
                <button type="button" class="btn btn-base-dv" @click="volverCompletarCheckList()"><i
                        class="bi bi-arrow-left"></i> Volver
                </button>
                <div>
                    <button type="submit" class="btn btn-base-dv" :disabled="loading_checklist_observacion">
                        <span v-if="loading_checklist_observacion">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Cargando...</span>
                        <span v-else>Guardar Cambios</span>
                    </button>
                </div>
            </div>
        </form>

        <div v-if="checklist_observaciones.length > 0" class="my-4">
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <template v-for="observacion in checklist_observaciones">
                    <template
                        v-if="observacion.checklist_intervencion_id === newObservacion.checklist_intervencion_id && observacion.matriz_id === newObservacion.matriz_id">
                        <div class="col">
                            <div class="card h-100">
                                <template v-if="observacion.imagen_observacion">
                                    <img :src="mostrarImagenObservacion(observacion.imagen_observacion)"
                                        class="card-img-top" :alt="observacion.observacion">
                                </template>

                                <div class="sin-imagen" v-if="!observacion.imagen_observacion">
                                    <i class="bi bi-image"></i>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Observacion</h5>
                                    <p class="card-text">{{ observacion.observacion }}</p>
                                    <button type="button" class="btn btn-danger"
                                        :disabled="loading_checklist_delete_observacion[observacion.id]"
                                        @click="deleteObservacionChecklist(observacion.checklist_intervencion_id, observacion.matriz_id)">
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
                </template>
            </div>
        </div>
    </div>
</template>

<script>

import checklistMixin from '../../mixins/checklist/checklistMixin';
import { redimensionarImagen } from '../../utils/redimensionarImagen';

export default {
    mixins: [checklistMixin],
    props: {
        checklist_agregar_observacion_props: Object,
        checklist_devolver_observaciones_props: Array
    },
    data() {
        return {
            newObservacion: {
                checklist_intervencion_id: this.checklist_agregar_observacion_props.intervencion_id,
                matriz_id: this.checklist_agregar_observacion_props.matriz_id,
                observacion: '',
                imagen_observacion: null
            },
            checklist_observaciones: [],
        };
    },
    watch: {
        checklist_devolver_observaciones_props: {
            immediate: true,
            handler(checklist_devolver_observaciones_props) {
                if (checklist_devolver_observaciones_props) {
                    checklist_devolver_observaciones_props.forEach(observacion => {
                        this.checklist_observaciones.push(observacion);
                    });
                }
            }
        }
    },
    methods: {
        async handleFileChange(event) {
            const file = event.target.files[0];
            this.errors = null;

            try {
                const resizedImage = await Promise.resolve(this.redimensionarImagen(file));
                this.newObservacion.imagen_observacion = resizedImage;
            } catch (error) {
                this.errors = { imagenes: [error.message] };
                console.error('Error al procesar archivos:', error);
            }
        },
        volverCompletarCheckList() {
            this.$emit('volver-completarCheckList', this.checklist_observaciones);
        },
        eliminarCheckListObservacion(observacionChecklist) {
            this.$emit('delete-checkListObservacionCompletar', observacionChecklist);
        },
        saveObservacionChecklist() {
            // Crear una copia del objeto para evitar referencias
            const observacionCopia = { ...this.newObservacion };

            // Emitir el evento con los datos
            this.$emit('create-checkListObservacionCompletar', observacionCopia);

            // Agregar la copia al array
            this.checklist_observaciones.push(observacionCopia);

            // Limpiar los campos sin afectar los datos guardados
            this.limpiarCampos();
        },
        deleteObservacionChecklist(checklist_intervencion_id, matriz_id) {
            this.checklist_observaciones = this.checklist_observaciones.filter(observacion =>
                !(observacion.checklist_intervencion_id === checklist_intervencion_id && observacion.matriz_id === matriz_id)
            );
        },
        limpiarCampos() {
            this.newObservacion.observacion = '';
            this.newObservacion.imagen_observacion = null;
            this.$refs.imagenObservacion.value = '';
        },
        mostrarImagenObservacion(imagen) {
            return URL.createObjectURL(imagen);
        },
        redimensionarImagen
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