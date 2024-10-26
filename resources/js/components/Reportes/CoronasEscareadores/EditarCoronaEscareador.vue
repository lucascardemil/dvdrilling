<template>
    <form @submit.prevent="editarCoronasEscareadores">
        <div class="mb-3">
            <label for="coronasEscareadoresDetalle" class="form-label">Detalle</label>
            <select class="form-select" aria-label="Seleccione un detalle" id="coronasEscareadoresDetalle" v-model="editCoronasEscareadores.detalle"
                :class="errors_coronasEscareadores ? errors_coronasEscareadores.inicio ? 'is-invalid' : '' : ''"
                required>
                <option :value="null" disabled>Seleccione un Detalle</option>
                <option value="corona">Corona</option>
                <option value="escareador">Escareador</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="coronasEscareadoresDesde" class="form-label">Desde</label>
            <input type="number" min="0" class="form-control" id="coronasEscareadoresDesde"
                v-model="editCoronasEscareadores.desde"
                :class="errors_coronasEscareadores ? errors_coronasEscareadores.desde ? 'is-invalid' : '' : ''"
                required>
        </div>
        <div class="mb-3">
            <label for="coronasEscareadoresHasta" class="form-label">Hasta</label>
            <input type="number" min="0" class="form-control" id="coronasEscareadoresHasta"
                v-model="editCoronasEscareadores.hasta"
                :class="errors_coronasEscareadores ? errors_coronasEscareadores.hasta ? 'is-invalid' : '' : ''"
                required>
        </div>

        <div class="mb-3">
            <label for="coronasEscareadoresDiametro" class="form-label">Diametro</label>
            <input type="number" min="0" class="form-control" id="coronasEscareadoresDiametro"
                v-model="editCoronasEscareadores.diametro"
                :class="errors_coronasEscareadores ? errors_coronasEscareadores.diametro ? 'is-invalid' : '' : ''"
                required>
        </div>
        <div class="mb-3">
            <label for="coronasEscareadoresNumeroCorona" class="form-label">N°
                Corona</label>
            <input type="number" min="0" class="form-control" id="coronasEscareadoresNumeroCorona"
                v-model="editCoronasEscareadores.numero_corona"
                :class="errors_coronasEscareadores ? errors_coronasEscareadores.numero_corona ? 'is-invalid' : '' : ''"
                required>
        </div>

        <button type="button" class="btn btn-block btn-secondary"
            @click="cancelarEditarCoronaEscareador()">Cancelar</button>

        <button type="submit" class="btn btn-base-dv" :disabled="loading_create">
            <span v-if="loading_create">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Cargando...</span>
            <span v-else>Actualizar Cambios</span>
        </button>
    </form>
</template>

<script>
import coronasEscareadoresMixin from '../../../mixins/reporte/coronasEscareadoresMixin';

export default {
    mixins: [coronasEscareadoresMixin],
    props: {
        data: Object,
    },
    data() {
        return {
            editCoronasEscareadores: {
                id: 0,
                reporte_id: 0,
                detalle: null,
                desde: 0,
                hasta: 0,
                diametro: 0,
                numero_corona: 0
            }
        };
    },
    watch: {
        data: {
            immediate: true,
            handler(data) {
                if (data) {
                    this.editCoronasEscareadores = {
                        id: data.id,
                        reporte_id: data.reporte_id,
                        detalle: data.detalle,
                        desde: data.desde,
                        hasta: data.hasta,
                        diametro: data.diametro,
                        numero_corona: data.numero_corona
                    }
                }
            }
        },
        'editCoronasEscareadores.desde': 'validarInicioTermino',
        'editCoronasEscareadores.hasta': 'validarInicioTermino'
    },
    methods: {
        cancelarEditarCoronaEscareador(){
            this.$emit('cancelar-editar', false);
        },
        validarInicioTermino() {
            const desde = parseInt(this.editCoronasEscareadores.desde);
            const hasta = parseInt(this.editCoronasEscareadores.hasta);

            this.errors_coronasEscareadores = {
                desde: false,
                hasta: false
            }

            if (isNaN(desde) || isNaN(hasta)) {
                this.errors_coronasEscareadores = {
                    desde: true,
                    hasta: true
                }
            }

            if (hasta > 0 && desde >= hasta) {
                this.errors_coronasEscareadores = {
                    hasta: true
                }
            }
        },
        async editarCoronasEscareadores() {
            const response = await this.actualizarCoronaEscareador(this.editCoronasEscareadores);

            if (this.errors_coronasEscareadores === null) {
                this.$notyf.success(response.message);
                this.$emit('actualizar-corona-escareador', response.corona_escareador);
            }
        },
    }
}
</script>