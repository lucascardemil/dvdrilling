import axios from 'axios';

export default {
    data() {
        return {
            editChecklist: null,
            completarChecklist: null,
            verCheckListCompletadoChecklist: null,
            checklist: [],
            loading_intervenciones: false,
            loading_checklist: false,
            loading_checklist_create: false,
            loading_checklist_update: false,
            loading_checklist_delete: false,
            loading_checklist_finish: [],
            loading_checklist_observacion: false,
            loading_checklist_delete_observacion: [],
            loading_pdf: [],
            errors_checklist: null,
            errors_categoria_checklist: null,
            errors_intervencion_checklist: null,
            errors_finalizar_checklist: null,
            errors_observacion_checklist: null
        };
    },
    methods: {

        async fetchChecklist() {
            this.loading_checklist = true;
            this.errors_checklist = null;
            try {
                // Simular un retraso de 2 segundos
                await new Promise(resolve => setTimeout(resolve, 2000));

                const response = await axios.get('/checklist/all');
                if (response && response.data) {
                    this.checklist = response.data;
                } else {
                    this.errors_checklist = 'Invalid response data';
                }
            } catch (error) {
                this.errors_checklist = 'Failed to load checklist';
                console.error('Error fetching checklist:', error);
            } finally {
                this.loading_checklist = false;
            }
        },


        async fetchItervenciones(id) {
            this.loading_intervenciones = true;
            this.errors_intervencion_checklist = null;
            try {
                const response = await axios.get('/checklist/intervenciones/' + id)
                return response.data;
            } catch (error) {
                this.errors_intervencion_checklist = 'Failed to load checklist';
                console.error('Error fetching checklist:', error);
            } finally {
                this.loading_intervenciones = false;
            }
        },

        async createChecklist(data) {
            this.loading_checklist_create = true;
            this.errors_checklist = null;
            try {
                const response = await axios.post('/checklist/store_checklist', {
                    marca: data.marca,
                    modelo: data.modelo,
                    tipo_activo_id: data.tipo_activo_id,
                    matriz_checklist_id: data.matriz_checklist_id
                });

                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors_checklist = response.data.errors;
                }

                // Maneja la respuesta exitosa, si es necesario
                return response.data;

            } catch (error) {
                this.errors_checklist = 'Failed to load checklist';
                console.error('Error crear checklist:', error);
            } finally {
                this.loading_checklist_create = false;
            }
        },

        async createCategoriaChecklist(data) {
            this.loading_checklist_create = true;
            this.errors_categoria_checklist = null;
            try {
                const response = await axios.post('/checklist/store_categoriaChecklist', {
                    checklist_id: data.checklist_id,
                    nombre: data.nombre
                });

                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors_categoria_checklist = response.data.errors;
                }

                // Maneja la respuesta exitosa, si es necesario
                return response.data;

            } catch (error) {
                this.errors_categoria_checklist = 'Failed to load checklist';
                console.error('Error crear checklist:', error);
            } finally {
                this.loading_checklist_create = false;
            }
        },

        async createIntervencionChecklist(data) {
            this.loading_checklist_create = true;
            this.errors_intervencion_checklist = null;
            try {
                const response = await axios.post('/checklist/store_intervencionChecklist', {
                    checklist_categoria_id: data.checklist_categoria_id,
                    nombre: data.nombre
                });

                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors_intervencion_checklist = response.data.errors;
                }

                // Maneja la respuesta exitosa, si es necesario
                return response.data;

            } catch (error) {
                this.errors_intervencion_checklist = 'Failed to load checklist';
                console.error('Error crear checklist:', error);
            } finally {
                this.loading_checklist_create = false;
            }
        },

        async createObservacionChecklist(data) {
            this.loading_checklist_observacion = true;
            this.errors_observacion_checklist = null;
            try {
                const response = await axios.post('/checklist/store_observacionChecklist', data, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                if (response.data.errors) {
                    this.errors_observacion_checklist = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors_observacion_checklist = 'Failed to load observacion';
                console.error('Error actualizar observacion:', error);
            } finally {
                this.loading_checklist_observacion = false;
            }
        },

        async actualizarCategoriaChecklist(data) {
            this.loading_checklist_update = true;
            this.errors_categoria_checklist = null;
            try {
                const response = await axios.put('/checklist/update_categoriaChecklist/' + data.id, {
                    nombre: data.nombre
                });

                if (response.data.errors) {
                    this.errors_categoria_checklist = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors_categoria_checklist = 'Failed to load checklist';
                console.error('Error actualizar checklist:', error);
            } finally {
                this.loading_checklist_update = false;
            }
        },

        async actualizarIntervencionCheckList(data) {
            this.loading_checklist_update = true;
            this.errors_intervencion_checklist = null;
            try {
                const response = await axios.put('/checklist/update_intervencionChecklist/' + data.id, {
                    nombre: data.nombre
                });

                if (response.data.errors) {
                    this.errors_intervencion_checklist = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors_intervencion_checklist = 'Failed to load checklist';
                console.error('Error actualizar checklist:', error);
            } finally {
                this.loading_checklist_update = false;
            }
        },

        async actualizarStatusChecklist(data) {
            this.loading_checklist_create = true;
            this.errors_checklist = null;
            try {
                const response = await axios.put('/checklist/update-status/' + data.checklist_id, {
                    status: data.status
                });

                if (response.data.errors) {
                    this.errors_checklist = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors_checklist = 'Failed to load checklist';
                console.error('Error actualizar checklist:', error);
            } finally {
                this.loading_checklist_create = false;
            }
        },

        async eliminarCategoriaChecklist(id) {
            this.loading_checklist_delete = true;
            this.errors_categoria_checklist = null;
            try {
                const response = await axios.delete('/checklist/delete_categoriaChecklist/' + id);

                if (response.data.errors) {
                    this.errors_categoria_checklist = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors_categoria_checklist = 'Failed to load checklist';
                console.error('Error actualizar checklist:', error);
            } finally {
                this.loading_checklist_delete = false;
            }
        },

        async eliminarIntervencionChecklist(id) {
            this.loading_checklist_delete = true;
            this.errors_intervencion_checklist = null;
            try {
                const response = await axios.delete('/checklist/delete_intervencionChecklist/' + id);

                if (response.data.errors) {
                    this.errors_intervencion_checklist = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors_intervencion_checklist = 'Failed to load checklist';
                console.error('Error actualizar checklist:', error);
            } finally {
                this.loading_checklist_delete = false;
            }
        },

        async eliminarObservacionChecklist(id) {
            this.$set(this.loading_checklist_delete_observacion, id, true);
            this.errors_observacion_checklist = null;
            try {
                const response = await axios.delete('/checklist/delete_observacionChecklist/' + id);

                if (response.data.errors) {
                    this.errors_observacion_checklist = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors_observacion_checklist = 'Failed to load checklist';
                console.error('Error actualizar checklist:', error);
            } finally {
                this.$set(this.loading_checklist_delete_observacion, id, false);
            }
        },

        async finalizarChecklist(data, id) {
            this.$set(this.loading_checklist_finish, id, true);
            this.errors_finalizar_checklist = null;
            try {

                const response = await axios.post('/checklist/store_completarChecklist', data, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors || response.data.errors_checks) {
                    this.errors_finalizar_checklist = { 'errors': response.data.errors, 'errors_checks': response.data.errors_checks };
                }

                // Maneja la respuesta exitosa, si es necesario
                return response.data;

            } catch (error) {
                this.errors_finalizar_checklist = 'Failed to load checklist';
                console.error('Error crear checklist:', error);
            } finally {
                this.$set(this.loading_checklist_finish, id, false);
            }
        },

        async descargarPDF(checklist, check_id, check_vehiculo_id, check_vehiculo_detalle_id) {
            this.$set(this.loading_pdf, check_vehiculo_detalle_id, true);
            try {
                const response = await axios({
                    url: '/checklist/pdf',
                    method: 'POST',
                    data: { checklist: checklist, check_id: check_id, check_list_vehiculo_id: check_vehiculo_id, check_list_vehiculo_detalle_id: check_vehiculo_detalle_id },
                    responseType: 'blob'
                });

                const url = window.URL.createObjectURL(response.data, { type: 'application/pdf' });
                window.open(url, '_blank');

            } catch (error) {
                this.errors_reporte = 'Failed to load checklist';
                console.error('Error crear checklist:', error);
            } finally {
                this.$set(this.loading_pdf, check_vehiculo_detalle_id, false);
            }
        },
    }
};
