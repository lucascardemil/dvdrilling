<template>
    <div class="modal fade" id="editAsignarActivoModal" tabindex="-1" aria-labelledby="editAsignarActivoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAsignarActivoModalLabel"><i class="bi bi-pencil-square"></i>
                        Editar
                        Activo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="editarAsignarActivo">
                        <div class="mb-3">
                            <select class="form-select" aria-label="Seleccione el proyecto"
                                :class="errors_activo ? errors_activo.proyecto_id ? 'is-invalid' : '' : ''"
                                v-model="editActivo.proyecto">
                                <option :value="null" disabled>Seleccione el proyecto</option>
                                <template v-for="proyecto in proyectos">
                                    <option :value="proyecto.id">{{ proyecto.name }}</option>
                                </template>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-base-dv" :disabled="editActivo.proyecto === null">Guardar
                            Cambios</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import asignarActivoMixin from '../../../mixins/recurso/asignarActivoMixin';

export default {
    mixins: [asignarActivoMixin],
    props: {
        recurso: Object,
        proyectos: Array
    },
    data() {
        return {
            editActivo: {
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
                    this.editActivo.id = Recurso.id
                    this.editActivo.proyecto = Recurso.proyecto.id;
                }
            }
        }
    },
    methods: {
        open() {
            const modalElement = document.getElementById('editAsignarActivoModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('editAsignarActivoModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },
        async editarAsignarActivo() {
            const response = await this.actualizarAsignarActivo(this.editActivo);

            if (this.errors_activo === null) {
                this.$notyf.success(response.message);
                this.$emit('actualizar-activo', response.updated_activo);
                this.close();
            }
        }
    }
}
</script>

<style scoped></style>
