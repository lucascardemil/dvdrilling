<template>
    <div>
        <div class="card mb-5">
            <div class="card-body">
                <div class="mb-3">
                    <input type="text" class="form-control" id="buscarNombre" placeholder="Buscar Nombre"
                        v-model="buscarActivo.name">
                </div>
                <form @submit.prevent="saveAsignarActivo">
                    <div class="list-group mb-3" v-if="activos.length">
                        <label class="list-group-item" v-for="activo in filtrarAsignarActivo" :key="activo.id"
                            :class="errors_activo ? errors_activo.activo_id ? 'list-group-item-error' : '' : ''">
                            <input class="form-check-input me-1" type="checkbox" :id="'activo-' + activo.id"
                                :value="activo.id" v-model="selectedActivos" @change="handleActivosChange(activo.id)">
                            {{ activo.tipo_activo.name }} {{ activo.marca }} {{ activo.modelo }} {{ activo.patente }}
                        </label>
                    </div>
                    <div class="mb-3">
                        <select class="form-select" id="selectProyecto" aria-label="Seleccione el proyecto"
                            :class="errors_activo ? errors_activo.proyecto_id ? 'is-invalid' : '' : ''"
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
                    <input type="text" class="form-control" id="filtrarNombre" v-model="filtroNombreActivo">
                    <label for="filtrarNombre">Filtrar por Nombre</label>
                </div>
            </div>
            <div class="col-md">
                <div class="form-floating">
                    <input type="text" class="form-control" id="filtrarProyecto" v-model="filtroProyectoActivo">
                    <label for="filtrarProyecto">Filtrar por Proyecto</label>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Activo</th>
                        <th scope="col">Tipo Activo</th>
                        <th scope="col">Proyecto</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="asignarActivo.length">
                        <tr v-for="(recurso, index) in filtrarRecursos" :key="recurso.id">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ recurso.activo.tipo_activo.name }} {{ recurso.activo.marca }} {{
                                recurso.activo.modelo }} {{ recurso.activo.patente }}</td>
                            <td>{{ recurso.activo.tipo_activo.name }}</td>
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
                    <p v-else>No hay Activo Asignado.</p>
                    <p v-if="errors">{{ errors }}</p>
                </tbody>
            </table>
        </div>
        <EditAsignarActivoModal ref="editAsignarActivoModal" :recurso="selectedRecurso" :proyectos="proyectos"
            @actualizar-activo="actualizarActivoRecurso" />
        <EliminarAsignarActivoModal ref="eliminarAsignarActivoModal" :recurso="selectedRecurso"
            @eliminar-activo="eliminarActivoRecurso" />
    </div>
</template>

<script>
import activoMixin from '../../../mixins/activo/activoMixin';
import asignarActivoMixin from '../../../mixins/recurso/asignarActivoMixin';
import EliminarAsignarActivoModal from './EliminarAsignarActivoModal.vue';
import EditAsignarActivoModal from './EditAsignarActivoModal.vue';

export default {
    mixins: [activoMixin, asignarActivoMixin],
    props: {
        proyectos: Array
    },
    components: {
        EliminarAsignarActivoModal,
        EditAsignarActivoModal
    },
    data() {
        return {
            selectedRecurso: null,
            buscarActivo: {
                name: ''
            },
            recursos: {
                proyecto: null,
                activo: []
            },
            selectedActivos: [],
            filtroNombreActivo: '',
            filtroProyectoActivo: ''
        };
    },
    computed: {
        filtrarAsignarActivo() {
            return this.activos.filter(activo => {
                return activo.patente.includes(this.buscarActivo.name) ||
                    activo.marca.includes(this.buscarActivo.name) ||
                    activo.modelo.includes(this.buscarActivo.name) ||
                    activo.tipo_activo.name.includes(this.buscarActivo.name)
            });
        },
        filtrarRecursos() {
            return this.asignarActivo.filter(recurso => {
                return (recurso.activo.patente.includes(this.filtroNombreActivo) ||
                    recurso.activo.marca.includes(this.filtroNombreActivo) ||
                    recurso.activo.modelo.includes(this.filtroNombreActivo) ||
                    recurso.activo.tipo_activo.name.includes(this.filtroNombreActivo)) &&
                    recurso.proyecto.name.includes(this.filtroProyectoActivo);
            });
        }
    },
    methods: {
        openEditModal(recurso) {
            if (recurso) {
                this.selectedRecurso = { ...recurso };
                this.$refs.editAsignarActivoModal.open();
            }
        },
        openEliminarModal(recurso) {
            if (recurso) {
                this.selectedRecurso = { ...recurso };
                this.$refs.eliminarAsignarActivoModal.open();
            }
        },
        handleActivosChange(activoId) {
            const index = this.recursos.activo.indexOf(activoId);
            if (index === -1) {
                this.recursos.activo.push(activoId);
            } else {
                this.recursos.activo.splice(index, 1);
            }
        },
        async saveAsignarActivo() {
            const response = await this.createRecurso(this.recursos);

            if (this.errors_activo === null) {
                // Mostrar notificación de éxito
                this.$notyf.success(response.message);

                // Limpiar campos de selección
                this.selectedActivos = [];
                this.buscarActivo.name = '';

                // Añadir nuevo activo asignado
                this.asignarActivo.push(...response.recursoActivo);

                // Filtrar el activo asignado de la lista de activoes
                const activoIds = this.recursos.activo.map(activo => activo);
                this.activos = this.activos.filter(activo => !activoIds.includes(activo.id));

                // Limpiar datos de recursos
                this.recursos.proyecto = null;
                this.recursos.activo = [];
            }
        },
        eliminarActivoRecurso(activo_recurso) {
            if (activo_recurso) {
                this.activos.push(activo_recurso.deleted_activo);
                let eliminado = this.asignarActivo.filter(activo => activo.id !== activo_recurso.id);
                this.asignarActivo = eliminado;
            }
        },
        actualizarActivoRecurso(activo_recurso) {
            if (activo_recurso) {
                this.asignarActivo.forEach(activo => {
                    if (activo.id === activo_recurso.id) {
                        activo.proyecto = activo_recurso.proyecto
                    }
                });
            }
        }

    },
    created() {
        this.fetchNombreActivos();
        this.fetchAllAsignarActivo();
    }
}
</script>

<style scoped></style>
