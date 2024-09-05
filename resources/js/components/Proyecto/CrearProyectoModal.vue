<template>
    <div class="modal fade" id="crearProyectoModal" tabindex="-1" aria-labelledby="crearProyectoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearProyectoModalLabel">Crear Proyecto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="saveProyecto">
                        <div class="mb-3">
                            <label for="proyectoNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="proyectoNombre" v-model="newProyecto.name"
                                required>
                        </div>
                        <template v-if="errors">
                            <div class="alert alert-danger" role="alert" v-for="proyecto in errors.name">
                                {{ proyecto }}
                            </div>
                        </template>
                        <button type="submit" class="btn btn-base-dv" :disabled="newProyecto.name == ''">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import proyectoMixin from '../../mixins/proyecto/proyectoMixin';

export default {
    mixins: [proyectoMixin],
    data() {
        return {
            newProyecto: {
                name: '',
            }
        };
    },
    methods: {
        open() {
            this.errors = null;
            const modalElement = document.getElementById('crearProyectoModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('crearProyectoModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },

        async saveProyecto() {
            const response = await this.createProyecto(this.newProyecto);

            if (this.errors === null) {
                this.$notyf.success(response.message);
                this.$emit('proyecto-updated');
                this.close();
            }
        }
    }
}
</script>

<style scoped></style>
