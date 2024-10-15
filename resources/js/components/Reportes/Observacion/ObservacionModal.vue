<template>
    <div class="modal fade" id="observacionModal" tabindex="-1" aria-labelledby="observacionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="observacionModalLabel">Observaciones</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <form @submit.prevent="crearObservacion">
                                <div class="mb-3">
                                    <textarea class="form-control" id="observacionObservacion"
                                        v-model="newObservacion.observacion" rows="5" cols="50" 
                                        :class="errors_observacion ? errors_observacion.observacion ? 'is-invalid' : '' : ''"
                                        required></textarea>
                                </div>

                                <button type="submit" class="btn btn-base-dv" :disabled="loading_create">
                                    <span v-if="loading_create">
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        Cargando...</span>
                                    <span v-else>Guardar Cambios</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import observacionMixin from '../../../mixins/reporte/observacionMixin';

export default {
    mixins: [observacionMixin],
    props: {
        reporte: Object,
    },
    data() {
        return {
            newObservacion: {
                observacion: "",
                reporte_id: 0
            },
        };
    },
    watch: {
        reporte: {
            immediate: true,
            handler(Reporte) {
                if (Reporte) {
                    this.newObservacion.reporte_id = Reporte.id;
                    this.observacion = Reporte.observacion;

                    Reporte.observacion.forEach(observacion => {
                        this.newObservacion.observacion = observacion.observacion;
                    });

                }
            }
        },
    },
    methods: {
        open() {
            this.resetForm();
            const modalElement = document.getElementById('observacionModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('observacionModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },
        async crearObservacion() {
            const response = await this.createObservacion(this.newObservacion);

            if (this.errors_observacion === null) {
                this.observacion.push(response.observacion);
                this.$notyf.success(response.message);
            }
        },
        resetForm() {
            this.newObservacion.observacion = ""
        }
    }
}
</script>

<style scoped></style>
