import axios from 'axios';

export default {
    data() {
        return {
            activos: [],
            loading: false,
            errors: null,
        };
    },
    methods: {

        async fetchNombreActivos(name = '') {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/api/activos/buscar-nombre/' + name);
                this.activos = response.data;
            } catch (error) {
                this.errors = 'Failed to load activos';
                console.error('Error fetching activos:', error);
            } finally {
                this.loading = false;
            }
        },

        async fetchActivosSelect() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/api/activos/all-select');
                this.activos = response.data;
            } catch (error) {
                this.errors = 'Failed to load activos';
                console.error('Error fetching activos:', error);
            } finally {
                this.loading = false;
            }
        },

        async fetchActivos() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/api/activos/all');
                this.activos = response.data;
            } catch (error) {
                this.errors = 'Failed to load activos';
                console.error('Error fetching activos:', error);
            } finally {
                this.loading = false;
            }
        },

        async createActivo(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.post('/api/activos/store', {
                    tipo_activo: data.tipo_activo,
                    marca: data.marca,
                    modelo: data.modelo,
                    patente: data.patente,
                    numero_interno: data.numero_interno,
                    year: data.year,
                    horometro: data.horometro,
                    kilometraje: data.kilometraje,
                    color: data.color,
                    chasis: data.chasis,
                    numero_motor: data.numero_motor
                });

                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                // Maneja la respuesta exitosa, si es necesario
                return response.data;

            } catch (error) {
                this.errors = 'Failed to load activo';
                console.error('Error crear activo:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarActivo(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/api/activos/update/' + data.activo_id, {
                    tipo_activo: data.tipo_activo,
                    marca: data.marca,
                    modelo: data.modelo,
                    patente: data.patente,
                    numero_interno: data.numero_interno,
                    year: data.year,
                    horometro: data.horometro,
                    kilometraje: data.kilometraje,
                    color: data.color,
                    chasis: data.chasis,
                    numero_motor: data.numero_motor
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Failed to load activo';
                console.error('Error actualizar activo:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarStatusActivo(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/api/activos/update-status/' + data.activo_id, {
                    status: data.status
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Failed to load activo';
                console.error('Error actualizar activo:', error);
            } finally {
                this.loading = false;
            }
        },


        async actualizarImagenesActivo(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.post('/api/activos/update-imagenes', data, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Failed to load activo';
                console.error('Error actualizar activo:', error);
            } finally {
                this.loading = false;
            }
        }
    }
};
