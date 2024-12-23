<template>
    <div>

        <div class="mb-5">
            <button type="button" class="btn btn-base-dv" @click="openCrearModal()"><i class="bi bi-plus-circle"></i>
                Agregar Cargo</button>
        </div>
        <LoadingComponent v-if="loading"/>
        <div v-else class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Habilitar Cargo</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="cargos.length">
                        <tr v-for="(cargo, index) in cargos" :key="cargo.id">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ cargo.name }}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        :id="cargo.id" v-model="cargo.status"
                                        @change="handleEnabledChange(cargo.id, cargo.status)">
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" @click="openEditModal(cargo)"><i class="bi bi-pencil-square"></i> Editar
                                    Cargo</button>
                            </td>
                        </tr>
                    </template>
                    <p v-else>No hay cargos.</p>
                    <p v-if="errors">{{ errors }}</p>
                </tbody>
            </table>
        </div>
        <CrearCargoModal ref="crearCargoModal" @cargo-updated="fetchCargos" />
        <EditCargoModal ref="editCargoModal" :cargo="selectedCargo" @cargo-updated="fetchCargos" />
    </div>
</template>

<script>
import cargoMixin from '../../mixins/cargo/cargoMixin';
import CrearCargoModal from './CrearCargoModal.vue';
import EditCargoModal from './EditCargoModal.vue';
import LoadingComponent from '../base/LoadingComponent.vue';

export default {
    mixins: [cargoMixin],
    components: {
        CrearCargoModal,
        EditCargoModal,
        LoadingComponent
    },
    data() {
        return {
            selectedCargo: null,
            checkbox: []
        };
    },
    methods: {
        openCrearModal() {
            this.$refs.crearCargoModal.open();
        },
        openEditModal(cargo) {
            if (cargo) {
                this.selectedCargo = { ...cargo };
                this.$refs.editCargoModal.open();
            }
        },
        async handleEnabledChange(cargoId, status) {
            const checkboxStatus = status ? 1 : 0;
            const checkbox = { cargo_id: cargoId, status: checkboxStatus };

            try {
                const response = await this.actualizarStatus(checkbox);
                if (this.errors === null) {
                    this.$notyf.success(response.message);
                    this.$emit('cargo-updated');
                }
            } catch (error) {
                console.error('Error actualizando el estado:', error);
            }
        }

    },
    created() {
        this.fetchCargos();
    }
}
</script>

<style scoped></style>
