<template>
    <div class="modal fade" id="eliminarAsignarActivoModal" tabindex="-1" aria-labelledby="eliminarAsignarActivoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarAsignarActivoModalLabel"><i class="bi bi-pencil-square"></i> Eliminar
                        Activo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="lead">Estas seguro de eliminar el activo <b>{{ activo.name }}</b> del proyecto <b>{{
                            activo.proyecto }}</b>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-danger" @click="eliminarActivo(activo.id)"><i
                            class="bi bi-trash"></i> Eliminar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import asignarActivoMixin from '../../../mixins/recurso/asignarActivoMixin';

export default {
    mixins: [asignarActivoMixin],
    props: {
        recurso: Object
    },
    data() {
        return {
            activo: {
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
                    this.activo.id = Recurso.id
                    this.activo.name = Recurso.activo.tipo_activo.name + ' ' + Recurso.activo.marca + ' ' + Recurso.activo.modelo + ' ' + Recurso.activo.patente;
                    this.activo.proyecto = Recurso.proyecto.name;
                }
            }
        }
    },
    methods: {
        open() {
            const modalElement = document.getElementById('eliminarAsignarActivoModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('eliminarAsignarActivoModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },
        async eliminarActivo(id) {
            const response = await this.eliminarRecursoActivo({
                activo_id: this.activo.id,
            });

            if (this.errors_activo === null) {
                this.$notyf.success(response.message);
                this.$emit('eliminar-activo', {deleted_activo: response.deleted_activo, id: id});
                this.close();
            }
        }
    }
}
</script>

<style scoped></style>
