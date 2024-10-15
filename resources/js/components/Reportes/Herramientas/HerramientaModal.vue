<template>
    <div class="modal fade" id="herramientasModal" tabindex="-1" aria-labelledby="herramientaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="herramientaModalLabel">Control De Herramientas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <form @submit.prevent="crearHerramienta">
                                <div class="row align-items-center mb-3">
                                    <div class="col">
                                        <label for="herramientaBarra3" class="form-label mb-0">Barras</label>
                                    </div>
                                    <div class="col">
                                        <input type="number" min="0" class="form-control" id="herramientaBarra3"
                                            v-model="newHerramienta.barras_3"
                                            :class="errors_herramienta ? errors_herramienta.barras_3 ? 'is-invalid' : '' : ''"
                                            required>

                                    </div>
                                    <div class="col">
                                        x 3,00 =
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" id="herramientaTotalBarra3"
                                            :value="total_barra_3" disabled readonly>
                                    </div>
                                </div>
                                <div class="row align-items-center mb-3">
                                    <div class="col">
                                        <label for="herramientaBarra35" class="form-label mb-0">Barras</label>
                                    </div>
                                    <div class="col">
                                        <input type="number" min="0" class="form-control" id="herramientaBarra35"
                                            v-model="newHerramienta.barras_3_5"
                                            :class="errors_herramienta ? errors_herramienta.barras_3_5 ? 'is-invalid' : '' : ''"
                                            required>

                                    </div>
                                    <div class="col">
                                        x 3,05 =
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" id="herramientaTotalBarra35"
                                            :value="total_barra_3_5" disabled readonly>
                                    </div>
                                </div>
                                <div class="row align-items-center mb-3">
                                    <div class="col-9">
                                        <label for="herramientaSubTotalBarras" class="form-label mb-0">SubTotal</label>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="herramientaSubTotalBarras"
                                            :value="subTotalBarras" disabled readonly>
                                    </div>
                                </div>
                                <div class="row align-items-center mb-3">
                                    <div class="col">
                                        <label for="herramientaBarril" class="form-label mb-0">Barril</label>
                                    </div>
                                    <div class="col">
                                        <input type="number" min="0" class="form-control" id="herramientaBarril"
                                            v-model="newHerramienta.barril"
                                            :class="errors_herramienta ? errors_herramienta.barril ? 'is-invalid' : '' : ''"
                                            required>

                                    </div>
                                    <div class="col">
                                        =
                                    </div>
                                    <div class="col">
                                        <input type="number" min="0" step="0.01" class="form-control"
                                            id="herramientaTotalBarril" v-model="newHerramienta.total_barril"
                                            :class="errors_herramienta ? errors_herramienta.total_barril ? 'is-invalid' : '' : ''"
                                            required>
                                    </div>
                                </div>
                                <div class="row align-items-center mb-3">
                                    <div class="col-9">
                                        <label for="herramientaSubTotalBarril" class="form-label mb-0">SubTotal</label>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="herramientaSubTotalBarril"
                                            :value="subTotalBarril" disabled readonly>
                                    </div>
                                </div>
                                <div class="row align-items-center mb-3">
                                    <div class="col-9">
                                        <label for="herramientaMuerto" class="form-label mb-0">Muerto</label>
                                    </div>
                                    <div class="col-3">
                                        <input type="number" min="0" step="0.01" class="form-control"
                                            id="herramientaMuerto" v-model="newHerramienta.muerto"
                                            :class="errors_herramienta ? errors_herramienta.muerto ? 'is-invalid' : '' : ''"
                                            required>
                                    </div>
                                </div>
                                <div class="row align-items-center mb-3">
                                    <div class="col-9">
                                        <label for="herramientaTotal" class="form-label mb-0">Herramienta
                                            Total</label>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="herramientaTotal"
                                            :value="total_herramienta" disabled readonly>
                                    </div>
                                </div>
                                <div class="row align-items-center mb-3">
                                    <div class="col-9">
                                        <label for="herramientaContra" class="form-label mb-0">Contra</label>
                                    </div>
                                    <div class="col-3">
                                        <input type="number" min="0" step="0.01" class="form-control"
                                            id="herramientaContra" v-model="newHerramienta.contra"
                                            :class="errors_herramienta ? errors_herramienta.contra ? 'is-invalid' : '' : ''"
                                            required>
                                    </div>
                                </div>
                                <div class="row align-items-center mb-3">
                                    <div class="col-9">
                                        <label for="herramientaTotalFinal" class="form-label mb-0">Total</label>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="herramientaTotalFinal"
                                            :value="total_final" disabled readonly>
                                    </div>
                                </div>


                                <div class="p-3 mb-3 border rounded">
                                    <div class="row align-items-center mb-3">
                                        <div class="col-6">
                                            <div class="row align-items-center">
                                                <div class="col-6">
                                                    <label for="herramientaInicio"
                                                        class="form-label mb-0">F.Inicio</label>
                                                </div>
                                                <div class="col-6">
                                                    <input type="number" min="0" step="0.01" class="form-control"
                                                        id="herramientaInicio" v-model="newHerramienta.f_inicio"
                                                        :class="errors_herramienta ? errors_herramienta.f_inicio ? 'is-invalid' : '' : ''"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row align-items-center">
                                                <div class="col-6">
                                                    <label for="herramientaAvance"
                                                        class="form-label mb-0">Avance</label>
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" class="form-control" id="herramientaAvance"
                                                        :value="avance" disabled readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <div class="row align-items-center">
                                                <div class="col-6">
                                                    <label for="herramientaTermino"
                                                        class="form-label mb-0">F.Termino</label>
                                                </div>
                                                <div class="col-6">
                                                    <input type="number" min="0" step="0.01" class="form-control"
                                                        id="herramientaTermino" v-model="newHerramienta.f_termino"
                                                        :class="errors_herramienta ? errors_herramienta.f_termino ? 'is-invalid' : '' : ''"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row align-items-center">
                                                <div class="col-6">
                                                    <label for="herramientaRecuperacion" class="form-label mb-0">%
                                                        Recup.</label>
                                                </div>
                                                <div class="col-6">
                                                    <input type="number" class="form-control"
                                                        id="herramientaRecuperacion"
                                                        v-model="newHerramienta.recuperacion"
                                                        :class="errors_herramienta ? errors_herramienta.recuperacion ? 'is-invalid' : '' : ''"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-base-dv" :disabled="loading_create">
                                    <span v-if="loading_create">
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        Cargando...</span>
                                    <span v-else>Guardar Cambios</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import herramientaMixin from '../../../mixins/reporte/herramientaMixin';

export default {
    mixins: [herramientaMixin],
    props: {
        reporte: Object,
    },
    data() {
        return {
            newHerramienta: {
                barras_3: 0,
                barras_3_5: 0,
                barril: 0,
                total_barril: 0,
                muerto: 0,
                contra: 0,
                f_termino: 0,
                f_inicio: 0,
                reporte_id: 0
            },
        };
    },
    watch: {
        reporte: {
            immediate: true,
            handler(Reporte) {
                if (Reporte) {
                    this.newHerramienta.reporte_id = Reporte.id;
                    this.herramienta = Reporte.herramienta;

                    Reporte.herramienta.forEach(herramienta => {
                        this.newHerramienta.barras_3 = herramienta.barras_3,
                            this.newHerramienta.barras_3_5 = herramienta.barras_3_5,
                            this.newHerramienta.barril = herramienta.barril,
                            this.newHerramienta.total_barril = herramienta.total_barril,
                            this.newHerramienta.muerto = herramienta.muerto,
                            this.newHerramienta.contra = herramienta.contra,
                            this.newHerramienta.f_termino = herramienta.f_termino,
                            this.newHerramienta.f_inicio = herramienta.f_inicio
                            this.newHerramienta.recuperacion = herramienta.recuperacion
                    });

                }
            }
        }
    },
    computed: {
        total_barra_3() {
            return this.newHerramienta.barras_3 * 3
        },
        total_barra_3_5() {
            return this.newHerramienta.barras_3_5 * 3.05
        },
        subTotalBarras() {
            return this.total_barra_3 + this.total_barra_3_5
        },
        subTotalBarril() {
            const total = parseFloat(this.subTotalBarras) + parseFloat(this.newHerramienta.total_barril)
            return Number.isInteger(total) ? total : total.toFixed(2).replace(/\.?0+$/, '');
        },
        total_herramienta() {
            return this.subTotalBarril - this.newHerramienta.muerto
        },
        total_final() {
            return this.total_herramienta - this.newHerramienta.contra
        },
        avance() {
            const avance = this.newHerramienta.f_termino - this.newHerramienta.f_inicio
            return Number.isInteger(avance) ? avance : avance.toFixed(2).replace(/\.?0+$/, '');
        }
    },
    methods: {
        open() {
            const modalElement = document.getElementById('herramientasModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('herramientasModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },
        async crearHerramienta() {
            const response = await this.createHerramienta(this.newHerramienta);

            if (this.errors_herramienta === null) {
                this.herramienta.push(response.herramienta);
                this.$notyf.success(response.message);
            }
        }
    }
}
</script>

<style scoped></style>
