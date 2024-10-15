import axios from 'axios';

export default {
    data() {
        return {
            matrizChecklist: [],
            loading_matriz: false,
            loading_matriz_create: false,
            loading_matriz_delete: false,
            loading_matriz_finish: false,
            loading_matriz_update: false,
            errors_matriz_checklist: null,
            errors_categoria_matriz_checklist: null,
            errors_intervencion_matriz_checklist: null,
        };
    },
    methods: {

        async fetchMatrizChecklist() {
            this.loading_matriz = true;
            this.errors_matriz_checklist = null;
            try {
                const response = await axios.get('/api/matrizchecklist/all');
                this.matrizChecklist = response.data;
            } catch (error) {
                this.errors_matriz_checklist = 'Failed to load matrizChecklist';
                console.error('Error fetching matrizChecklist:', error);
            } finally {
                this.loading_matriz = false;
            }
        },

        async createMatrizChecklist(data) {
            this.loading_matriz_create = true;
            this.errors_matriz_checklist = null;
            try {
                const response = await axios.post('/api/matrizchecklist/store_matrizChecklist', {
                    nombre: data.nombre
                });
        
                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors_matriz_checklist = response.data.errors;
                }
        
                // Maneja la respuesta exitosa, si es necesario
                return response.data;
        
            } catch (error) {
                this.errors_matriz_checklist = 'Failed to load matrizChecklist';
                console.error('Error crear matrizChecklist:', error);
            } finally {
                this.loading_matriz_create = false;
            }
        },

        async createCategoriaMatrizChecklist(data) {
            this.loading_matriz_create = true;
            this.errors_categoria_matriz_checklist = null;
            try {
                const response = await axios.post('/api/matrizchecklist/store_categoriaMatrizChecklist', {
                    matrizChecklist_id: data.matrizChecklist_id,
                    nombre: data.nombre
                });
        
                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors_categoria_matriz_checklist = response.data.errors;
                }
        
                // Maneja la respuesta exitosa, si es necesario
                return response.data;
        
            } catch (error) {
                this.errors_categoria_matriz_checklist = 'Failed to load matrizChecklist';
                console.error('Error crear matrizChecklist:', error);
            } finally {
                this.loading_matriz_create = false;
            }
        },

        async createIntervencionMatrizChecklist(data) {
            this.loading_matriz_create = true;
            this.errors_intervencion_matriz_checklist = null;
            try {
                const response = await axios.post('/api/matrizchecklist/store_intervencionMatrizChecklist', {
                    matrizChecklist_categoria_id: data.matrizChecklist_categoria_id,
                    nombre: data.nombre
                });
        
                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors_intervencion_matriz_checklist = response.data.errors;
                }
        
                // Maneja la respuesta exitosa, si es necesario
                return response.data;
        
            } catch (error) {
                this.errors_intervencion_matriz_checklist = 'Failed to load matrizChecklist';
                console.error('Error crear matrizChecklist:', error);
            } finally {
                this.loading_matriz_create = false;
            }
        },

        async eliminarCategoriaMatrizChecklist(id) {
            this.loading_matriz_delete = true;
            this.errors_categoria_matriz_checklist = null;
            try {
                const response = await axios.delete('/api/matrizchecklist/delete_categoriaMatrizChecklist/' + id);

                if (response.data.errors) {
                    this.errors_categoria_matriz_checklist = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors_categoria_matriz_checklist = 'Failed to load matrizChecklist';
                console.error('Error actualizar matrizChecklist:', error);
            } finally {
                this.loading_matriz_delete = false;
            }
        },

        async eliminarIntervencionMatrizChecklist(id) {
            this.loading_matriz_delete = true;
            this.errors_intervencion_matriz_checklist = null;
            try {
                const response = await axios.delete('/api/matrizchecklist/delete_intervencionMatrizChecklist/' + id);

                if (response.data.errors) {
                    this.errors_intervencion_matriz_checklist = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors_intervencion_matriz_checklist = 'Failed to load matrizChecklist';
                console.error('Error actualizar matrizChecklist:', error);
            } finally {
                this.loading_matriz_delete = false;
            }
        },

        async finalizarCreacionMatrizChecklist(id) {
            this.loading_matriz_finish = true;
            this.errors_intervencion_matriz_checklist = null;
            try {
                const response = await axios.put('/api/matrizchecklist/update_matrizChecklist/' + id, {
                    status: true
                });

                if (response.data.errors) {
                    this.errors_intervencion_matriz_checklist = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors_intervencion_matriz_checklist = 'Failed to load matrizChecklist';
                console.error('Error actualizar matrizChecklist:', error);
            } finally {
                this.loading_matriz_finish = false;
            }
        },

        async actualizarStatusMatrizChecklist(data) {
            this.loading_matriz = true;
            this.errors_matriz_checklist = null;
            try {
                const response = await axios.put('/api/matrizchecklist/update-status/' + data.matriz_id, {
                    status: data.status
                });

                if (response.data.errors) {
                    this.errors_matriz_checklist = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors_matriz_checklist = 'Failed to load matrizChecklist';
                console.error('Error actualizar matrizChecklist:', error);
            } finally {
                this.loading_matriz = false;
            }
        },

        async actualizarCategoriaMatrizChecklist(data) {
            this.loading_matriz_update = true;
            this.errors_categoria_matriz_checklist = null;
            try {
                const response = await axios.put('/api/matrizchecklist/update_categoriaMatrizChecklist/' + data.id, {
                    nombre: data.nombre
                });

                if (response.data.errors) {
                    this.errors_categoria_matriz_checklist = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors_categoria_matriz_checklist = 'Failed to load matrizChecklist';
                console.error('Error actualizar matrizChecklist:', error);
            } finally {
                this.loading_matriz_update = false;
            }
        },

        async actualizarIntervencionMatrizChecklist(data) {
            this.loading_matriz_update = true;
            this.errors_intervencion_matriz_checklist = null;
            try {
                const response = await axios.put('/api/matrizchecklist/update_intervencionMatrizChecklist/' + data.id, {
                    nombre: data.nombre
                });

                if (response.data.errors) {
                    this.errors_intervencion_matriz_checklist = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors_intervencion_matriz_checklist = 'Failed to load matrizChecklist';
                console.error('Error actualizar matrizChecklist:', error);
            } finally {
                this.loading_matriz_update = false;
            }
        },
    }
};
