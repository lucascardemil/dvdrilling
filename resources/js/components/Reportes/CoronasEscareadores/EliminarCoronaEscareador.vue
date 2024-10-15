<template>
    <div class="card shadow mb-3">
        <div class="card-body">
            <h4 class="text-center mb-3">¿Estás seguro de eliminar?</h4>

            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item"><b>Detalle:</b> {{ data.detalle }}</li>
                <li class="list-group-item"><b>Desde:</b> {{ data.desde }}</li>
                <li class="list-group-item"><b>Hasta:</b> {{ data.hasta }}</li>
                <li class="list-group-item"><b>Diametro:</b> {{ data.diametro }}</li>
                <li class="list-group-item"><b>N° Corona:</b> {{ data.numero_corona }}</li>
            </ul>

            <div class="row mx-auto">
                <div class="col-6">
                    <button type="button" class="btn w-100 btn-secondary"
                        @click="cancelarEliminarCoronaEscareador()">Cancelar</button>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn w-100 btn-danger" @click="eliminarCoronaEscareador()">
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
import coronasEscareadoresMixin from '../../../mixins/reporte/coronasEscareadoresMixin';

export default {
    mixins: [coronasEscareadoresMixin],
    props: {
        data: Object,
    },
    methods: {
        cancelarEliminarCoronaEscareador() {
            this.$emit('cancelar-eliminar', false);
        },
        async eliminarCoronaEscareador() {
            this.$emit('confirmado-eliminar', { id: this.data.id, cerrarEliminar: false });
            const response = await this.deleteCoronaEscareador(this.data.id);
            if (this.errors_coronasEscareadores === null) {
                this.$notyf.success(response.message);
            }
        },

    }
}
</script>