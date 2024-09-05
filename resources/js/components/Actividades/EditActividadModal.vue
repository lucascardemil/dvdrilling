<template>
    <div class="modal fade" id="editActividadModal" tabindex="-1" aria-labelledby="editActividadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editActividadModalLabel"><i class="bi bi-pencil-square"></i> Editar Actividad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="editarActividad">
                        <div class="mb-3">
                            <label for="actividadNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="actividadNombre" v-model="editActividad.name"
                                required>
                        </div>
                        <template v-if="errors">
                            <div class="alert alert-danger" role="alert" v-for="actividad in errors.name">
                                {{ actividad }}
                            </div>
                        </template>
                        <button type="submit" class="btn btn-base-dv" :disabled="editActividad.name == ''">Guardar
                            Cambios</button>
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
    props: {
        actividad: Object
    },
    data() {
        return {
            editActividad: {
                name: ''
            }
        };
    },
    watch: {
        actividad: {
            immediate: true,
            handler(Actividad) {
                if (Actividad) {
                    this.editActividad.name = Actividad.name;
                }
            }
        }
    },
    methods: {
        open() {
            this.errors = null;
            this.editActividad.name = '';
            const modalElement = document.getElementById('editActividadModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('editActividadModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },

        async editarActividad() {
            const response = await this.actualizarActividad({
                actividad_id: this.actividad.id,
                name: this.editActividad.name
            });

            if (this.errors === null) {
                this.$notyf.success(response.message);
                this.$emit('actividad-updated');
                this.close();
            }
        }
    }
}
</script>

<style scoped></style>
