<template>
    <div class="modal fade" id="eliminarAsignarPersonalModal" tabindex="-1" aria-labelledby="eliminarAsignarPersonalModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarAsignarPersonalModalLabel"><i class="bi bi-pencil-square"></i> Eliminar
                        Personal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="lead">Estas seguro de <b>{{ personal.name }}</b> eliminar del proyecto <b>{{
                            personal.proyecto }}</b>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-danger" @click="eliminarPersonal(personal.id)"><i
                            class="bi bi-trash"></i> Eliminar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import asignarPersonalMixin from '../../../mixins/recurso/asignarPersonalMixin';

export default {
    mixins: [asignarPersonalMixin],
    props: {
        recurso: Object
    },
    data() {
        return {
            personal: {
                id: 0,
                name: '',
                proyecto: ''
            }
        };
    },
    watch: {
        recurso: {
            immediate: true,
            handler(Recurso) {
                if (Recurso) {
                    this.personal.id = Recurso.id
                    this.personal.name = Recurso.personal.name + ' ' + Recurso.personal.apellido_paterno + ' ' + Recurso.personal.apellido_materno;
                    this.personal.proyecto = Recurso.proyecto.name;
                }
            }
        }
    },
    methods: {
        open() {
            const modalElement = document.getElementById('eliminarAsignarPersonalModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('eliminarAsignarPersonalModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },
        async eliminarPersonal(id) {
            const response = await this.eliminarRecursoPersonal({
                personal_id: this.personal.id,
            });

            if (this.errors_personal === null) {
                this.$notyf.success(response.message);
                this.$emit('eliminar-personal', {deleted_personal: response.deleted_personal, id: id});
                this.close();
            }
        }
    }
}
</script>

<style scoped></style>
