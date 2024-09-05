<template>
    <div class="modal fade" id="editTipoActivosModal" tabindex="-1" aria-labelledby="editTipoActivosModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTipoActivosModalLabel"><i class="bi bi-pencil-square"></i> Editar Tipo Activo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="editarTipoActivos">
                        <div class="mb-3">
                            <label for="tipoActivosNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="tipoActivosNombre" v-model="editTipoActivos.name"
                                required>
                        </div>
                        <template v-if="errors">
                            <div class="alert alert-danger" role="alert" v-for="tipoActivos in errors.name">
                                {{ tipoActivos }}
                            </div>
                        </template>
                        <button type="submit" class="btn btn-base-dv" :disabled="editTipoActivos.name == ''">Guardar
                            Cambios</button>
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
    props: {
        tipo_activo: Object
    },
    data() {
        return {
            editTipoActivos: {
                name: ''
            }
        };
    },
    watch: {
        tipo_activo: {
            immediate: true,
            handler(TipoActivos) {
                if (TipoActivos) {
                    this.editTipoActivos.name = TipoActivos.name;
                }
            }
        }
    },
    methods: {
        open() {
            this.errors = null;
            this.editTipoActivos.name = '';
            const modalElement = document.getElementById('editTipoActivosModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('editTipoActivosModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },

        async editarTipoActivos() {
            const response = await this.actualizarTipoActivos({
                tipo_activo_id: this.tipo_activo.id,
                name: this.editTipoActivos.name
            });

            if (this.errors === null) {
                this.$notyf.success(response.message);
                this.$emit('tipo-activos-updated');
                this.close();
            }
        }
    }
}
</script>

<style scoped></style>
