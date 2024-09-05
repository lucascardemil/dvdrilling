<template>
    <div class="modal fade" id="editProyectoModal" tabindex="-1" aria-labelledby="editProyectoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProyectoModalLabel"><i class="bi bi-pencil-square"></i> Editar Proyecto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="editarProyecto">
                        <div class="mb-3">
                            <label for="proyectoNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="proyectoNombre" v-model="editProyecto.name"
                                required>
                        </div>
                        <template v-if="errors">
                            <div class="alert alert-danger" role="alert" v-for="proyecto in errors.name">
                                {{ proyecto }}
                            </div>
                        </template>
                        <button type="submit" class="btn btn-base-dv" :disabled="editProyecto.name == ''">Guardar
                            Cambios</button>
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
    props: {
        proyecto: Object
    },
    data() {
        return {
            editProyecto: {
                name: ''
            }
        };
    },
    watch: {
        proyecto: {
            immediate: true,
            handler(Proyecto) {
                if (Proyecto) {
                    this.editProyecto.name = Proyecto.name;
                }
            }
        }
    },
    methods: {
        open() {
            this.errors = null;
            this.editProyecto.name = '';
            const modalElement = document.getElementById('editProyectoModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('editProyectoModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },

        async editarProyecto() {
            const response = await this.actualizarProyecto({
                proyecto_id: this.proyecto.id,
                name: this.editProyecto.name
            });

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
