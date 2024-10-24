<template>
    <div class="modal fade" id="crearActivoModal" tabindex="-1" aria-labelledby="crearActivoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearActivoModalLabel">Crear Activo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="saveActivo">
                        <div class="mb-3">
                            <label for="activoActivo" class="form-label">Tipo de Activo</label>
                            <select class="form-select" id="activoActivo" :class="errors ? errors.tipo_activo ? 'is-invalid' : '' : ''"
                                aria-label="Seleccione el tipo de activo" v-model="newActivo.tipo_activo" required>
                                <option :value="null" disabled>Seleccione el tipo de activo</option>
                                <template v-for="tipo_activo in tipo_activos">
                                    <option :value="tipo_activo.id">{{ tipo_activo.name }}</option>
                                </template>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="activoMarca" class="form-label">Marca</label>
                            <input type="text" class="form-control"
                                :class="errors ? errors.marca ? 'is-invalid' : '' : ''" id="activoMarca"
                                v-model="newActivo.marca" required>
                        </div>

                        <div class="mb-3">
                            <label for="activoModelo" class="form-label">Modelo</label>
                            <input type="text" class="form-control"
                                :class="errors ? errors.modelo ? 'is-invalid' : '' : ''" id="activoModelo"
                                v-model="newActivo.modelo" required>
                        </div>

                        <div class="mb-3">
                            <label for="activoPatente" class="form-label">Patente</label>
                            <input type="text" class="form-control"
                                :class="errors ? errors.patente ? 'is-invalid' : '' : ''" id="activoPatente"
                                v-model="newActivo.patente" required>
                        </div>

                        <div class="mb-3">
                            <label for="activoNumeroInterno" class="form-label">N° Interno</label>
                            <input type="text" class="form-control"
                                :class="errors ? errors.numero_interno ? 'is-invalid' : '' : ''"
                                id="activoNumeroInterno" v-model="newActivo.numero_interno" required>
                        </div>

                        <div class="mb-3">
                            <label for="activoYear" class="form-label">Año</label>
                            <input type="text" class="form-control"
                                :class="errors ? errors.year ? 'is-invalid' : '' : ''" id="activoYear"
                                v-model="newActivo.year" aria-describedby="activoYear" required>
                        </div>

                        <div class="mb-3">
                            <label for="activoHorometro" class="form-label">Horómetro</label>
                            <input type="text" class="form-control"
                                :class="errors ? errors.horometro ? 'is-invalid' : '' : ''" id="activoHorometro"
                                v-model="newActivo.horometro" required>
                        </div>

                        <div class="mb-3">
                            <label for="activoKilometraje" class="form-label">Kilometraje</label>
                            <input type="text" class="form-control"
                                :class="errors ? errors.kilometraje ? 'is-invalid' : '' : ''" id="activoKilometraje"
                                v-model="newActivo.kilometraje" required>
                        </div>

                        <div class="mb-3">
                            <label for="activoColor" class="form-label">Color</label>
                            <input type="text" class="form-control"
                                :class="errors ? errors.color ? 'is-invalid' : '' : ''" id="activoColor"
                                v-model="newActivo.color" required>
                        </div>

                        <div class="mb-3">
                            <label for="activoChasis" class="form-label">Chasis</label>
                            <input type="text" class="form-control"
                                :class="errors ? errors.chasis ? 'is-invalid' : '' : ''" id="activoChasis"
                                v-model="newActivo.chasis" required>
                        </div>

                        <div class="mb-3">
                            <label for="activoMotor" class="form-label">N° Motor</label>
                            <input type="text" class="form-control"
                                :class="errors ? errors.numero_motor ? 'is-invalid' : '' : ''" id="activoMotor"
                                v-model="newActivo.numero_motor" required>
                        </div>

                        <template v-if="errors">
                            <div class="alert alert-danger" role="alert" v-for="tipo_activo in errors.tipo_activo">
                                {{ tipo_activo }}
                            </div>
                            <div class="alert alert-danger" role="alert" v-for="marca in errors.marca">
                                {{ marca }}
                            </div>
                            <div class="alert alert-danger" role="alert" v-for="modelo in errors.modelo">
                                {{ modelo }}
                            </div>
                            <div class="alert alert-danger" role="alert" v-for="patente in errors.patente">
                                {{ patente }}
                            </div>
                            <div class="alert alert-danger" role="alert"
                                v-for="numero_interno in errors.numero_interno">
                                {{ numero_interno }}
                            </div>
                            <div class="alert alert-danger" role="alert" v-for="year in errors.year">
                                {{ year }}
                            </div>
                            <div class="alert alert-danger" role="alert" v-for="horometro in errors.horometro">
                                {{ horometro }}
                            </div>
                            <div class="alert alert-danger" role="alert" v-for="kilometraje in errors.kilometraje">
                                {{ kilometraje }}
                            </div>
                            <div class="alert alert-danger" role="alert" v-for="color in errors.color">
                                {{ color }}
                            </div>
                            <div class="alert alert-danger" role="alert" v-for="chasis in errors.chasis">
                                {{ chasis }}
                            </div>
                            <div class="alert alert-danger" role="alert" v-for="motor in errors.numero_motor">
                                {{ motor }}
                            </div>
                        </template>

                        <button type="submit" class="btn btn-base-dv" :disabled="newActivo.tipo_activo === null">Guardar
                            Cambios</button>
                    </form>


                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import activoMixin from '../../mixins/activo/activoMixin';

export default {
    mixins: [activoMixin],
    props: {
        tipo_activos: Array
    },
    data() {
        return {
            newActivo: {
                tipo_activo: null,
                marca: '',
                modelo: '',
                patente: '',
                numero_interno: '',
                year: '',
                horometro: '',
                kilometraje: '',
                color: '',
                chasis: '',
                numero_motor: ''
            },
        };
    },
    methods: {
        open() {
            this.errors = null;
            this.resetForm();
            const modalElement = document.getElementById('crearActivoModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('crearActivoModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },
        resetForm() {
            this.newActivo = {
                tipo_activo: null,
                marca: '',
                modelo: '',
                patente: '',
                numero_interno: '',
                year: '',
                horometro: '',
                kilometraje: '',
                color: '',
                chasis: '',
                numero_motor: ''
            }
        },
        async saveActivo() {
            const response = await this.createActivo(this.newActivo);

            if (this.errors === null) {
                this.$notyf.success(response.message);
                this.$emit('activo-updated');
                this.close();
                this.resetForm();
            }
        }
    }
}
</script>

<style scoped></style>
