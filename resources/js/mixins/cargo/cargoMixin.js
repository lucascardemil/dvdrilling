import axios from 'axios';

export default {
    data() {
        return {
            cargos: [],
            loading: false,
            errors: null,
        };
    },
    methods: {
        
        async fetchCargosSelect() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/api/cargos/all-select');
                this.cargos = response.data;
            } catch (error) {
                this.errors = 'Failed to load cargos';
                console.error('Error fetching cargos:', error);
            } finally {
                this.loading = false;
            }
        },
        
        async fetchCargos() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/api/cargos/all');
                this.cargos = response.data;
            } catch (error) {
                this.errors = 'Failed to load cargos';
                console.error('Error fetching cargos:', error);
            } finally {
                this.loading = false;
            }
        },

        async createCargo(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.post('/api/cargos/store', {
                    name: data.name
                });
        
                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors = response.data.errors;
                }
        
                // Maneja la respuesta exitosa, si es necesario
                return response.data;
        
            } catch (error) {
                this.errors = 'Failed to load cargo';
                console.error('Error crear cargo:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarCargo(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/api/cargos/update/' + data.cargo_id, {
                    name: data.name
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Failed to load cargo';
                console.error('Error actualizar cargo:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarStatus(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/api/cargos/update-status/' + data.cargo_id, {
                    status: data.status
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Failed to load cargo';
                console.error('Error actualizar cargo:', error);
            } finally {
                this.loading = false;
            }
        }
    }
};
