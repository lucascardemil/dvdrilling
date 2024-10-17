<template>
    <div>
        <div class="card mb-5">
            <div class="card-body">
                <div class="mb-3">
                    <input type="text" class="form-control" id="buscarNombre" placeholder="Buscar Nombre"
                        v-model="buscarPersonal.name">
                </div>
                <form @submit.prevent="saveAsignarPersonal">
                    <div class="list-group mb-3" v-if="personals.length">
                        <label class="list-group-item" v-for="personal in filtrarAsignarPersonal" :key="personal.id"
                            :class="errors_personal ? errors_personal.personal_id ? 'list-group-item-error' : '' : ''">
                            <input class="form-check-input me-1" type="checkbox" :id="'personal-' + personal.id"
                                :value="personal.id" v-model="selectedPersonals"
                                @change="handlePersonalsChange(personal.id)">
                            {{ personal.name }} {{ personal.apellido_paterno }} - {{ personal.cargo.name }}
                        </label>
                    </div>
                    <div class="mb-3">
                        <select class="form-select" aria-label="Seleccione el proyecto"
                            :class="errors_personal ? errors_personal.proyecto_id ? 'is-invalid' : '' : ''"
                            v-model="recursos.proyecto">
                            <option :value="null" disabled>Seleccione el proyecto</option>
                            <template v-for="proyecto in proyectos">
                                <option :value="proyecto.id">{{ proyecto.name }}</option>
                            </template>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-base-dv">Agregar</button>
                </form>
            </div>
        </div>

        <div class="row g-2 mb-4">
            <div class="col-md">
                <div class="form-floating">
                    <input type="text" class="form-control" id="filtrarNombre" v-model="filtroNombre">
                    <label for="filtrarNombre">Filtrar por Nombre</label>
                </div>
            </div>
            <div class="col-md">
                <div class="form-floating">
                    <input type="text" class="form-control" id="filtrarProyecto" v-model="filtroProyecto">
                    <label for="filtrarProyecto">Filtrar por Proyecto</label>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Personal</th>
                        <th scope="col">Cargo</th>
                        <th scope="col">Proyecto</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="asignarPersonal.length">
                        <tr v-for="(recurso, index) in filtrarRecursos" :key="recurso.id">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ recurso.personal.name }} {{ recurso.personal.apellido_paterno }} {{
                                recurso.personal.apellido_materno }}</td>
                            <td>{{ recurso.personal.cargo.name }}</td>
                            <td>{{ recurso.proyecto.name }}</td>
                            <td>
                                <button type="button" class="btn btn-primary" @click="openEditModal(recurso)"><i
                                        class="bi bi-pencil-square"></i></button>
                                <button type="button" class="btn btn-danger" @click="openEliminarModal(recurso)"><i
                                        class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    </template>
                    <p v-else-if="loading">Cargando...</p>
                    <p v-else>No hay Personal Asignado.</p>
                    <p v-if="errors">{{ errors }}</p>
                </tbody>
            </table>
        </div>
        <EditAsignarPersonalModal ref="editAsignarPersonalModal" :recurso="selectedRecurso" :proyectos="proyectos"
            @actualizar-personal="actualizarPersonalRecurso"></EditAsignarPersonalModal>
        <EliminarPersonalModal ref="eliminarAsignarPersonalModal" :recurso="selectedRecurso"
            @eliminar-personal="eliminarPersonalRecurso" />
    </div>
</template>

<script>
import personalMixin from '../../../mixins/personal/personalMixin';
import asignarPersonalMixin from '../../../mixins/recurso/asignarPersonalMixin';
import EliminarPersonalModal from './EliminarAsignarPersonalModal.vue';
import EditAsignarPersonalModal from './EditAsignarPersonalModal.vue';

export default {
    mixins: [personalMixin, asignarPersonalMixin],
    props: {
        proyectos: Array
    },
    components: {
        EliminarPersonalModal,
        EditAsignarPersonalModal
    },
    data() {
        return {
            selectedRecurso: null,
            buscarPersonal: {
                name: ''
            },
            recursos: {
                proyecto: null,
                personal: []
            },
            selectedPersonals: [],
            filtroNombre: '',
            filtroProyecto: ''
        };
    },
    computed: {
        filtrarAsignarPersonal() {
            return this.personals.filter(personal => {
                return personal.name.includes(this.buscarPersonal.name)
            });
        },
        filtrarRecursos() {
            return this.asignarPersonal.filter(recurso => {
                return recurso.personal.name.includes(this.filtroNombre) &&
                    recurso.proyecto.name.includes(this.filtroProyecto);
            });
        }
    },
    methods: {
        openEditModal(recurso) {
            if (recurso) {
                this.selectedRecurso = { ...recurso };
                this.$refs.editAsignarPersonalModal.open();
            }
        },
        openEliminarModal(recurso) {
            if (recurso) {
                this.selectedRecurso = { ...recurso };
                this.$refs.eliminarAsignarPersonalModal.open();
            }
        },
        handlePersonalsChange(personalId) {
            const index = this.recursos.personal.indexOf(personalId);
            if (index === -1) {
                this.recursos.personal.push(personalId);
            } else {
                this.recursos.personal.splice(index, 1);
            }
        },
        async saveAsignarPersonal() {
            const response = await this.createRecurso(this.recursos);

            if (this.errors_personal === null) {
                // Mostrar notificación de éxito
                this.$notyf.success(response.message);

                // Limpiar campos de selección
                this.selectedPersonals = [];
                this.buscarPersonal.name = '';

                // Añadir nuevo personal asignado
                this.asignarPersonal.push(...response.recursoPersonal);

                // Filtrar el personal asignado de la lista de personales
                const personalIds = this.recursos.personal.map(personal => personal);
                this.personals = this.personals.filter(personal => !personalIds.includes(personal.id));

                // Limpiar datos de recursos
                this.recursos.proyecto = null;
                this.recursos.personal = [];
            }
        },
        eliminarPersonalRecurso(personal_recurso) {
            if (personal_recurso) {
                this.personals.push(personal_recurso.deleted_personal);
                let eliminado = this.asignarPersonal.filter(personal => personal.id !== personal_recurso.id);
                this.asignarPersonal = eliminado;
            }
        },
        actualizarPersonalRecurso(personal_recurso) {
            if (personal_recurso) {
                this.asignarPersonal.forEach(personal => {
                    if (personal.id === personal_recurso.id) {
                        personal.proyecto = personal_recurso.proyecto
                    }
                });
            }
        }

    },
    created() {
        this.fetchNombrePersonals();
        this.fetchAllAsignarPersonal();
    }
}
</script>

<style scoped></style>
