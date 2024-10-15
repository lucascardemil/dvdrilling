import axios from 'axios';

export default {
    data() {
        return {
            editChecklist: null,
            completarChecklist: null,
            checklist: [],
            loading_intervenciones: false,
            loading_checklist: false,
            loading_checklist_create: false,
            loading_checklist_delete: false,
            loading_checklist_finish: false,
            errors_checklist: null,
            errors_categoria_checklist: null,
            errors_intervencion_checklist: null,
        };
    },
    methods: {

        async fetchChecklist() {
            this.loading_checklist = true;
            this.errors_checklist = null;
            try {
                const response = await axios.get('/api/checklist/all');
                this.checklist = response.data;
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
                const response = await axios.get('/api/checklist/intervenciones/' + id)
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
                const response = await axios.post('/api/checklist/store_checklist', {
                    marca: data.marca,
                    modelo: data.modelo,
                    activo_id: data.activo_id,
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


        async createIntervencionChecklist(data) {
            this.loading_checklist_create = true;
            this.errors_intervencion_checklist = null;
            try {
                const response = await axios.post('/api/checklist/store_intervencionChecklist', {
                    checklist_id: data.checklist_id,
                    intervenciones: data.intervenciones
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

        
    }
};
