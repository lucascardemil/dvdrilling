<template>
    <div class="modal fade" id="crearTipoActivosModal" tabindex="-1" aria-labelledby="crearTipoActivosModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearTipoActivosModalLabel">Crear Tipo Activo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="saveTipoActivos">
                        <div class="mb-3">
                            <label for="tipoActivosNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="tipoActivosNombre" v-model="newTipoActivos.name"
                                required>
                        </div>
                        <template v-if="errors">
                            <div class="alert alert-danger" role="alert" v-for="tipoActivos in errors.name">
                                {{ tipoActivos }}
                            </div>
                        </template>
                        <button type="submit" class="btn btn-base-dv" :disabled="newTipoActivos.name == ''">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import tipoActivoMixin from '../../mixins/tipoActivo/tipoActivoMixin';

export default {
    mixins: [tipoActivoMixin],
    data() {
        return {
            newTipoActivos: {
                name: '',
            }
        };
    },
    methods: {
        open() {
            this.errors = null;
            const modalElement = document.getElementById('crearTipoActivosModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('crearTipoActivosModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },

        async saveTipoActivos() {
            const response = await this.createTipoActivos(this.newTipoActivos);

            if (this.errors === null) {
                this.$notyf.success(response.message);
                this.$emit('tipo-activos-updated');
                this.newTipoActivos.name = '';
                this.close();
            }
        }
    }
}
</script>

<style scoped></style>
