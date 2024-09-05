<template>
    <div class="modal fade" id="imagenesActivoModal" tabindex="-1" aria-labelledby="imagenesActivoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imagenesActivoModalLabel"><i class="bi bi-images"></i> Imagenes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="editarImagenes">

                        <div class="mb-3">
                            <label for="activoMarca" class="form-label">Imagenes</label>
                            <div class="input-group">
                                <input type="file" class="form-control" id="formFile" @change="handleFileChange"
                                    multiple accept=".png, .jpeg, .jpg"
                                    :class="errors ? errors.imagenes ? 'is-invalid' : '' : ''" aria-label="file example"
                                    required>
                                <button type="submit" class="btn btn-base-dv"
                                    :disabled="editImagenesActivo.imagenes.length === 0">Guardar
                                    Cambios</button>
                            </div>
                            <template v-if="errors">
                                <div class="alert alert-danger" role="alert" v-for="imagen in errors.imagenes">
                                    {{ imagen }}
                                </div>
                            </template>
                        </div>

                        <div v-if="imagenes.length > 0" id="carouselImagenesControls" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <template v-for="(imagen, index) in imagenes">
                                    <div class="carousel-item" :class="{ 'active': index === 0 }">
                                        <img :src="formatImage(imagen.ruta)" class="d-block w-100" :alt="imagen.ruta">
                                    </div>
                                </template>
                            </div>
                            <button class="carousel-control-prev" type="button"
                                data-bs-target="#carouselImagenesControls" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button"
                                data-bs-target="#carouselImagenesControls" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import activoMixin from '../../mixins/activo/activoMixin';
import { formatImage } from '../../utils/formatImage';

export default {
    mixins: [activoMixin],
    props: {
        activo: Object,
    },
    data() {
        return {
            imagenes: {},
            editImagenesActivo: {
                imagenes: [],
            }
        };
    },
    watch: {
        activo: {
            immediate: true,
            handler(Activo) {
                if (Activo) {
                    this.imagenes = Activo.imagenes
                }
            }
        }
    },

    methods: {
        open() {
            this.errors = null;
            const modalElement = document.getElementById('imagenesActivoModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('imagenesActivoModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },
        handleFileChange(event) {
            this.editImagenesActivo.imagenes = Array.from(event.target.files);
        },

        async editarImagenes() {

            const formData = new FormData();
            formData.append('activo_id', this.activo.id);

            if (this.editImagenesActivo.imagenes) {
                this.editImagenesActivo.imagenes.forEach((file, index) => {
                    formData.append(`imagenes[${index}]`, file);
                });
            }
            const response = await this.actualizarImagenesActivo(formData);

            if (this.errors === null) {
                this.$notyf.success(response.message);
                this.$emit('activo-updated');
                this.close();
            }
        },
        formatImage
    }
}
</script>

<style scoped></style>
