<template>
    <div class="modal fade" id="crearPersonalModal" tabindex="-1" aria-labelledby="crearPersonalModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearPersonalModalLabel">Crear Personal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="savePersonal">
                        <div class="mb-3">
                            <label for="personalNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="personalNombre" v-model="newPersonal.name"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="personalApellidoPaterno" class="form-label">Apellido Paterno</label>
                            <input type="text" class="form-control" id="personalApellidoPaterno"
                                v-model="newPersonal.apellido_paterno" required>
                        </div>
                        <div class="mb-3">
                            <label for="personalApellidoMaterno" class="form-label">Apellido Materno</label>
                            <input type="text" class="form-control" id="personalApellidoMaterno"
                                v-model="newPersonal.apellido_materno" required>
                        </div>
                        <div class="mb-3">
                            <label for="personalRun" class="form-label">R.U.N</label>
                            <input type="text" class="form-control" id="personalRun" v-model="newPersonal.run" maxlength="12" minlength="11">
                        </div>
                        <div class="mb-3">
                            <label for="personalCargo" class="form-label">Cargo</label>
                            <select class="form-select" id="personalCargo" aria-label="Seleccione el cargo" v-model="newPersonal.cargo">
                                <option :value="null" disabled>Seleccione el cargo</option>
                                <template v-for="cargo in cargos">
                                    <option :value="cargo.id">{{ cargo.name }}</option>
                                </template>
                            </select>
                        </div>
                        <template v-if="errors">
                            <div class="alert alert-danger" role="alert" v-for="personal in errors.name">
                                {{ personal }}
                            </div>
                            <div class="alert alert-danger" role="alert"
                                v-for="apellido_paterno in errors.apellido_paterno">
                                {{ apellido_paterno }}
                            </div>
                            <div class="alert alert-danger" role="alert"
                                v-for="apellido_materno in errors.apellido_materno">
                                {{ apellido_materno }}
                            </div>
                            <div class="alert alert-danger" role="alert" v-for="run in errors.run">
                                {{ run }}
                            </div>
                            <div class="alert alert-danger" role="alert" v-for="cargo in errors.cargo">
                                {{ cargo }}
                            </div>
                        </template>
                        <button type="submit" class="btn btn-base-dv" :disabled="newPersonal.name == ''">Guardar
                            Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import personalMixin from '../../mixins/personal/personalMixin';
import { formatRUT } from '../../utils/formatRut';
import { capitalizarNombres } from '../../utils/capitalizarNombres';

export default {
    mixins: [personalMixin],
    props: {
        cargos: Array
    },
    data() {
        return {
            newPersonal: {
                name: '',
                apellido_paterno: '',
                apellido_materno: '',
                run: '',
                cargo: null
            }
        };
    },
    watch: {
        'newPersonal.run': {
            immediate: true,
            handler(run) {
                this.newPersonal.run = formatRUT(run);
            },
        },
        'newPersonal.name': {
            immediate: true,
            handler(name) {
                this.newPersonal.name = capitalizarNombres(name);
            },
        },
        'newPersonal.apellido_paterno': {
            immediate: true,
            handler(apellido_paterno) {
                this.newPersonal.apellido_paterno = capitalizarNombres(apellido_paterno);
            },
        },
        'newPersonal.apellido_materno': {
            immediate: true,
            handler(apellido_materno) {
                this.newPersonal.apellido_materno = capitalizarNombres(apellido_materno);
            },
        }
    },
    methods: {
        open() {
            this.errors = null;
            this.resetForm();
            const modalElement = document.getElementById('crearPersonalModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('crearPersonalModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },
        resetForm() {
            this.newPersonal = {
                name: '',
                apellido_paterno: '',
                apellido_materno: '',
                run: '',
                cargo: null
            }
        },
        async savePersonal() {
            const response = await this.createPersonal(this.newPersonal);

            if (this.errors === null) {
                this.$notyf.success(response.message);
                this.$emit('personal-updated');
                this.close();
                this.resetForm();
            }
        }
    }
}
</script>

<style scoped></style>
