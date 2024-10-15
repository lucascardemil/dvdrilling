<template>
    <div class="card shadow mb-3">
        <div class="card-body">
            <h4 class="text-center mb-3">¿Estás seguro de eliminar?</h4>

            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item"><b>Desde:</b> {{ data.desde }}</li>
                <li class="list-group-item"><b>Hasta:</b> {{ data.hasta }}</li>
                <li class="list-group-item"><b>Perforado:</b> {{ data.perforado }}</li>
                <li class="list-group-item"><b>Recuperado:</b> {{ data.recuperado }}</li>
                <li class="list-group-item"><b>Porcentaje:</b> {{ data.porcentaje }}</li>
                <li class="list-group-item"><b>N° Cajas:</b> {{ data.numero_cajas }}</li>
            </ul>

            <div class="row mx-auto">
                <div class="col-6">
                    <button type="button" class="btn w-100 btn-secondary"
                        @click="cancelarEliminarPerforacion()">Cancelar</button>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn w-100 btn-danger" @click="eliminarPerforacion()">
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
import perforacionesMixin from '../../../mixins/reporte/perforacionesMixin';

export default {
    mixins: [perforacionesMixin],
    props: {
        data: Object,
    },
    methods: {
        cancelarEliminarPerforacion() {
            this.$emit('cancelar-eliminar', false);
        },
        async eliminarPerforacion() {
            this.$emit('confirmado-eliminar', { id: this.data.id, cerrarEliminar: false });
            const response = await this.deletePerforacion(this.data.id);
            if (this.errors_perforaciones === null) {
                this.$notyf.success(response.message);
            }
        },

    }
}
</script>