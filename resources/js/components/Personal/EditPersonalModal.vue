<template>
    <div class="modal fade" id="editPersonalModal" tabindex="-1" aria-labelledby="editPersonalModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPersonalModalLabel"><i class="bi bi-pencil-square"></i> Editar Personal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="editarPersonal">
                        <div class="mb-3">
                            <label for="personalNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="personalNombre" v-model="editPersonal.name"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="personalApellidoPaterno" class="form-label">Apellido Paterno</label>
                            <input type="text" class="form-control" id="personalApellidoPaterno"
                                v-model="editPersonal.apellido_paterno" required>
                        </div>
                        <div class="mb-3">
                            <label for="personalApellidoMaterno" class="form-label">Apellido Materno</label>
                            <input type="text" class="form-control" id="personalApellidoMaterno"
                                v-model="editPersonal.apellido_materno" required>
                        </div>
                        <div class="mb-3">
                            <label for="personalRun" class="form-label">R.U.N</label>
                            <input type="text" class="form-control" id="personalRun" v-model="editPersonal.run"
                                maxlength="12" minlength="11">
                        </div>
                        <div class="mb-3">
                            <label for="personalCargo" class="form-label">Cargo</label>
                            <select class="form-select" id="personalCargo" aria-label="Seleccione el cargo" v-model="editPersonal.cargo">
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
                        <button type="submit" class="btn btn-base-dv" :disabled="editPersonal.name == ''">Guardar
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
        personal: Object,
        cargos: Array
    },
    data() {
        return {
            editPersonal: {
                name: '',
                apellido_paterno: '',
                apellido_materno: '',
                run: '',
                cargo: null
            }
        };
    },
    watch: {
        personal: {
            immediate: true,
            handler(Personal) {
                if (Personal) {
                    this.editPersonal = {
                        name: Personal.name,
                        apellido_paterno: Personal.apellido_paterno,
                        apellido_materno: Personal.apellido_materno,
                        run: Personal.run,
                        cargo: Personal.cargo_id
                    }
                }
            }
        },
        'editPersonal.run': {
            immediate: true,
            handler(run) {
                this.editPersonal.run = formatRUT(run);
            },
        },
        'editPersonal.name': {
            immediate: true,
            handler(name) {
                this.editPersonal.name = capitalizarNombres(name);
            },
        },
        'editPersonal.apellido_paterno': {
            immediate: true,
            handler(apellido_paterno) {
                this.editPersonal.apellido_paterno = capitalizarNombres(apellido_paterno);
            },
        },
        'editPersonal.apellido_materno': {
            immediate: true,
            handler(apellido_materno) {
                this.editPersonal.apellido_materno = capitalizarNombres(apellido_materno);
            },
        }
    },
    methods: {
        open() {
            this.errors = null;
            const modalElement = document.getElementById('editPersonalModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('editPersonalModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },

        async editarPersonal() {
            const response = await this.actualizarPersonal({
                personal_id: this.personal.id,
                name: this.editPersonal.name,
                apellido_paterno: this.editPersonal.apellido_paterno,
                apellido_materno: this.editPersonal.apellido_materno,
                run: this.editPersonal.run,
                cargo: this.editPersonal.cargo
            });

            if (this.errors === null) {
                this.$notyf.success(response.message);
                this.$emit('personal-updated');
                this.close();
            }
        }
    }
}
</script>

<style scoped></style>
