import axios from 'axios';

export default {
    data() {
        return {
            tipo_activos: [],
            loading: false,
            errors: null,
        };
    },
    methods: {
        
        async fetchTipoActivosSelect() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/tipo-activos/all-select');
                this.tipo_activos = response.data;
            } catch (error) {
                this.errors = 'Failed to load tipo_activos';
                console.error('Error fetching tipo_activos:', error);
            } finally {
                this.loading = false;
            }
        },
        
        async fetchTipoActivos() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/tipo-activos/all');
                this.tipo_activos = response.data;
            } catch (error) {
                this.errors = 'Failed to load tipo_activos';
                console.error('Error fetching tipo_activos:', error);
            } finally {
                this.loading = false;
            }
        },

        async createTipoActivos(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.post('/tipo-activos/store', {
                    name: data.name
                });
        
                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors = response.data.errors;
                }
        
                // Maneja la respuesta exitosa, si es necesario
                return response.data;
        
            } catch (error) {
                this.errors = 'Failed to load tipo_activos';
                console.error('Error crear tipo_activos:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarTipoActivos(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/tipo-activos/update/' + data.tipo_activo_id, {
                    name: data.name
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Failed to load tipo_activos';
                console.error('Error actualizar tipo_activos:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarStatus(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/tipo-activos/update-status/' + data.tipo_activo_id, {
                    status: data.status
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Failed to load tipo_activos';
                console.error('Error actualizar tipo_activos:', error);
            } finally {
                this.loading = false;
            }
        }
    }
};
