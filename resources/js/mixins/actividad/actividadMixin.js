import axios from 'axios';

export default {
    data() {
        return {
            actividades: [],
            loading: false,
            errors: null,
        };
    },
    methods: {
        
        async fetchActividadesSelect() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/actividades/all-select');
                this.actividades = response.data;
            } catch (error) {
                this.errors = 'Failed to load actividades';
                console.error('Error fetching actividades:', error);
            } finally {
                this.loading = false;
            }
        },
        
        async fetchActividades() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/actividades/all');
                this.actividades = response.data;
            } catch (error) {
                this.errors = 'Failed to load actividades';
                console.error('Error fetching actividades:', error);
            } finally {
                this.loading = false;
            }
        },

        async createActividad(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.post('/actividades/store', {
                    name: data.name
                });
        
                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors = response.data.errors;
                }
        
                // Maneja la respuesta exitosa, si es necesario
                return response.data;
        
            } catch (error) {
                this.errors = 'Failed to load actividad';
                console.error('Error crear actividad:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarActividad(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/actividades/update/' + data.actividad_id, {
                    name: data.name
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Failed to load actividad';
                console.error('Error actualizar actividad:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarStatus(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/actividades/update-status/' + data.actividad_id, {
                    status: data.status
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Failed to load actividad';
                console.error('Error actualizar actividad:', error);
            } finally {
                this.loading = false;
            }
        }
    }
};
