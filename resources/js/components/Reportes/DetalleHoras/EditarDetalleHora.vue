<template>
    <form @submit.prevent="editarDetalleHoras">
        <div class="row">
            <div class="col-6 mb-3">
                <label for="detalleHorasDe" class="form-label">De</label>
                <input type="time" class="form-control" id="detalleHorasDe" v-model="editDetalleHoras.de"
                    :class="errors_detalleHoras ? errors_detalleHoras.de ? 'is-invalid' : '' : ''"
                    pattern="[0-9]{2}:[0-9]{2}" placeholder="HH:mm">
            </div>
            <div class="col-6 mb-3">
                <label for="detalleHorasA" class="form-label">A</label>
                <input type="time" class="form-control" id="detalleHorasA" v-model="editDetalleHoras.a"
                    :min="editDetalleHoras.de"
                    :class="errors_detalleHoras ? errors_detalleHoras.a ? 'is-invalid' : '' : ''"
                    pattern="[0-9]{2}:[0-9]{2}" placeholder="HH:mm">
            </div>
        </div>
        <div class="mb-3">
            <label for="detalleHorasActividad" class="form-label">Actividad</label>
            <select class="form-select" aria-label="Seleccione la actividad" id="detalleHorasActividad"
                v-model="editDetalleHoras.actividad_id"
                :class="errors_detalleHoras ? errors_detalleHoras.actividad_id ? 'is-invalid' : '' : ''" required>
                <option :value="null" disabled>Seleccione la actividad</option>
                <template v-for="actividad in actividades">
                    <option :value="actividad.id">{{ actividad.name }}</option>
                </template>
            </select>
        </div>


        <button type="button" class="btn btn-block btn-secondary" @click="cancelarEditarPerforacion()">Cancelar</button>

        <button type="submit" class="btn btn-base-dv" :disabled="loading_create">
            <span v-if="loading_create">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Cargando...</span>
            <span v-else>Actualizar Cambios</span>
        </button>
    </form>
</template>

<script>
import detalleHorasMixin from '../../../mixins/reporte/detalleHorasMixin';

export default {
    mixins: [detalleHorasMixin],
    props: {
        data: Object,
        actividades: Array
    },
    data() {
        return {
            editDetalleHoras: {
                id: 0,
                reporte_id: 0,
                de: "",
                a: "",
                actividad_id: 0
            }
        };
    },
    watch: {
        data: {
            immediate: true,
            handler(data) {
                if (data) {
                    console.log(data);
                    this.editDetalleHoras = {
                        id: data.id,
                        reporte_id: data.reporte_id,
                        de: data.de,
                        a: data.a,
                        actividad_id: data.actividad_id
                    }
                }
            }
        },
        'editDetalleHoras.desde': 'validarInicioTermino',
        'editDetalleHoras.hasta': 'validarInicioTermino'
    },
    methods: {
        cancelarEditarPerforacion() {
            this.$emit('cancelar-editar', false);
        },
        async editarDetalleHoras() {
            const response = await this.actualizarDetalleHora(this.editDetalleHoras);

            if (this.errors_detalleHoras === null) {
                this.$notyf.success(response.message);
                this.$emit('actualizar-perforacion', response.perforacion);
            }

            if (this.errors_detalleHoras.a) {
                this.$notyf.error(this.errors_detalleHoras.a[0]);
            }

            if (this.errors_detalleHoras.de) {
                this.$notyf.error(this.errors_detalleHoras.de[0]);
            }
        },
    }
}
</script>