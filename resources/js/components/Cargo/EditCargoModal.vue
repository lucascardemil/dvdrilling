<template>
    <div class="modal fade" id="editCargoModal" tabindex="-1" aria-labelledby="editCargoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCargoModalLabel"><i class="bi bi-pencil-square"></i> Editar Cargo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="editarCargo">
                        <div class="mb-3">
                            <label for="cargoNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="cargoNombre" v-model="editCargo.name"
                                required>
                        </div>
                        <template v-if="errors">
                            <div class="alert alert-danger" role="alert" v-for="cargo in errors.name">
                                {{ cargo }}
                            </div>
                        </template>
                        <button type="submit" class="btn btn-base-dv" :disabled="editCargo.name == ''">Guardar
                            Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import cargoMixin from '../../mixins/cargo/cargoMixin';

export default {
    mixins: [cargoMixin],
    props: {
        cargo: Object
    },
    data() {
        return {
            editCargo: {
                name: ''
            }
        };
    },
    watch: {
        cargo: {
            immediate: true,
            handler(Cargo) {
                if (Cargo) {
                    this.editCargo.name = Cargo.name;
                }
            }
        }
    },
    methods: {
        open() {
            this.errors = null;
            this.editCargo.name = '';
            const modalElement = document.getElementById('editCargoModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('editCargoModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },

        async editarCargo() {
            const response = await this.actualizarCargo({
                cargo_id: this.cargo.id,
                name: this.editCargo.name
            });

            if (this.errors === null) {
                this.$notyf.success(response.message);
                this.$emit('cargo-updated');
                this.close();
            }
        }
    }
}
</script>

<style scoped></style>
