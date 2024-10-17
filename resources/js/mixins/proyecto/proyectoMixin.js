import axios from 'axios';

export default {
    data() {
        return {
            proyectos: [],
            loading: false,
            errors: null,
        };
    },
    methods: {

        async fetchProyectosSelect() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/proyectos/all-select');
                this.proyectos = response.data;
            } catch (error) {
                this.errors = 'Failed to load proyectos';
                console.error('Error fetching proyectos:', error);
            } finally {
                this.loading = false;
            }
        },

        async fetchProyectos() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/proyectos/all');
                this.proyectos = response.data;
            } catch (error) {
                this.errors = 'Failed to load proyectos';
                console.error('Error fetching proyectos:', error);
            } finally {
                this.loading = false;
            }
        },

        async createProyecto(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.post('/proyectos/store', {
                    name: data.name
                });
        
                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors = response.data.errors;
                }
        
                // Maneja la respuesta exitosa, si es necesario
                return response.data;
        
            } catch (error) {
                this.errors = 'Failed to load proyecto';
                console.error('Error crear proyecto:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarProyecto(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/proyectos/update/' + data.proyecto_id, {
                    name: data.name
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Failed to load proyecto';
                console.error('Error actualizar proyecto:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarStatus(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/proyectos/update-status/' + data.proyecto_id, {
                    status: data.status
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Failed to load proyecto';
                console.error('Error actualizar proyecto:', error);
            } finally {
                this.loading = false;
            }
        }
    }
};
