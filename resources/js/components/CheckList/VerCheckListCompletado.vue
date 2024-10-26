<template>
    <CheckListObservacionImagenes v-if="mostrarObservacionesImagenes" :checklist_observaciones="checklist_observaciones"
        @volver-checkListObservacion="volverCheckListObservacion"
        :verImagenesObservacionesProp="verImagenesObservaciones"></CheckListObservacionImagenes>
    <div v-else class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead>
                <tr>
                    <th rowspan="2">Categoria</th>
                    <th colspan="2">Existe</th>
                    <th colspan="3">Estado</th>
                    <th rowspan="2">Observacion</th>
                </tr>
                <tr>
                    <th>SI</th>
                    <th>NO</th>
                    <th><i class="bi bi-emoji-laughing fs-4 text-success"></i></th>
                    <th><i class="bi bi-emoji-neutral fs-4 text-warning"></i></th>
                    <th><i class="bi bi-emoji-frown fs-4 text-danger"></i></th>
                </tr>
            </thead>
            <tbody>
                <template v-for="categoria in verCheckListProps.categorias">
                    <template v-if="categoria.intervenciones.length > 0">
                        <tr class="table-active">
                            <th colspan="7">{{ categoria.nombre }}</th>
                        </tr>

                        <tr v-for="(intervencion, index) in categoria.intervenciones"
                            :key="intervencion.id + '_' + index">
                            <td>{{ intervencion.nombre }}</td>

                            <template v-for="condicion in intervencion.condiciones">
                                <td v-if="condicion.existe === 1">
                                    <i class="bi bi-check-lg fs-4"></i>
                                </td>
                                <td v-else></td>
                                <td v-if="condicion.existe === 2">
                                    <i class="bi bi-check-lg fs-4"></i>
                                </td>
                                <td v-else></td>
                                <td v-if="condicion.estado === 1">
                                    <i class="bi bi-check-lg fs-4"></i>
                                </td>
                                <td v-else></td>
                                <td v-if="condicion.estado === 2">
                                    <i class="bi bi-check-lg fs-4"></i>
                                </td>
                                <td v-else></td>
                                <td v-if="condicion.estado === 3">
                                    <i class="bi bi-check-lg fs-4"></i>
                                </td>
                                <td v-else></td>
                                <td>
                                    <button type="button" class="btn btn-base-dv w-100"
                                        @click="verObservacionesImagenes(intervencion.observaciones)"><i
                                            class="bi bi-image-fill"></i></button>
                                </td>
                            </template>
                        </tr>
                    </template>
                </template>
            </tbody>
        </table>
    </div>
</template>

<script>
import checklistMixin from '../../mixins/checklist/checklistMixin';
import CheckListObservacionImagenes from './CheckListObservacionImagenes.vue';

export default {
    mixins: [checklistMixin],
    components: { CheckListObservacionImagenes },
    props: {
        verCheckListProps: Object,
    },
    data() {
        return {
            mostrarObservacionesImagenes: false,
            checklist_observaciones: [],
            verImagenesObservaciones: false
        };
    },
    methods: {
        verObservacionesImagenes(observaciones) {
            this.mostrarObservacionesImagenes = true;
            this.checklist_observaciones = observaciones
        },
        volverCheckListObservacion() {
            this.mostrarObservacionesImagenes = false;
        },
    }
}
</script>