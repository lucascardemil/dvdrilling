<template>
    <div>
        <div class="mb-5">
            <button type="button" class="btn btn-base-dv" @click="openCrearModal()"><i class="bi bi-plus-circle"></i>
                Agregar Personal</button>

        </div>
        <LoadingComponent v-if="loading"/>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombres</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">R.U.N</th>
                        <th scope="col">Cargo</th>
                        <th scope="col">Habilitar Personal</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="personals.length">
                        <tr v-for="(personal, index) in personals" :key="personal.id">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ personal.name }}</td>
                            <td>{{ personal.apellido_paterno + ' ' + personal.apellido_materno}}</td>
                            <td>{{ personal.run }}</td>
                            <td>{{ personal.cargo.name }}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        :id="personal.id" v-model="personal.status"
                                        @change="handleEnabledChange(personal.id, personal.status)">
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" @click="openEditModal(personal)"><i class="bi bi-pencil-square"></i> Editar
                                    Personal</button>
                            </td>
                        </tr>
                    </template>
                    <p v-else>No hay personal.</p>
                    <p v-if="errors">{{ errors }}</p>
                </tbody>
            </table>
        </div>
        <CrearPersonalModal ref="crearPersonalModal" @personal-updated="fetchPersonals" :cargos="cargos" />
        <EditPersonalModal ref="editPersonalModal" :personal="selectedPersonal" @personal-updated="fetchPersonals" :cargos="cargos"/>
    </div>
</template>

<script>
import personalMixin from '../../mixins/personal/personalMixin';
import CrearPersonalModal from './CrearPersonalModal.vue';
import EditPersonalModal from './EditPersonalModal.vue';
import cargoMixin from '../../mixins/cargo/cargoMixin';
import LoadingComponent from '../base/LoadingComponent.vue';

export default {
    mixins: [personalMixin, cargoMixin],
    components: {
        CrearPersonalModal,
        EditPersonalModal,
        LoadingComponent
    },
    data() {
        return {
            selectedPersonal: null,
            checkbox: [],
            cargos: []
        };
    },
    methods: {
        openCrearModal() {
            this.$refs.crearPersonalModal.open();
        },
        openEditModal(personal) {
            if (personal) {
                this.selectedPersonal = { ...personal };
                this.$refs.editPersonalModal.open();
            }
        },
        async handleEnabledChange(personalId, status) {
            const checkboxStatus = status ? 1 : 0;
            const checkbox = { personal_id: personalId, status: checkboxStatus };

            try {
                const response = await this.actualizarStatusPersonal(checkbox);
                if (this.errors === null) {
                    this.$notyf.success(response.message);
                    this.$emit('personal-updated');
                }
            } catch (error) {
                console.error('Error actualizando el estado:', error);
            }
        }

    },
    created() {
        this.fetchPersonals();
        this.fetchCargosSelect();
    }
}
</script>

<style scoped></style>
