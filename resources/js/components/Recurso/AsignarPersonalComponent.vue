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
                        <label class="list-group-item" v-for="personal in filtrarAsignarPersonal" :key="personal.id">
                            <input class="form-check-input me-1" type="checkbox" :id="'personal-' + personal.id"
                                :value="personal.id" v-model="selectedPersonals"
                                @change="handlePersonalsChange(personal.id)">
                            {{ personal.name }} {{ personal.apellido_paterno }} - {{ personal.cargo.name }}
                        </label>
                        <template v-if="errors_personal">
                            <div class="alert alert-danger my-0" role="alert"
                                v-for="personal_id in errors_personal.personal_id">
                                No hay ninguna personal para asignar
                            </div>
                        </template>
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
                                <button type="button" class="btn btn-danger" @click="openEditModal(recurso)"><i
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
    </div>
</template>

<script>
import personalMixin from '../../mixins/personal/personalMixin';
import proyectoMixin from '../../mixins/proyecto/proyectoMixin';
import asignarPersonalMixinMixin from '../../mixins/recurso/asignarPersonalMixin';

export default {
    mixins: [personalMixin, proyectoMixin, asignarPersonalMixinMixin],
    components: {

    },
    data() {
        return {
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
                this.$notyf.success(response.message);
                this.selectedPersonals = [];
                this.recursos.proyecto = null;
                this.recursos.personal = [];
                this.buscarPersonal.name = '';
                this.fetchAllAsignarPersonal();
                this.fetchNombrePersonals();
            }
        }

    },
    mounted() {
        this.fetchNombrePersonals();
        this.fetchProyectosSelect();
        this.fetchAllAsignarPersonal();
    }
}
</script>

<style scoped></style>
