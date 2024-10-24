<template>
    <div class="modal fade" id="editActivoModal" tabindex="-1" aria-labelledby="editActivoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editActivoModalLabel"><i class="bi bi-pencil-square"></i> Editar Activo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="editarActivo">
                        <div class="mb-3">
                            <label for="activoActivo" class="form-label">Tipo de Activo</label>
                            <select class="form-select" id="activoActivo" :class="errors ? errors.tipo_activo ? 'is-invalid' : '' : ''"
                                aria-label="Seleccione el tipo de activo" v-model="editActivo.tipo_activo" required>
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
                                v-model="editActivo.marca" required>
                        </div>

                        <div class="mb-3">
                            <label for="activoModelo" class="form-label">Modelo</label>
                            <input type="text" class="form-control"
                                :class="errors ? errors.modelo ? 'is-invalid' : '' : ''" id="activoModelo"
                                v-model="editActivo.modelo" required>
                        </div>

                        <div class="mb-3">
                            <label for="activoPatente" class="form-label">Patente</label>
                            <input type="text" class="form-control"
                                :class="errors ? errors.patente ? 'is-invalid' : '' : ''" id="activoPatente"
                                v-model="editActivo.patente" required>
                        </div>

                        <div class="mb-3">
                            <label for="activoNumeroInterno" class="form-label">N° Interno</label>
                            <input type="text" class="form-control"
                                :class="errors ? errors.numero_interno ? 'is-invalid' : '' : ''"
                                id="activoNumeroInterno" v-model="editActivo.numero_interno" required>
                        </div>

                        <div class="mb-3">
                            <label for="activoYear" class="form-label">Año</label>
                            <input type="text" class="form-control"
                                :class="errors ? errors.year ? 'is-invalid' : '' : ''" id="activoYear"
                                v-model="editActivo.year" aria-describedby="activoYear" required>
                        </div>

                        <div class="mb-3">
                            <label for="activoHorometro" class="form-label">Horómetro</label>
                            <input type="text" class="form-control"
                                :class="errors ? errors.horometro ? 'is-invalid' : '' : ''" id="activoHorometro"
                                v-model="editActivo.horometro" required>
                        </div>

                        <div class="mb-3">
                            <label for="activoKilometraje" class="form-label">Kilometraje</label>
                            <input type="text" class="form-control"
                                :class="errors ? errors.kilometraje ? 'is-invalid' : '' : ''" id="activoKilometraje"
                                v-model="editActivo.kilometraje" required>
                        </div>

                        <div class="mb-3">
                            <label for="activoColor" class="form-label">Color</label>
                            <input type="text" class="form-control"
                                :class="errors ? errors.color ? 'is-invalid' : '' : ''" id="activoColor"
                                v-model="editActivo.color" required>
                        </div>

                        <div class="mb-3">
                            <label for="activoChasis" class="form-label">Chasis</label>
                            <input type="text" class="form-control"
                                :class="errors ? errors.chasis ? 'is-invalid' : '' : ''" id="activoChasis"
                                v-model="editActivo.chasis" required>
                        </div>

                        <div class="mb-3">
                            <label for="activoMotor" class="form-label">N° Motor</label>
                            <input type="text" class="form-control"
                                :class="errors ? errors.numero_motor ? 'is-invalid' : '' : ''" id="activoMotor"
                                v-model="editActivo.numero_motor" required>
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
                        <button type="submit" class="btn btn-base-dv" :disabled="editActivo.name == ''">Guardar
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
        activo: Object,
        tipo_activos: Array
    },
    data() {
        return {
            editActivo: {
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
        };
    },
    watch: {
        activo: {
            immediate: true,
            handler(Activo) {
                if (Activo) {
                    this.editActivo.tipo_activo = Activo.tipo_activo_id;
                    this.editActivo.marca = Activo.marca;
                    this.editActivo.modelo = Activo.modelo;
                    this.editActivo.patente = Activo.patente;
                    this.editActivo.numero_interno = Activo.numero_interno;
                    this.editActivo.year = Activo.year;
                    this.editActivo.horometro = Activo.horometro;
                    this.editActivo.kilometraje = Activo.kilometraje;
                    this.editActivo.color = Activo.color;
                    this.editActivo.chasis = Activo.chasis;
                    this.editActivo.numero_motor = Activo.numero_motor;
                }
            }
        }
    },

    methods: {
        open() {
            this.errors = null;
            const modalElement = document.getElementById('editActivoModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('editActivoModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },

        async editarActivo() {
            const response = await this.actualizarActivo({
                activo_id: this.activo.id,
                tipo_activo: this.editActivo.tipo_activo,
                marca: this.editActivo.marca,
                modelo: this.editActivo.modelo,
                patente: this.editActivo.patente,
                numero_interno: this.editActivo.numero_interno,
                year: this.editActivo.year,
                horometro: this.editActivo.horometro,
                kilometraje: this.editActivo.kilometraje,
                color: this.editActivo.color,
                chasis: this.editActivo.chasis,
                numero_motor: this.editActivo.numero_motor
            });

            if (this.errors === null) {
                this.$notyf.success(response.message);
                this.$emit('activo-updated');
                this.close();
            }
        }
    }
}
</script>

<style scoped></style>
