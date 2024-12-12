<template>
    <div class="modal-reporte modal fade" id="horometroModal" tabindex="-1" aria-labelledby="horometroModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="horometroModalLabel">Horómetro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <form @submit.prevent="crearHorometro">
                                <div class="mb-3">
                                    <label for="horometroInicio" class="form-label">Inicio</label>
                                    <input type="number" min="0" class="form-control" id="horometroInicio"
                                        :disabled="existeInicio" v-model="newHorometro.inicio"
                                        :class="errors_horometro ? errors_horometro.inicio ? 'is-invalid' : '' : ''"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="horometroTermino" class="form-label">Termino</label>
                                    <input type="number" min="0" class="form-control" id="horometroTermino"
                                        v-model="newHorometro.termino"
                                        :class="errors_horometro ? errors_horometro.termino ? 'is-invalid' : '' : ''"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="horometroNumeroCajas" class="form-label">N° Cajas</label>
                                    <input type="number" min="0" class="form-control" id="horometroNumeroCajas"
                                        v-model="newHorometro.numero_cajas"
                                        :class="errors_horometro ? errors_horometro.numero_cajas ? 'is-invalid' : '' : ''"
                                        required>
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
import horometroMixin from '../../../mixins/reporte/horometroMixin';

export default {
    mixins: [horometroMixin],
    props: {
        reporte: Object,
    },
    data() {
        return {
            newHorometro: {
                inicio: 0,
                termino: 0,
                numero_cajas: 0,
                reporte_id: 0
            },
            existeInicio: false

        };
    },
    watch: {
        reporte: {
            immediate: true,
            handler(Reporte) {
                if (Reporte) {
                    this.newHorometro.reporte_id = Reporte.id;
                    this.horometro = Reporte.horometro;

                    Reporte.horometro.forEach(horometro => {
                        this.existeInicio = horometro.inicio > 0 ? true : false;
                        this.newHorometro.inicio = horometro.inicio;
                        this.newHorometro.termino = horometro.termino;
                        this.newHorometro.numero_cajas = horometro.numero_cajas;
                    });

                }
            }
        },
        'newHorometro.inicio': 'validarInicioTermino',
        'newHorometro.termino': 'validarInicioTermino'
    },
    methods: {
        open() {
            this.resetForm();
            const modalElement = document.getElementById('horometroModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('horometroModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },
        async crearHorometro() {
            const response = await this.createHorometro(this.newHorometro);

            if (this.errors_horometro === null) {
                this.horometro.push(response.horometro);
                this.$notyf.success(response.message);
            }
        },
        validarInicioTermino() {
            const inicio = parseInt(this.newHorometro.inicio);
            const termino = parseInt(this.newHorometro.termino);

            this.errors_horometro = {
                inicio: false,
                termino: false
            }

            if (isNaN(inicio) || isNaN(termino)) {
                this.errors_horometro = {
                    inicio: true,
                    termino: true
                }
            }

            if (termino > 0 && inicio >= termino) {
                this.errors_horometro = {
                    termino: true
                }
            }
        },
        resetForm() {
            this.errors_horometro = {
                inicio: false,
                termino: false
            }
            this.newHorometro = {
                inicio: 0,
                termino: 0,
                numero_cajas: 0,
                reporte_id: 0
            }
            this.existeInicio = false
        }
    }
}
</script>

<style scoped></style>
