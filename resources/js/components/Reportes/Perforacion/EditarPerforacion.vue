<template>
    <form @submit.prevent="editarPerforaciones">
        <div class="mb-3">
            <label for="perforacionesDesde" class="form-label">Desde</label>
            <input type="number" min="0" class="form-control" id="perforacionesDesde" v-model="editPerforaciones.desde"
                :class="errors_perforaciones ? errors_perforaciones.desde ? 'is-invalid' : '' : ''" disabled required>
        </div>
        <div class="mb-3">
            <label for="perforacionesHasta" class="form-label">Hasta</label>
            <input type="number" min="0" class="form-control" id="perforacionesHasta" v-model="editPerforaciones.hasta"
                :class="errors_perforaciones ? errors_perforaciones.hasta ? 'is-invalid' : '' : ''" disabled required>
        </div>
        <div class="mb-3">
            <label for="perforacionesPerforado" class="form-label">Perforado</label>
            <input type="number" min="0" class="form-control" id="perforacionesPerforado"
                v-model="editPerforaciones.perforado"
                :class="errors_perforaciones ? errors_perforaciones.perforado ? 'is-invalid' : '' : ''" required>
        </div>
        <div class="mb-3">
            <label for="perforacionesRecuperado" class="form-label">Recuperado</label>
            <input type="number" min="0" class="form-control" id="perforacionesRecuperado"
                v-model="editPerforaciones.recuperado"
                :class="errors_perforaciones ? errors_perforaciones.recuperado ? 'is-invalid' : '' : ''" required>
        </div>
        <div class="mb-3">
            <label for="perforacionesPorcentaje" class="form-label">Porcentaje</label>
            <input type="number" min="0" class="form-control" id="perforacionesPorcentaje"
                v-model="editPerforaciones.porcentaje"
                :class="errors_perforaciones ? errors_perforaciones.porcentaje ? 'is-invalid' : '' : ''" required>
        </div>
        <div class="mb-3">
            <label for="perforacionesNumeroCajas" class="form-label">N°
                Cajas</label>
            <input type="number" min="0" class="form-control" id="perforacionesNumeroCajas"
                v-model="editPerforaciones.numero_cajas"
                :class="errors_perforaciones ? errors_perforaciones.numero_cajas ? 'is-invalid' : '' : ''" required>
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
import perforacionesMixin from '../../../mixins/reporte/perforacionesMixin';

export default {
    mixins: [perforacionesMixin],
    props: {
        data: Object,
    },
    data() {
        return {
            editPerforaciones: {
                id: 0,
                reporte_id: 0,
                desde: 0,
                hasta: 0,
                perforado: 0,
                recuperado: 0,
                porcentaje: 0,
                numero_cajas: 0
            }
        };
    },
    watch: {
        data: {
            immediate: true,
            handler(data) {
                if (data) {
                    console.log(data);
                    this.editPerforaciones = {
                        id: data.id,
                        reporte_id: data.reporte_id,
                        desde: data.desde,
                        hasta: data.hasta,
                        perforado: data.perforado,
                        recuperado: data.recuperado,
                        porcentaje: data.porcentaje,
                        numero_cajas: data.numero_cajas
                    }
                }
            }
        },
        'editPerforaciones.desde': 'validarInicioTermino',
        'editPerforaciones.hasta': 'validarInicioTermino'
    },
    methods: {
        cancelarEditarPerforacion() {
            this.$emit('cancelar-editar', false);
        },
        calculoRecuperado() {
            if (this.editPerforaciones.perforado > 0) {
                this.editPerforaciones.porcentaje = Math.round((this.editPerforaciones.recuperado / this.editPerforaciones.perforado) * 100);
            } else {
                this.editPerforaciones.porcentaje = 0;
            }
        },
        calculoPerforado() {
            const perforado = this.editPerforaciones.hasta - this.editPerforaciones.desde;
            this.editPerforaciones.perforado = Number.isInteger(perforado)
                ? perforado
                : perforado.toFixed(2).replace(/\.?0+$/, '');
        },
        validarInicioTermino() {
            const desde = parseInt(this.editPerforaciones.desde);
            const hasta = parseInt(this.editPerforaciones.hasta);

            this.errors_perforaciones = {
                desde: false,
                hasta: false,
                perforado: false
            }

            if (isNaN(desde) || isNaN(hasta)) {
                this.errors_perforaciones = {
                    desde: true,
                    hasta: true,
                    perforado: true
                }
            }

            if ((desde > 0 && hasta > 0) && desde >= hasta) {
                this.errors_perforaciones = {
                    hasta: true,
                    perforado: true
                }
            }
        },
        async editarPerforaciones() {
            const response = await this.actualizarPerforacion(this.editPerforaciones);

            if (this.errors_perforaciones === null) {
                this.$notyf.success(response.message);
                this.$emit('actualizar-perforacion', response.perforacion);
            }
        },
    }
}
</script>