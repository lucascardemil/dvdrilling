<template>
    <form @submit.prevent="editarAditivos">
        <div class="mb-3">
            <label for="aditivoTipoPeso" class="form-label">Tipo de Peso</label>
            <select class="form-select" aria-label="Seleccione el tipo de peso" id="aditivoTipoPeso"
                v-model="editAditivo.tipo_peso"
                :class="errors_aditivos ? errors_aditivos.tipo_peso ? 'is-invalid' : '' : ''" required>
                <option :value="null" disabled>Seleccione el tipo de peso</option>
                <option value="KG">KG</option>
                <option value="LT">LT</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="aditivoCantidad" class="form-label">Cantidad</label>
            <input type="number" min="0" class="form-control" id="aditivoCantidad" v-model="editAditivo.cantidad"
                :class="errors_aditivos ? errors_aditivos.cantidad ? 'is-invalid' : '' : ''" required>
        </div>
        <div class="mb-3">
            <label for="aditivoDetalle" class="form-label">Detalle</label>
            <textarea class="form-control" id="aditivoDetalla" v-model="editAditivo.detalle"
                :class="errors_aditivos ? errors_aditivos.detalle ? 'is-invalid' : '' : ''" required></textarea>
        </div>

        <button type="button" class="btn btn-block btn-secondary" @click="cancelarEditarAditivo()">Cancelar</button>

        <button type="submit" class="btn btn-base-dv" :disabled="loading_create">
            <span v-if="loading_create">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Cargando...</span>
            <span v-else>Actualizar Cambios</span>
        </button>
    </form>
</template>

<script>
import aditivoMixin from '../../../mixins/reporte/aditivoMixin';

export default {
    mixins: [aditivoMixin],
    props: {
        data: Object,
    },
    data() {
        return {
            editAditivo: {
                id: 0,
                reporte_id: 0,
                detalle: '',
                cantidad: 0,
                tipo_peso: null
            }
        };
    },
    watch: {
        data: {
            immediate: true,
            handler(data) {
                if (data) {
                    this.editAditivo = {
                        id: data.id,
                        reporte_id: data.reporte_id,
                        detalle: data.detalle,
                        cantidad: data.cantidad,
                        tipo_peso: data.tipo_peso
                    }
                }
            }
        }
    },
    methods: {
        cancelarEditarAditivo() {
            this.$emit('cancelar-editar', false);
        },
        async editarAditivos() {
            const response = await this.actualizarAditivo(this.editAditivo);

            if (this.errors_aditivos === null) {
                this.$notyf.success(response.message);
                this.$emit('actualizar-aditivo', response.aditivo);
            }
        },
    }
}
</script>