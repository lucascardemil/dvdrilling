<template>
    <div class="modal fade" id="crearActividadModal" tabindex="-1" aria-labelledby="crearActividadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearActividadModalLabel">Crear Actividad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="saveActividad">
                        <div class="mb-3">
                            <label for="actividadNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="actividadNombre" v-model="newActividad.name"
                                required>
                        </div>
                        <template v-if="errors">
                            <div class="alert alert-danger" role="alert" v-for="actividad in errors.name">
                                {{ actividad }}
                            </div>
                        </template>
                        <button type="submit" class="btn btn-base-dv" :disabled="newActividad.name == ''">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import actividadMixin from '../../mixins/actividad/actividadMixin';

export default {
    mixins: [actividadMixin],
    data() {
        return {
            newActividad: {
                name: '',
            }
        };
    },
    methods: {
        open() {
            this.errors = null;
            const modalElement = document.getElementById('crearActividadModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('crearActividadModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },

        async saveActividad() {
            const response = await this.createActividad(this.newActividad);

            if (this.errors === null) {
                this.$notyf.success(response.message);
                this.$emit('actividad-updated');
                this.newActividad.name = '';
                this.close();
            }
        }
    }
}
</script>

<style scoped></style>
