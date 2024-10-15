<template>
    <div class="card shadow mb-3">
        <div class="card-body">
            <h4 class="text-center mb-3">¿Estás seguro de eliminar?</h4>

            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item"><b>Cantidad:</b> {{ data.cantidad }}</li>
                <li class="list-group-item"><b>Detalle:</b> {{ data.detalle }}</li>
            </ul>

            <div class="row mx-auto">
                <div class="col-6">
                    <button type="button" class="btn w-100 btn-secondary"
                        @click="cancelarEliminarAditivo()">Cancelar</button>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn w-100 btn-danger" @click="eliminarAditivo()">
                        <span v-if="loading_create">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Cargando...</span>
                        <span v-else>Eliminar</span>
                    </button>
                </div>

            </div>
        </div>
    </div>
</template>
<script>
import aditivoMixin from '../../../mixins/reporte/aditivoMixin';

export default {
    mixins: [aditivoMixin],
    props: {
        data: Object,
    },
    methods: {
        cancelarEliminarAditivo() {
            this.$emit('cancelar-eliminar', false);
        },
        async eliminarAditivo() {
            this.$emit('confirmado-eliminar', { id: this.data.id, cerrarEliminar: false });
            const response = await this.deleteAditivo(this.data.id);
            if (this.errors_aditivos === null) {
                this.$notyf.success(response.message);
            }
        },

    }
}
</script>