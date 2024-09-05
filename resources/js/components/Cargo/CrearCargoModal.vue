<template>
    <div class="modal fade" id="crearCargoModal" tabindex="-1" aria-labelledby="crearCargoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearCargoModalLabel">Crear Cargo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="saveCargo">
                        <div class="mb-3">
                            <label for="cargoNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="cargoNombre" v-model="newCargo.name"
                                required>
                        </div>
                        <template v-if="errors">
                            <div class="alert alert-danger" role="alert" v-for="cargo in errors.name">
                                {{ cargo }}
                            </div>
                        </template>
                        <button type="submit" class="btn btn-base-dv" :disabled="newCargo.name == ''">Guardar Cambios</button>
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
    data() {
        return {
            newCargo: {
                name: '',
            }
        };
    },
    methods: {
        open() {
            this.errors = null;
            const modalElement = document.getElementById('crearCargoModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('crearCargoModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },

        async saveCargo() {
            const response = await this.createCargo(this.newCargo);

            if (this.errors === null) {
                this.$notyf.success(response.message);
                this.$emit('cargo-updated');
                this.newCargo.name = '';
                this.close();
            }
        }
    }
}
</script>

<style scoped></style>
