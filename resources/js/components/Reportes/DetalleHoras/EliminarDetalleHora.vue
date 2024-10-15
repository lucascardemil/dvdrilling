<template>
    <div class="card shadow mb-3">
        <div class="card-body">
            <h4 class="text-center mb-3">¿Estás seguro de eliminar?</h4>

            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item"><b>De:</b> {{ data.de.slice(0, 5) }}</li>
                <li class="list-group-item"><b>A:</b> {{ data.a.slice(0, 5) }}</li>
                <li class="list-group-item"><b>Actividad:</b> {{ data.actividad.name }}</li>
            </ul>

            <div class="row mx-auto">
                <div class="col-6">
                    <button type="button" class="btn w-100 btn-secondary"
                        @click="cancelarEliminarDetalleHora()">Cancelar</button>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn w-100 btn-danger" @click="eliminarDetalleHora()">
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
import detalleHorasMixin from '../../../mixins/reporte/detalleHorasMixin';

export default {
    mixins: [detalleHorasMixin],
    props: {
        data: Object,
    },
    methods: {
        cancelarEliminarDetalleHora() {
            this.$emit('cancelar-eliminar', false);
        },
        async eliminarDetalleHora() {
            this.$emit('confirmado-eliminar', { id: this.data.id, cerrarEliminar: false });
            const response = await this.deleteDetalleHora(this.data.id);
            if (this.errors_detalleHoras === null) {
                this.$notyf.success(response.message);
            }
        },

    }
}
</script>