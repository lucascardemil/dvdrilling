<template>
    <div class="modal fade" id="editAsignarPersonalModal" tabindex="-1" aria-labelledby="editAsignarPersonalModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAsignarPersonalModalLabel"><i class="bi bi-pencil-square"></i>
                        Editar
                        Personal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="editarAsignarPersonal">
                        <div class="mb-3">
                            <select class="form-select" id="selectProyecto" aria-label="Seleccione el proyecto"
                                :class="errors_personal ? errors_personal.proyecto_id ? 'is-invalid' : '' : ''"
                                v-model="editPersonal.proyecto">
                                <option :value="null" disabled>Seleccione el proyecto</option>
                                <template v-for="proyecto in proyectos">
                                    <option :value="proyecto.id">{{ proyecto.name }}</option>
                                </template>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-base-dv" :disabled="editPersonal.proyecto === null">Guardar
                            Cambios</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import asignarPersonalMixin from '../../../mixins/recurso/asignarPersonalMixin';

export default {
    mixins: [asignarPersonalMixin],
    props: {
        recurso: Object,
        proyectos: Array
    },
    data() {
        return {
            editPersonal: {
                id: 0,
                proyecto: null,
            }
        };
    },
    watch: {
        recurso: {
            immediate: true,
            handler(Recurso) {
                if (Recurso) {
                    this.editPersonal.id = Recurso.id
                    this.editPersonal.proyecto = Recurso.proyecto.id;
                }
            }
        }
    },
    methods: {
        open() {
            const modalElement = document.getElementById('editAsignarPersonalModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('editAsignarPersonalModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },
        async editarAsignarPersonal() {
            const response = await this.actualizarAsignarPersonal(this.editPersonal);

            if (this.errors_personal === null) {
                this.$notyf.success(response.message);
                this.$emit('actualizar-personal', response.updated_personal);
                this.close();
            }
        }
    }
}
</script>

<style scoped></style>
